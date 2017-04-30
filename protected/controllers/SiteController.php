<?php

class SiteController extends FrontController
    {

    private $_identity;

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
//    public function __construct($id, $module = null) {
//        parent::__construct($id, $module);
//
//    }

    public function actionIfSetSession() {
        $resp = [];
        if (!Yii::app()->user->isGuest)
            {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            $resp['is_login'] = 'true';
            $resp['type'] = 'success';
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData->profile_image)
                {
                $resp['profile_img'] = Yii::app()->getBaseUrl(true) . '/upload/usersImage/thumb/' . $userData->profile_image;
                }
            else
                {
                $resp['profile_img'] = Assets::themeUrl("images/avatarImage.jpg");
                }


            if ($userData && $userData->user_type_id == 2)
                {
                $resp['dashboard_url'] = Yii::app()->createUrl('user/bothDashboard');
                }
            else
                {
                $resp['dashboard_url'] = Yii::app()->createUrl('user/manufactureDashboard');
                }

            $resp['user_type'] = $userData->user_type_id;
            $resp['msg'] = 'user is loggedin';
            }
        else
            {
            $resp['is_login'] = 'false';
            $resp['type'] = 'error';
            $resp['msg'] = 'user is not loggedin';
            }
        echo json_encode($resp);
    }

    public function actionIndex() {
        $this->pageName = 'home';
        //$this->layout = "//layouts/default";
        //  $this->body_class = "home";
        $this->isHomePage = TRUE;
        $this->render('index');
    }

    public function actionAboutus() {
        $this->pageName = 'aboutus';
        $this->render('about-us');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {

        if ($error = Yii::app()->errorHandler->error)
            {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                {
                $this->pageName = 'error';
                $this->layout = "//layouts/error";
                $this->render('error', $error);
                }
            }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new Contact;

        if (isset($_POST['Contact']))
            {
            $model->attributes = $_POST['Contact'];
            if ($model->validate())
                {
                $model->status = 38;
                $model->save(FALSE);
//                $email_data = [
//                    'to' => $model->email,
//                    'subject' => 'Successful Sent Enquiry To Decorat3d.com',
//                    'template' => 'email_gen',
//                    'data' => ['model' => $model],
//                ];
//                $this->SendMail($email_data);
                Yii::app()->user->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
                }
            }
        $this->render('contact', array('model' => $model));
    }

    public function actionDesigner() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '')
            {
            $key = $_GET['key'];
            }
        $offset = 0;
        $limit = 4;

        $criteria = new CDbCriteria;
        $criteria->condition = 'status=1 AND user_type_id=2 AND is_designer=1';
        $criteria->order = 'id DESC';
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->addSearchCondition('username', $key);
//        $criteria->addSearchCondition('description',$key);

        $designers = UserMaster::model()->findAll($criteria);
        $this->render('designer', ['designers' => $designers, 'key' => $key, 'offset' => $offset, 'limit' => $limit]);
    }

    public function actionLoadMoreDesigner($key = '', $offset = 0, $limit = 4) {

        if (Yii::app()->request->isAjaxRequest)
            {
            $criteria = new CDbCriteria;
            $criteria->condition = 'status=1 AND user_type_id=2 AND is_designer=1';
            $criteria->order = 'id DESC';
            $criteria->offset = $offset;
            $criteria->limit = $limit;
            $criteria->addSearchCondition('username', $key);

            $designers = UserMaster::model()->findAll($criteria);
            $data = [];
            if ($designers)
                {
                $data['status'] = 'success';
                foreach ($designers as $designer)
                    {
                    $data['msg'] = [];
                    $data['msg'][$designer->id] = [];
                    $data['msg'][$designer->id]['id'] = $designer->id;
                    $data['msg'][$designer->id]['username'] = isset($designer->username) ? $designer->username : "";
                    $data['msg'][$designer->id]['link'] = Yii::app()->createUrl('designers-detail/' . $designer->id . '/' . str_replace(' ', '-', isset($designer->username) ? $designer->username : ''));
                    $data['msg'][$designer->id]['image'] = $designer->profile_image ? Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $designer->profile_image : Assets::themeUrl("images/avatarImage.jpg");

                    if (strlen($designer->description) > 214)
                        {
                        $pos = strpos($designer->description, ' ', 200);
                        $description = substr($designer->description, 0, $pos);
                        }
                    else
                        {
                        $description = $designer->description;
                        }
                    $description = wordwrap($description, 8, "\n", true);
                    $data['msg'][$designer->id]['description'] = $description;

                    $data['msg'][$designer->id]['skillCount'] = count($designer->userskill);
                    $data['msg'][$designer->id]['skillName'] = [];
                    foreach ($designer->userskill as $s_key => $u_skill)
                        {
                        if ($s_key + 1 > 2)
                            {
                            break;
                            }
                        $data['msg'][$designer->id]['skillName'][] = $u_skill->skill->name;
                        }
                    }
                $data['offset'] = $offset;
                $data['limit'] = $limit;
                }
            else
                {
                $data['status'] = 'noMore';
                $data['msg'] = 'There are no more results...';
                $data['offset'] = 0;
                $data['limit'] = 0;
                }
            }
        else
            {
            $data['status'] = 'error';
            $data['msg'] = 'There is an unknown error';
            $data['offset'] = 0;
            $data['limit'] = 0;
            }
        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionDesignerDetail($id) {
        if (isset($id))
            {
            $data['designer'] = $designer = UserMaster::model()->findByAttributes(['id' => $id, 'status' => '1', 'user_type_id' => 2]);

            $data['self_uploaded_catalogs'] = $self_uploaded_catalogs = Catalog::model()->findAllByAttributes(['designer_id' => $id]);

            $is_purchased_design = '';
            $available_jobs = [];

            if (!$designer)
                {
                $this->redirect('index');
                }
            $data['current_designer_review'] = Review::model()->findAllByAttributes(['to_user' => $id, 'status' => '1']);
            if (!Yii::app()->user->isGuest)
                {
                $all_purchased_design = TransactionReport::model()->findAllByAttributes(['user_id' => Yii::app()->user->id, 'bid_type' => '1', 'status' => '23']);

                if ($all_purchased_design)
                    {
                    foreach ($all_purchased_design as $key => $design)
                        {
                        if ($design->bid->user_master_id == $id)
                            {
                            $is_purchased_design = 'true';
                            break;
                            }
                        }
                    }
                $own_purchased_designs = EmployerBoughtDesigns::model()->findAllByAttributes(['employer_id' => Yii::app()->user->id, 'type' => '1']);

                if ($own_purchased_designs)
                    {
                    foreach ($own_purchased_designs as $index => $design)
                        {
                        if ($design->job_bid->user_master_id == $id)
                            {
                            $reviewData = Review::model()->findByAttributes(['by_user' => Yii::app()->user->id, 'to_user' => $id, 'job_bid_id' => $design->job_bid->id]);
                            if (!$reviewData)
                                {
                                $available_jobs[$design->job_bid->id] = isset($available_jobs[$design->job_bid->id]) ? $design->job_bid->job->description : $design->job_bid->job->description;
                                }
                            }
                        }
                    }
                $data['model'] = $reviewModel = new Review();
                }
            $data['is_purchased_design'] = $is_purchased_design;
            $data['available_jobs'] = $available_jobs;
            $this->render('designer_detail', $data);
            }
        else
            {
            $this->redirect('index');
            }
    }

    public function actionAddReview() {
        $resp = [];
        if (isset($_POST['Review']))
            {
            $model = new Review('review_form');
            $model->attributes = $_POST['Review'];
            $model->by_user = Yii::app()->user->id;
            $model->to_user = $_POST['to_user'];
            $model->rating = isset($_POST['Review']['rating']) ? $_POST['Review']['rating'] : '0';
            $model->status = 1;
            if ($model->save())
                {
                $resp['type'] = 'success';
                $resp['msg'] = 'You have successfully reviewed the designer';
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = $model->getErrors();
                }
            }
        else
            {
            $resp['type'] = 'error';
            $resp['msg'] = 'No data given';
            }
        echo json_encode($resp);
    }

    public function actionManufacturer() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '')
            {
            $key = $_GET['key'];
            }
        $offset = 0;
        $limit = 6;

        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1 AND user_type_id = 3';
        $criteria->order = 'id DESC';
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->addSearchCondition('username', $key);
//        $criteria->addSearchCondition('description',$key);

        $manufacturers = UserMaster::model()->findAll($criteria);
        $this->render('manufacturer', ['manufacturers' => $manufacturers, 'key' => $key, 'offset' => $offset, 'limit' => $limit]);
    }

    public function actionLoadMoreManufacturer($key = '', $offset = 0, $limit = 6) {
        if (Yii::app()->request->isAjaxRequest)
            {
            $criteria = new CDbCriteria;
            $criteria->condition = 'status=1 AND user_type_id=3';
            $criteria->order = 'id DESC';
            $criteria->offset = $offset;
            $criteria->limit = $limit;
            $criteria->addSearchCondition('username', $key);

            $designers = UserMaster::model()->findAll($criteria);
            $data = [];
            if ($designers)
                {
                $data['status'] = 'success';
                foreach ($designers as $designer)
                    {
                    $data['msg'] = [];
                    $data['msg'][$designer->id] = [];
                    $data['msg'][$designer->id]['id'] = $designer->id;
                    $data['msg'][$designer->id]['username'] = isset($designer->username) ? $designer->username : "";
                    $data['msg'][$designer->id]['link'] = Yii::app()->createUrl('designers-detail/' . $designer->id . '/' . str_replace(' ', '-', isset($designer->username) ? $designer->username : ''));
                    $data['msg'][$designer->id]['image'] = $designer->profile_image ? Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $designer->profile_image : Assets::themeUrl("images/avatarImage.jpg");

                    if (strlen($designer->description) > 214)
                        {
                        $pos = strpos($designer->description, ' ', 200);
                        $description = substr($designer->description, 0, $pos);
                        }
                    else
                        {
                        $description = $designer->description;
                        }
                    $description = wordwrap($description, 8, "\n", true);
                    $data['msg'][$designer->id]['description'] = $description;

                    $data['msg'][$designer->id]['skillCount'] = count($designer->userskill);
                    $data['msg'][$designer->id]['skillName'] = [];
                    foreach ($designer->userskill as $s_key => $u_skill)
                        {
                        if ($s_key + 1 > 2)
                            {
                            break;
                            }
                        $data['msg'][$designer->id]['skillName'][] = $u_skill->skill->name;
                        }
                    }
                $data['offset'] = $offset;
                $data['limit'] = $limit;
                }
            else
                {
                $data['status'] = 'noMore';
                $data['msg'] = 'There are no more results...';
                $data['offset'] = 0;
                $data['limit'] = 0;
                }
            }
        else
            {
            $data['status'] = 'error';
            $data['msg'] = 'There is an unknown error';
            $data['offset'] = 0;
            $data['limit'] = 0;
            }
        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionManufacturerDetail($id) {
        if (isset($id))
            {
            $data['manufacturer'] = $manufacturer = UserMaster::model()->findByAttributes(['id' => $id, 'status' => '1', 'user_type_id' => '3']);
            $is_purchased_design = '';
            $available_jobs = [];
            if (!$manufacturer)
                {
                $this->redirect('index');
                }
            $data['current_manufacturer_review'] = ManufacturerReview::model()->findAllByAttributes(['to_user' => $id, 'status' => '1']);
            $allBids = ManufacturerJobBid::model()->findAllByAttributes(['manufacturer_id' => $manufacturer->id]);
            if ($allBids)
                {
                foreach ($allBids as $allBids_index => $bid)
                    {
                    $all_purchased_design = TransactionReport::model()->findByAttributes(['bid_type' => '2', 'bid_id' => $bid->id, 'status' => '23']);
                    if ($all_purchased_design)
                        {
                        if ($all_purchased_design->manufacturerbid->type == '1')
                            {
                            $uploaded_file = 'jobs/thumb/' . $all_purchased_design->manufacturerbid->bid->uploaded_file;
                            }
                        else
                            {
                            $uploaded_file = 'catalog/thumb/' . $all_purchased_design->manufacturerbid->catalog->uploaded_file;
                            }
                        $bidData[$bid->id]['uploaded_file'] = isset($data[$bid->id]['uploaded_file']) ? $uploaded_file : $uploaded_file;
                        }
                    }
                }
            $data['uploaded_file'] = $bidData;
            if (!Yii::app()->user->isGuest)
                {
                $all_purchased_design = TransactionReport::model()->findAllByAttributes(['user_id' => Yii::app()->user->id, 'bid_type' => '2', 'status' => '23']);

                if ($all_purchased_design)
                    {
                    foreach ($all_purchased_design as $key => $design)
                        {
                        if ($design->manufacturerbid->manufacturer_id == $id)
                            {
                            $is_purchased_design = 'true';
                            break;
                            }
                        }
                    }

                $own_purchased_designs = EmployerBoughtDesigns::model()->findAllByAttributes(['employer_id' => Yii::app()->user->id, 'type' => '2']);

                if ($own_purchased_designs)
                    {
                    foreach ($own_purchased_designs as $index => $design)
                        {
                        if ($design->manufacturer_job_bid->manufacturer_id == $id)
                            {
                            $reviewData = ManufacturerReview::model()->findByAttributes(['by_user' => Yii::app()->user->id, 'to_user' => $id, 'job_bid_id' => $design->manufacturer_job_bid->id]);
                            if (!$reviewData)
                                {
                                $available_jobs[$design->manufacturer_job_bid->id] = isset($available_jobs[$design->manufacturer_job_bid->id]) ? $design->manufacturer_job_bid->job->description : $design->manufacturer_job_bid->job->description;
                                }
                            }
                        }
                    }
                $data['model'] = $reviewModel = new ManufacturerReview();
                }
            $data['is_purchased_design'] = $is_purchased_design;
            $data['available_jobs'] = $available_jobs;
            $this->render('manufacturer_detail', $data);
            }
        else
            {
            $this->redirect('index');
            }
    }

    public function actionAddManufacturerReview() {
        $resp = [];

        if (isset($_POST['ManufacturerReview']))
            {
            $model = new ManufacturerReview('ManufacturerReview');
            $model->attributes = $_POST['ManufacturerReview'];
            $model->by_user = Yii::app()->user->id;
            $model->to_user = $_POST['to_user'];
            $model->rating = isset($_POST['ManufacturerReview']['rating']) ? $_POST['ManufacturerReview']['rating'] : '0';
            $model->status = 1;
            if ($model->save())
                {
                $resp['type'] = 'success';
                $resp['msg'] = 'You have successfully reviewed the designer';
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = $model->getErrors();
                }
            }
        else
            {
            $resp['type'] = 'error';
            $resp['msg'] = 'No data given';
            }
        echo json_encode($resp);
    }

    public function actionHowitworks() {

        $data['how_it_works_upper'] = $this->getCmsContent('how_it_works_upper');
        $data['how_it_works_middle'] = $this->getCmsContent('how_it_works_middle');
        $data['how_it_works_lower'] = $this->getCmsContent('how_it_works_lower');

        $this->render('how_it_works', $data);
    }

    public function actionGallery() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '')
            {
            $key = $_GET['key'];
            }
        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1';
        $criteria->limit = 4;
        $criteria->offset = 0;
        $criteria->addSearchCondition('title', $key);
        $data['catalog'] = $catalog = Catalog::model()->findAll($criteria);
        $data['limit'] = 4;
        $data['key'] = $key;
        $data['offset'] = 0;
        $this->render('gallery', $data);
    }

    public function actionGalleryLoadMore($key, $limit, $offset) {
        $resp = [];

        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1';
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->addSearchCondition('title', $key);
        $data['catalog'] = $catalog = Catalog::model()->findAll($criteria);
        $resp['limit'] = $data['limit'] = $limit;
        $resp['offset'] = $data['offset'] = $offset;
        if (count($catalog) > 0)
            {
            $resp['type'] = 'success';
            $resp['msg'] = 'Data loaded successfully';
            $resp['html'] = $this->renderPartial('_gallery', $data, true, false);
            }
        else
            {
            $resp['type'] = 'nomore';
            $resp['msg'] = 'No more results found!';
            $resp['html'] = '';
            }


        echo json_encode($resp);
        die();
    }

    public function actionSocialSiteLogin() {
        $serviceName = Yii::app()->request->getQuery('service');
        $userType = Yii::app()->request->getQuery('type');
        if (isset($serviceName))
            {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);

            if ($userType == 'employee')
                {
                $user_type_id = '2';
                $eauth->redirectUrl = $this->createUrl('/Dashboard');
                $eauth->cancelUrl = $this->createUrl('/signup');
                }
            else
                {
                $user_type_id = '3';
                $eauth->redirectUrl = $this->createUrl('/ManufacturerDashboard');
                $eauth->cancelUrl = $this->createUrl('/manufacturer-signup');
                }

            //$eauth->redirectUrl = $this->createAbsoluteUrl('/user/bothDashboard');
            //Yii::app()->user->returnUrl;
            //$eauth->cancelUrl = $this->createAbsoluteUrl('/signup');
            try {
                if ($eauth->authenticate())
                    {
                    $identity = new EAuthUserIdentity($eauth);


                    // successful authentication
                    if ($identity->authenticate())
                        {

                        switch ($serviceName) {
                            case 'facebook':
                                $info = $eauth->getAttributes();

                                $user_data = UserMaster::model()->findByAttributes(array("email" => $info['email']));
                                if (empty($user_data))
                                    {

                                    //insert all of the facebook data and create a new user as in facebook type
                                    $model = new UserMaster ();
                                    $model->scenario = 'socialSite';
                                    $model->email = $info['email'];

                                    $model->user_type_id = $user_type_id;
                                    $model->status = 1;
                                    $model->created_at = date('Y-m-d H:i:s');
                                    $model->updated_at = date('Y-m-d H:i:s');
                                    $model->save(false);

                                    $this->_identity = new oAuthIdentity($info['email']);
                                    $this->_identity->authenticate();
                                    }
                                else
                                    {

                                    $this->_identity = new oAuthIdentity($user_data->email);
                                    $this->_identity->authenticate();
                                    }

                                Yii::app()->user->login($this->_identity);
                                break;
                            case 'twitter':
                                $info = $eauth->getAttributes();
                                //print_r($info);exit;
                                $twitter_id = $info['id'];
                                $user_data = UserMaster::model()->findByAttributes(array("username" => $info['username']));
                                if (empty($user_data))
                                    {

                                    //insert all of the facebook data and create a new user as in facebook type
                                    $model = new UserMaster ();
                                    $model->scenario = 'socialSiteUserName';
                                    $model->username = $info['username'];
                                    $model->email = '';
                                    $model->name = $info['name'];
                                    $model->user_type_id = $user_type_id;
                                    $model->status = '1';
                                    $model->created_at = date('Y-m-d H:i:s');
                                    $model->updated_at = date('Y-m-d H:i:s');
                                    $model->save(false);


                                    $this->_identity = new oAuthIdentity($info['username']);
                                    $this->_identity->authenticate_username();
                                    $twitter_id = $info['id'];
                                    }
                                else
                                    {

                                    $this->_identity = new oAuthIdentity($user_data->username);
                                    $this->_identity->authenticate_username();
                                    }

                                Yii::app()->user->login($this->_identity);
                                break;

                            case 'linkedin':
                                $info = $eauth->getAttributes();
                                //print_r($info);exit;
                                $linkedin_id = $info['id'];
                                $user_data = UserMaster::model()->findByAttributes(array("email" => $info['email']));
                                if (empty($user_data))
                                    {

                                    //insert all of the facebook data and create a new user as in facebook type
                                    $model = new UserMaster ();
                                    $model->scenario = 'socialSite';
                                    $model->email = $info['email'];
                                    $model->name = $info['first_name'] . ' ' . $info['last_name'];
                                    $model->user_type_id = $user_type_id;
                                    $model->status = 1;
                                    $model->created_at = date('Y-m-d H:i:s');
                                    $model->updated_at = date('Y-m-d H:i:s');
                                    $model->save(false);

                                    $this->_identity = new oAuthIdentity($info['email']);
                                    $this->_identity->authenticate();
                                    }
                                else
                                    {

                                    $this->_identity = new oAuthIdentity($user_data->email);
                                    $this->_identity->authenticate();
                                    }

                                Yii::app()->user->login($this->_identity);

                            case 'google_oauth':
                                $info = $eauth->getAttributes();
                                $google_id = $info['id'];
                                $user_data = UserMaster::model()->findByAttributes(array("email" => $info['email']));
                                if (empty($user_data))
                                    {

                                    //insert all of the facebook data and create a new user as in facebook type
                                    $model = new UserMaster ();
                                    $model->scenario = 'socialSite';
                                    $model->email = $info['email'];
                                    $model->name = $info['first_name'] . ' ' . $info['last_name'];
                                    $model->user_type_id = $user_type_id;
                                    $model->status = '1';
                                    $model->created_at = date('Y-m-d H:i:s');
                                    $model->updated_at = date('Y-m-d H:i:s');
                                    $model->save(false);


                                    $this->_identity = new oAuthIdentity($info['email']);
                                    $this->_identity->authenticate();
                                    $google_id = $info['id'];
                                    }
                                else
                                    {

                                    $this->_identity = new oAuthIdentity($user_data->email);
                                    $this->_identity->authenticate();
                                    }

                                Yii::app()->user->login($this->_identity);
                                break;
                        }


                        $eauth->redirect();
                        }
                    else
                        {
                        // close popup window and redirect to cancelUrl
                        $eauth->cancel();
                        }
                    }
                // Something went wrong, redirect back to login page
                $this->redirect($eauth->getCancelUrl());
            } catch (EAuthException $e) {
                print_r($e->getMessage());
                exit;
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: ' . $e->getMessage());
                // close popup window and redirect to cancelUrl
                $eauth->redirect($eauth->getCancelUrl());
            }
            }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new UserLoginForm('login');
        if (!Yii::app()->user->isGuest)
            {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData && $userData->user_type_id == 2)
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
                }
            }
        // if it is ajax validation request
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
        // collect user input data
        if (isset($_POST['UserLoginForm']))
            {
            $model->attributes = $_POST['UserLoginForm'];
            $model->username = ltrim($_POST['UserLoginForm']['username']);
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                {
                $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                if (isset($_GET['return_url']) && $_GET['return_url'] != '')
                    {
                    $this->redirect($_GET['return_url']);
                    }
                if ($userData && $userData->user_type_id == 2)
                    {
                    $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                    }
                else
                    {
                    $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
                    }
                }
            }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionSignup() {
        if (!Yii::app()->user->isGuest)
            {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData && $userData->user_type_id == 2)
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
                }
            }
        $msg = '';
        $model = new UserMaster('register');
        $securityQuestions = CHtml::listData(SecurityQuestion::model()->findAllByAttributes(['status' => 1]), 'id', 'question');
        $tcData = Cms::model()->findByAttributes(['slug' => 'tc']);
        if (isset($_POST['UserMaster']))
            {
            $model->attributes = $_POST['UserMaster'];
            $model->user_type_id = 2;
            if ($model->validate())
                {
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                    $recaptcha = $_POST['g-recaptcha-response'];
                    if (!empty($recaptcha))
                        {
                        //include("getCurlData.php");
                        $google_url = "https://www.google.com/recaptcha/api/siteverify";
                        $recaptcha_secretkey = Settings::model()->findByAttributes(array('slug' => 'google_recaptcha_secret_key'));
                        $secret = $recaptcha_secretkey->value; //Google Secret Key
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
                        $res = self::getCurlData($url);
                        $res = json_decode($res, true);
//reCaptcha success check
                        if ($res['success'])
                            {
                            $model->password = md5($_POST['UserMaster']['password']);
                            $token = md5('activation_' . $model->password . time());
                            $model->activation_code = $token;
                            $model->status = 0;

                            $model->save(false);
                            $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'registration'));
                            $name = $model->username;
                            $activation_link = "<a href=" . Yii::app()->getBaseUrl(true) . '/registration/' . $token . '/verification' . ">Click Here </a>";
                            $data_array = array($name, $activation_link);
                            $replace_array = array("{{name}}", "{{activation_link}}");

                            $email_content = str_replace($replace_array, $data_array, $email_body->body);
                            $email_data = [
                                'to' => $model->email,
                                'subject' => $email_body->subject,
                                'template' => 'email_gen',
                                'data' => ['email_content' => $email_content],
                            ];
                            $this->SendMail($email_data);
                            Yii::app()->user->setFlash('success', 'We\'ve just sent a confirmation link to your registered email id. Just click the link in that email & you\'re in!');
                            $this->redirect([ 'login']);
                            }
                        else
                            {
                            $msg = "Please re-enter your reCAPTCHA.";
                            }
                        }
                    else
                        {
                        $msg = "Please re-enter your reCAPTCHA.";
                        }
                    }
                }
            }
        //$data_msg['captcha_msg'] = $msg;
        $this->render('signup', ['model' => $model, 'securityQuestions' => $securityQuestions, 'tc' => $tcData->content_en, 'captcha_msg' => $msg]);
    }

    protected function getCurlData($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }

    public function actionManufactureSignup() {
        if (!Yii::app()->user->isGuest)
            {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData && $userData->user_type_id == 2)
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
                }
            }
        $msg = '';
        $model = new UserMaster('register');
        $securityQuestions = CHtml::listData(SecurityQuestion::model()->findAllByAttributes(['status' => 1]), 'id', 'question');
        $tcData = Cms::model()->findByAttributes(['slug' => 'tc']);
        if (isset($_POST['UserMaster']))
            {
            $model->attributes = $_POST['UserMaster'];
            $model->user_type_id = 3;
            if ($model->validate())
                {
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                    $recaptcha = $_POST['g-recaptcha-response'];
                    if (!empty($recaptcha))
                        {
//include("getCurlData.php");
                        $google_url = "https://www.google.com/recaptcha/api/siteverify";
                        $recaptcha_secretkey = Settings::model()->findByAttributes(array('slug' => 'google_recaptcha_secret_key'));
                        $secret = $recaptcha_secretkey->value; //Google Secret Key
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
                        $res = self::getCurlData($url);
                        $res = json_decode($res, true);
//reCaptcha success check
                        if ($res['success'])
                            {
                            $model->password = md5($_POST['UserMaster']['password']);
                            $token = md5('activation_' . $model->password . time());
                            $model->activation_code = $token;
                            $model->status = 0;
                            $model->save(false);
                            $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'registration'));
                            $name = $model->username;
                            $activation_link = "<a href=" . Yii::app()->getBaseUrl(true) . '/registration/' . $token . '/verification' . ">Click Here </a>";
                            $data_array = array($name, $activation_link);
                            $replace_array = array("{{name}}", "{{activation_link}}");

                            $email_content = str_replace($replace_array, $data_array, $email_body->body);
                            $email_data = [
                                'to' => $model->email,
                                'subject' => $email_body->subject,
                                'template' => 'email_gen',
                                'data' => ['email_content' => $email_content],
                            ];
                            Yii::app()->user->setFlash('success', 'We\'ve just review your form detail. we will get back to you very soon.');
                            $this->redirect(['login']);
//                $this->SendMail($email_data);
                            }
                        else
                            {
                            $msg = "Please re-enter your reCAPTCHA.";
                            }
                        }
                    else
                        {
                        $msg = "Please re-enter your reCAPTCHA.";
                        }
                    }
                }
            else
                {
//                echo "<pre>";
//                print_r($model->getErrors());
//                echo "</pre>";
//                exit;
                }
            }

        $this->render('manufacture_signup', ['model' => $model, 'securityQuestions' => $securityQuestions, 'tc' => $tcData->content_en, 'captcha_msg' => $msg]);
    }

    public function actionUser_acc_verification($id) {

        if (!Yii::app()->user->isGuest)
            {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData && $userData->user_type_id == 2)
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
                }
            }
        if (isset($id) && $id != '')
            {
            $userData = UserMaster::model()->findByAttributes(['activation_code' => $id]);
            if ($userData)
                {
                $userData->status = 1;
                $userData->activation_code = '';
                $userData->save(FALSE);
                $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'acc_verification'));
                $name = $userData->name;
                $login_link = "<a href=" . Yii::app()->createUrl('site/login') . ">Click Here </a>";
                $data_array = array($name, $login_link);
                $replace_array = array("{{name}}", "{{login_link}}");

                $email_content = str_replace($replace_array, $data_array, $email_body->body);
                $email_data = [
                    'to' => $userData->email,
                    'subject' => $email_body->subject,
                    'template' => 'email_gen',
                    'data' => ['email_content' => $email_content],
                ];
                $this->SendMail($email_data);

                Yii::app()->user->setFlash('success', 'You are successfully verified.You can now login to your account');
                $this->redirect(Yii::app()->createUrl('site/login'));
                }
            else
                {
                Yii::app()->user->setFlash('error', 'Invalid link');
                $this->redirect(Yii::app()->createUrl('site/signup'));
                }
            }
        else
            {
            $this->redirect(Yii::app()->createUrl('site/login'));
            }
    }

    public function actionFbRedirectHome() {
        $this->layout = '//layout/without-header';
        $this->render('fb_processing');
    }

    public function actionCmsContent() {
        if (isset($_GET['slug']) && $_GET['slug'])
            {
            $cmsContent = $this->getCmsContent($_GET['slug']);
            $this->render('cmsContent', ['cmsContent' => $cmsContent]);
            }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->controller->createUrl('login'));
    }

    public function action3d() {
        $this->render('3d');
    }

    public function actionCanvasToImage() {
        $posted_image_content = isset($_POST['uploaded_file']) ? $_POST['uploaded_file'] : '';
        $filename = isset($_POST['file_name']) ? $_POST['file_name'] : '';
        $org_file_name = explode(".", $filename);
        $uploadDir = isset($_POST['uploadDir']) ? $_POST['uploadDir'] : '';
        if (!file_exists(Yii::app()->basePath . '/../upload/' . $uploadDir . '/' . $org_file_name[0] . '.jpg'))
            {
            $image_content = explode(",", $posted_image_content);

            $str = base64_decode($image_content[1]);
            $new_image_name = $org_file_name[0] . ".jpg";
            $user_temp_image_with_path = Yii::app()->basePath . '/../upload/' . $uploadDir . '/' . $new_image_name;
            file_put_contents($user_temp_image_with_path, $str);
            $image = new EasyImage(Yii::app()->basePath . '/../upload/' . $uploadDir . '/' . $new_image_name);
            $image->resize(225, 225);
            $image->save(Yii::app()->basePath . '/../upload/' . $uploadDir . '/thumb/' . $new_image_name);
            }
        else
            {
            "<pre>";
            print_r('b');
            echo "</pre>";
            }
    }

    }
