<?php

class DisputeController extends FrontController {

    public function actionReportDispute($type = "1", $disputeFrom = "1") {
        if (Yii::app()->request->isAjaxRequest) {
            $data_msg = [];
            if (isset($_POST['bidding_id'], $_POST['reason'])) {
                $bidding_id = $_POST['bidding_id'];
                $reason = $_POST['reason'];

                $jobBid = JobBid::model()->findByPk($bidding_id);
                $disputeThread = new DisputeThread('create');

                $disputeThread->track_id = $jobBid->id;
                $disputeThread->type = $type;
                $disputeThread->dispute_from = $disputeFrom;
                $disputeThread->user_master_id = Yii::app()->user->id;
                $disputeThread->reason = $reason;
                $disputeThread->status = "1";

                if ($disputeThread->save()) {
                    $data_msg['msg'] = 'success';
                } else {
                    $data_msg['msg'] = 'error';
                    $data_msg['reason'] = $disputeThread . getErrors();
                }
            } else {
                $data_msg['msg'] = 'error';
                $data_msg['reason'] = 'You must give a reason';
            }
            echo json_encode($data_msg);
            Yii::app()->end();
        }
    }

    public function actionDisputeServices() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
        }
        $this->layout = '//layouts/dashboard';

        $user = UserMaster::model()->findByPk(Yii::app()->user->id);
        $jobs = $user->jobs;
        $jobBids = [];
        foreach ($jobs as $job) {
            $jobBids = array_merge($jobBids, $job->jobBids);
        }
        $jobBids = array_merge($jobBids, $user->jobBid);

        $disputes = [];
        foreach ($jobBids as $jobBid) {
            $disputes[] = $jobBid->disputeThread;
        }
        $disputes = array_filter($disputes);
        $disputes = array_map('unserialize', array_unique(array_map('serialize', $disputes)));

        $this->render("dusputeservices", ['disputes' => $disputes]);
    }

    public function actionConversations($disputeThreadId) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
        }
        $this->layout = '//layouts/dashboard';
        $disputeThread = DisputeThread::model()->findByPk($disputeThreadId);

        $this->render("dispute-conversation", ['disputeThread' => $disputeThread]);
    }

    public function actionComment($disputeThreadId) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = [];
            if (!isset($_POST['conversation'])) {
                $data['status'] = 'error';
                $data['msg'] = 'Review must not be blank';
            } else {
                $disputeConversation = new DisputeConversation('create');

                $disputeConversation->dispute_thread_id = $disputeThreadId;
                $disputeConversation->user_id = Yii::app()->user->id;
                $disputeConversation->message = $_POST['conversation'];
                $disputeConversation->status = "1";
                if ($disputeConversation->save()) {
                    $data['status'] = 'success';
                    $user = UserMaster::model()->findByPk(Yii::app()->user->id);
                    $data['image'] = Yii::app()->request->baseUrl . ($user->profile_image != "" ? '/upload/usersImage/thumb/' . $user->profile_image : '/themes/frontend/assets/images/img1.png');
                    $data['review'] = $disputeConversation->message;
                    $data['username'] = $user->username;
                    $data['created_at'] = date("j.n.Y", strtotime($disputeConversation->created_at));
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = $disputeConversation->getErrors();
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
