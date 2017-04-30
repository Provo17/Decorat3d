<?php

class ChatController extends FrontController {

    public function actionConversation() {
        $data['requisted_chat_thread_id'] = $chat_id = isset($_GET['cid']) ? $_GET['cid'] : '';
        $data['chatThreads'] = $chatThreads = ChatMaster::model()->findAllByAttributes(['started_by' => Yii::app()->user->id]);
        $data['chatThread1'] = $chatThreads = ChatMaster::model()->findAllByAttributes(['started_to' => Yii::app()->user->id]);
        $data['chatInboxModel'] = $chatInboxModel = new ChatInbox;
        $this->render('conversation', $data);
    }
    public function actionManufacturerConversation() {
        $data['chatThreads'] = $chatThreads = ChatMaster::model()->findAllByAttributes(['started_to' => Yii::app()->user->id]);
        $data['chatInboxModel'] = $chatInboxModel = new ChatInbox;
        $this->render('manufacturer_conversation', $data);
    }
    
    

    public function actionChatHeart() {
     
        $resp = [];
        $receiver_id = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : '';
        $track_id = isset($_POST['track_id']) ? $_POST['track_id'] : '';
        $type = '';
        if (isset($_POST['type'])) {
            if ($_POST['type'] == 'designer_bid')
                $type = 1;
        }
        $is_chatThread = ChatMaster::model()->findByAttributes(['started_by' => Yii::app()->user->id, 'started_to' => $receiver_id, 'type' => $type, 'track_id' => $track_id]);
        if (!$is_chatThread) {
            //==== Creating Chat Thread for this project ========//
            $chatMasterModel = new ChatMaster;
            $chatMasterModel->track_id = $track_id;
            $chatMasterModel->started_by = Yii::app()->user->id;
            $chatMasterModel->started_to = $receiver_id;
            $chatMasterModel->type = $type;
            $chatMasterModel->track_status = 1;
            $chatMasterModel->save(FALSE);
           

            $resp['type'] = 'success';
            $resp['msg'] = 'New Chat Thread Created Successfully.';
            $resp['chat_master_id'] = $chatMasterModel->id;
        } else {
            $resp['type'] = 'success';
            $resp['msg'] = 'Chat Thread already exists.';
            $resp['chat_master_id'] = $is_chatThread->id;
        }

        echo json_encode($resp);
        die();
    }

    public function actionAppendChatData() {
        $resp = [];
        if (isset($_POST['chat_master_id'])) {
            $chat_master_id = $_POST['chat_master_id'];
            $data['lastChatData'] = $lastChatData = ChatInbox::model()->findByAttributes(['chat_master_id' => $chat_master_id], ['order' => 'id DESC']);
            $data['conversions'] = $conversions = ChatInbox::model()->findAllByAttributes(['chat_master_id' => $chat_master_id], ['order' => 'id']);

            $resp['type'] = 'success';
            $resp['msg'] = 'successfully loaded the chat content';
            if(count($lastChatData) > 0){
            
            $resp['last_chat_index'] = $lastChatData->id;
            }else{
              $resp['last_chat_index'] = 0;  
            }
            $data['msg'] = Yii::t('string', 'Successfully editted the notes.');
            $resp['html'] = $this->renderPartial('_chatpart', $data, true, true);
        } else {
            $resp['type'] = 'error';
            $resp['msg'] = 'Error! No Chat Thread Posted.';
        }

        echo json_encode($resp);
        exit;
    }

    public function actionDoChat() {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
//        exit;
        $resp = [];
        if (isset($_POST['ChatInbox'])) {
            $model = new ChatInbox;
            $model->message = $_POST['ChatInbox']['message'];
            $model->chat_master_id = $_POST['chat_master_id'];
            $model->sender_id = Yii::app()->user->id;
            $model->receiver_id = $_POST['ChatInbox']['receiver_id'];
            $model->status = 0;
            if ($model->save()) {
                $resp['type'] = 'success';
                $resp['msg'] = 'Successfully added the text';
            } else {
                $resp['type'] = 'error';
                $resp['msg'] = 'Error! Unable to solve the request';
            }
        } else {
            $resp['type'] = 'error';
            $resp['msg'] = 'Error! No data given!';
        }
        echo json_encode($resp);
        die();
    }

    public function actionGetChatMsg() {
        $data_msg = [];
        $chat_master_id = $_POST['chat_master_id'];
        $receiver_id = $_POST['receiver_id'];
        $sender_id = Yii::app()->user->id;
        $last_chat_index = $_POST['last_chat_index'];

        $sql = 'SELECT * FROM `chat_inbox` WHERE `chat_master_id`=' . $chat_master_id . ' AND `id` > ' . $last_chat_index . ' AND ((`sender_id`=' . $sender_id . ' AND `receiver_id`=' . $receiver_id . ') OR (`sender_id`=' . $receiver_id . ' AND `receiver_id`=' . $sender_id . '))';

        $model = Yii::app()->db->createCommand($sql)->queryAll();

        $chat_list = [];
        $last_index="";
        foreach ($model as $row) {
            $u = ChatInbox::model()->findByPk($row['id']);



            $chat_list[$row['id']]['id'] = $row['id'];
            $chat_list[$row['id']]['chat_master_id'] = $row['chat_master_id'];
            $chat_list[$row['id']]['sender_id'] = $row['sender_id'];
            $chat_list[$row['id']]['receiver_id'] = $row['receiver_id'];
            $chat_list[$row['id']]['message'] = $row['message'];
            $chat_list[$row['id']]['username'] = $u->sender->username;
            $chat_list[$row['id']]['time'] = $row['created_at'];
            if ($u->sender->profile_image) {
                $chat_list[$row['id']]['profile_picture'] = Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $u->sender->profile_image;
            } else {
                $chat_list[$row['id']]['profile_picture'] = Assets::themeUrl("images/avatarImage.jpg");
            }
            
            $last_index=$row['id'];
            
        }
        
        $data_msg['last_index']=$last_index;
        
        $data_msg['chat_list'] = $chat_list;

        $sql1 = 'SELECT * FROM `chat_inbox` WHERE `chat_master_id`=' . $chat_master_id . ' AND `id` > ' . $last_chat_index . ' AND `status`=0 AND `sender_id`=' . $receiver_id . ' AND `receiver_id`=' . $sender_id;

        $unread_msg = Yii::app()->db->createCommand($sql1)->queryAll();

        foreach ($unread_msg as $row) {
            $r = ChatInbox::model()->findByPk($row['id']);

            $r->status = 1;
            $r->save(false);
        }


        $chat_thread = ChatMaster::model()->findAllByAttributes(['started_by' => Yii::app()->user->id]);

        $user_msg = [];

        foreach ($chat_thread as $row) {
            $sql1 = 'SELECT * FROM `chat_inbox` WHERE `chat_master_id`=' . $chat_master_id . ' AND `status`=0 AND `sender_id`=' . $row->started_to . ' AND `receiver_id`=' .Yii::app()->user->id ;

            $unread_msg = Yii::app()->db->createCommand($sql1)->queryAll();

            $user_msg[$row->started_to]['id'] = $row->started_to;
            $user_msg[$row->started_to]['total'] = count($unread_msg);
        }

        $data_msg['user_msg'] = $user_msg;
        
        if(count($chat_list) > 0){
          $data_msg['type'] = "success";  
        }else{
            $data_msg['type'] = "warning";  
        }
        
        echo json_encode($data_msg);
        exit();
    }

}
