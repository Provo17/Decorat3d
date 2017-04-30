<?php

class BothDashboardController extends FrontController
    {

    public function actionIsDesigner() {
        $resp = [];
        if (isset($_POST['user_id']))
            {
            $action_type = isset($_POST['action_type']) && $_POST['action_type'] == 'yes' ? 1 : 0;
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            $userData->is_designer = $action_type;
            if ($userData->save(FALSE))
                {
                $resp['type'] = 'success';
                $resp['msg'] = 'You are now designer';
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Error! Unable to save your action.';
                }
            }
        else
            {
            $resp['type'] = 'error';
            $resp['msg'] = 'Error! No data posted';
            }
        echo json_encode($resp);
    }

    public function actionJobDetails($id) {
        if (isset($id) && $id)
            {
            if (Yii::app()->user->isGuest)
                {
                $this->redirect(Yii::app()->createUrl('site/login'));
                }
            $jobDetails = Jobs::model()->findByPk($id);
            $true_bid_transaction_id = '';
            if ($jobDetails)
                {
                $this->layout = '//layouts/dashboard';
                $data = [];
                $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                $data['total_bids'] = $total_bids = count(JobBid::model()->findAllByAttributes(['jobs_id' => $jobDetails->id, 'status' => '1']));
                $data['bids'] = $bids = JobBid::model()->findAllByAttributes(['jobs_id' => $jobDetails->id, 'status' => '1']);
                $is_transaction = '';
                $true_bid = '';
                if ($bids)
                    {
                    foreach ($bids as $bid)
                        {
                        $bid_true = TransactionReport::model()->findByAttributes(['bid_type' => 1, 'status' => '23', 'bid_id' => $bid->id]);

                        if (count($bid_true) > 0)
                            {
                            $is_transaction = 'yes';
                            $true_bid = $bid_true->bid_id;
                            $true_bid_transaction_id = $bid_true->id;
                            break;
                            }
                        }
                    }

                $data['is_transaction'] = $is_transaction;
                $data['true_bid'] = $true_bid;
                $data['true_bid_transaction_id'] = $true_bid_transaction_id;
                $data['model'] = new JobBid();
                $data['jobDetails'] = $jobDetails;
                $data['uploaded_file_err'] = $data['price_err'] = '';
                if (isset($_POST['JobBid']))
                    {
                    $model = new JobBid;
                    $model->attributes = $_POST['JobBid'];
                    $model->user_master_id = $userData->id;
                    $model->jobs_id = $jobDetails->id;
                    $model->status = 0;
                    $uploadedFile = CUploadedFile::getInstance($model, 'uploaded_file');

                    if (!empty($uploadedFile))
                        {
                        $rnd = rand(0, 9999);
                        $fileName = "{$rnd}-{$uploadedFile}";
                        $model->uploaded_file = $fileName;
                        }
                    if ($model->validate())
                        {
                        $model->save();
                        if (!empty($uploadedFile))
                            {
                            $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/jobs/' . $fileName);
                            if ($this->getFileExtention($fileName) != 'stl')
                                {
                                $image = new EasyImage(Yii::app()->basePath . '/../upload/jobs/' . $fileName);
                                $image->resize(225, 225);
                                $image->save(Yii::app()->basePath . '/../upload/jobs/thumb/' . $fileName);
                                }
                            }
                        Yii::app()->user->setFlash('success', "This is the preview of your design.Confirm to place the bid.");
                        $this->redirect(Yii::app()->createUrl('bothDashboard/bidConfirmation', ['id' => $model->id]));
                        }
                    else
                        {
                        $err = $model->getErrors();

                        $data['err'] = "yes";
                        $data['uploaded_file_err'] = isset($err['uploaded_file']) ? $err['uploaded_file'][0] : '';
                        $data['price_err'] = isset($err['price']) ? $err['price'][0] : '';
                        }
                    }
                $this->render('jobDetails', $data);
                }
            else
                {
                
                }
            }
    }

    public function actionBidConfirmation($id) {
        $this->layout = '//layouts/dashboard';
        $model = JobBid::model()->findByPk($id);
        if ($model->status == '1')
            {
            $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
            }
        $this->render('bidconfirmation', ['model' => $model]);
    }

    public function actionBidConfirmationActions() {
        $jobID = isset($_GET['id']) ? $_GET['id'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $model = JobBid::model()->findByPk($jobID);
        if ($model->user_master_id != Yii::app()->user->id)
            {
            $this->redirect(Yii::app()->createUrl('site/logout'));
            }
        else
            {
            if ($model->status == '1')
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                if ($type == 'cancel')
                    {
                    $org_file_name = explode(".", $model->uploaded_file);
                    if ($this->getFileExtention($model->uploaded_file) == 'stl')
                        {
                        unlink(Yii::app()->basePath . '/../upload/jobs/' . $org_file_name[0] . '.jpg');
                        }
                    unlink(Yii::app()->basePath . '/../upload/jobs/thumb/' . $org_file_name[0] . '.jpg');
                    unlink(Yii::app()->basePath . '/../upload/jobs/' . $model->uploaded_file);
                    $model = JobBid::model()->DeleteByPk($jobID);
                    Yii::app()->user->setFlash('success', "You have cancelled the bid.");
                    $this->redirect(Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $model->id]));
                    }
                else
                    {
                    $model->status = '1';
                    $model->save(FALSE);
                    Yii::app()->user->setFlash('success', "You have successfully bidded on the project");
                    $this->redirect(Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $model->jobs_id]));
                    }
                }
            }
    }

    public function actionPostBid($id) {
        
    }

    public function actionPageSetting() {
        if (Yii::app()->user->isGuest)
            {
            $this->redirect(Yii::app()->createUrl('site/login'));
            }

        $this->layout = '//layouts/dashboard';
        $data['model'] = $model = UserMaster::model()->findByPk(Yii::app()->user->id);
        $model->setScenario('user_profile_update');
        $profile_image = $model->profile_image;
        $data['user_skill'] = $user_skill = new UserSkill;
        $user_skills = CHtml::listData(UserSkill::model()->findAllByAttributes(['user_master_id' => $model->id]), 'id', 'skill_id');
        $data['user_skills'] = $u_skills = UserSkill::model()->findAllByAttributes(['user_master_id' => $model->id]);
        $data['all_skills'] = $all_skills = CHtml::listData(Skill::model()->findAllByAttributes(['status' => 1]), 'id', 'name');
        $not_included_skill = [];
        foreach ($all_skills as $s_index => $skill)
            {
            if (!in_array($s_index, $user_skills))
                {
                $not_included_skill[$s_index] = $skill;
                }
            }
        $data['not_included_skills'] = $not_included_skill;

        $data['securityQuestions'] = $securityQuestions = CHtml::listData(SecurityQuestion::model()->findAllByAttributes(['status' => 1]), 'id', 'question');

        if (isset($_POST['form1']))
            {

            $model->attributes = $_POST['UserMaster'];
            $uploadedFile = CUploadedFile::getInstance($model, 'profile_image');

            if (!empty($uploadedFile))
                {
                $rnd = rand(0, 9999);
                $fileName = "{$rnd}-{$uploadedFile}";
                $model->profile_image = $fileName;
                }
            else
                {
                $model->profile_image = $profile_image;
                }
            if ($model->validate())
                {
                $model->save();
                if (!empty($uploadedFile))
                    {
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/usersImage/' . $fileName);
                    $image = new EasyImage(Yii::app()->basePath . '/../upload/usersImage/' . $fileName);
                    $image->resize(225, 225);
                    $image->save(Yii::app()->basePath . '/../upload/usersImage/thumb/' . $fileName);
                    }
                Yii::app()->user->setFlash('success', "Your profile updated successfuly.");
                }
//                else{
//echo "<pre>";
//print_r($model->getErrors());
//echo "</pre>";
//exit;
//                }
            }
        $this->render('page_setting', $data);
    }

    public function actionAddSkill($uid) {
        if (isset($uid) && $uid)
            {
            if (isset($_POST['UserSkill']))
                {

                foreach ($_POST['UserSkill']['skill_id'] as $key => $value)
                    {
                    $userSkill = new UserSkill;
                    $userSkill->skill_id = $value;
                    $userSkill->user_master_id = Yii::app()->user->id;
                    if ($userSkill->validate())
                        {
                        $userSkill->save();
                        Yii::app()->user->setFlash('success', "Skill added successfuly.");
                        $resp['type'] = 'success';
                        $resp['msg'] = 'Skill added successfully';
                        }
                    else
                        {
                        $resp['type'] = 'error';
                        $resp['msg'] = $userSkill->getErrors();
                        }
                    }
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Skill can not be blank.';
                }
            }
        echo json_encode($resp);
    }

    public function actionDeleteSkill($sid) {
        if (isset($sid) && $sid)
            {
            $userSkill = UserSkill::model()->findByPk($sid);
            $user_id = $userSkill->user_master_id;
            if ($userSkill->delete())
                {

                $user_skills = CHtml::listData(UserSkill::model()->findAllByAttributes(['user_master_id' => $user_id]), 'id', 'skill_id');
                $data['user_skills'] = $u_skills = UserSkill::model()->findAllByAttributes(['user_master_id' => $user_id]);
                $data['all_skills'] = $all_skills = CHtml::listData(Skill::model()->findAllByAttributes(['status' => 1]), 'id', 'name');
                $not_included_skill = [];
                foreach ($all_skills as $s_index => $skill)
                    {
                    if (!in_array($s_index, $user_skills))
                        {
                        $not_included_skill[$s_index] = $skill;
                        }
                    }
                $data['not_included_skills'] = $not_included_skill;
                $options = '';
                foreach ($not_included_skill as $key => $value)
                    {
                    $options .= CHtml::tag('option', array('value' => $key), CHtml::encode($value), true);
                    }

                $resp['type'] = 'success';
                $resp['msg'] = 'Skill removed successfully';
                $resp['options'] = $options;
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Skill did not remove';
                }
            }
        echo json_encode($resp);
    }

    public function actionChangePassword($uid) {
        if (isset($uid) && $uid)
            {
            $user = UserMaster::model()->findByPk($uid);
            if ($user)
                {
                $user->setScenario('user_password_change');
                $user->old_password = $_POST['UserMaster']['old_password'];
                $user->new_password = $_POST['UserMaster']['new_password'];
                $user->new_conf_password = $_POST['UserMaster']['new_conf_password'];
                if ($user->validate())
                    {
                    if ($user->initialPassword != md5($_POST['UserMaster']['old_password']))
                        {
                        $resp['type'] = 'error';
                        $resp['msg']['old_password'] = 'Old Password must be repeated exactly.';
                        echo json_encode($resp);
                        die();
                        }
                    $user->password = md5($_POST['UserMaster']['new_password']);
                    if ($user->save(FALSE))
                        {
                        Yii::app()->user->setFlash('success', "Password changed successfully.");
                        $resp['type'] = 'success';
                        $resp['msg'] = 'User password changed successfully';
                        }
                    }
                else
                    {
                    $resp['type'] = 'error';
                    $resp['msg'] = $user->getErrors();
                    }
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Error!sNo user found with this id!';
                }
            }
        echo json_encode($resp);
    }

    public function actionChangeEmail($uid) {
        if (isset($uid) && $uid)
            {
            $user = UserMaster::model()->findByPk($uid);
            $user_pass = $user->password;
            if ($user)
                {
                $user->setScenario('user_email_change');
                $user->email = $_POST['UserMaster']['email'];
                $user->password = $_POST['UserMaster']['password'];
                $user->new_conf_email = $_POST['UserMaster']['new_conf_email'];
                $user->new_email = $_POST['UserMaster']['new_email'];
                if ($user->validate())
                    {
                    if ($user->email != $_POST['UserMaster']['email'])
                        {
                        $resp['type'] = 'error';
                        $resp['msg']['curr_email'] = 'Current Email must be repeated exactly.';
                        echo json_encode($resp);
                        die();
                        }

                    if ($user_pass != md5($_POST['UserMaster']['password']))
                        {
                        $resp['type'] = 'error';
                        $resp['msg']['curr_password'] = 'Password does not match.';
                        echo json_encode($resp);
                        die();
                        }
                    $if_email_exists = UserMaster::model()->findByAttributes(['email' => $user->new_email]);
                    if ($if_email_exists)
                        {
                        $resp['type'] = 'error';
                        $resp['msg']['new_conf_email'] = 'This email already exists.';
                        echo json_encode($resp);
                        die();
                        }
                    $user->password = md5($_POST['UserMaster']['password']);
                    $user->email = $user->new_email;
                    if ($user->save(FALSE))
                        {
                        Yii::app()->user->setFlash('success', "Email changed successfully.");
                        $resp['type'] = 'success';
                        $resp['msg'] = 'User Email changed successfully';
                        }
                    }
                else
                    {
                    $resp['type'] = 'error';
                    $resp['msg'] = $user->getErrors();
                    }
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Error!sNo user found with this id!';
                }
            }
        echo json_encode($resp);
    }

    public function actionUpdateFinacialDetail($uid) {
        $resp = [];
        if (isset($uid) && $uid)
            {
            if ($uid != Yii::app()->user->id)
                {
                $resp['type'] = 'error';
                $resp['gmsg'] = 'Error! Access Denied.';
                }
            else
                {
                $userData = UserMaster::model()->findByPk($uid);
                if ($userData)
                    {
                    if (isset($_POST['UserMaster']))
                        {
                        $userData->setScenario('user_facc_details');
                        $userData->paypal_marchant_email = $_POST['UserMaster']['paypal_marchant_email'];
                        $userData->bank_acc_no = $_POST['UserMaster']['bank_acc_no'];
                        $userData->routing_no = $_POST['UserMaster']['routing_no'];
                        if ($userData->save())
                            {
                            $resp['type'] = 'success';
                            $resp['msg'] = 'Successfully Updated The Account Details.';
                            }
                        else
                            {
                            $resp['type'] = 'error';
                            $resp['msg'] = $userData->getErrors();
                            }
                        }
                    else
                        {
                        $resp['type'] = 'error';
                        $resp['gmsg'] = 'Error! No Data Posted.';
                        }
                    }
                else
                    {
                    $resp['type'] = 'error';
                    $resp['gmsg'] = 'Error! No User Data Found.';
                    }
                }
            }
        else
            {
            $resp['type'] = 'error';
            $resp['gmsg'] = 'Error! No user id is given';
            }
        echo json_encode($resp);
        die();
    }

    public function actionShowBidImage() {
        if (isset($_GET['b_id']) && $_GET['b_id'] != '')
            {
            $bidData = JobBid::model()->findByPk($_GET['b_id']);
            if ($bidData)
                {
                $resp['type'] = 'success';
                $resp['img_src'] = '';
                $resp['img_type'] = '';
                if ($this->getFileExtention($bidData->uploaded_file) == 'stl')
                    {
                    $data['rawImage'] = $bidData->uploaded_file;
                    $resp['img_type'] = '3d';
                    $resp['content'] = $this->renderPartial('view3dDesign', $data, true, FALSE);
                    $org_file_name = explode(".", $bidData->uploaded_file);
                    $resp['img_src'] = Yii::app()->baseUrl . '/upload/jobs/' . $org_file_name[0] . '.jpg';
                    }
                else
                    {
                    $resp['img_src'] = Yii::app()->baseUrl . '/upload/jobs/' . $bidData->uploaded_file;
                    $resp['img_type'] = '';
                    }
                }
            }
        echo json_encode($resp);
        die();
    }

    public function actionShow3dBidImage() {
        $data['rawImage'] = $_GET['rawImage'];

        $resp['type'] = 'success';
        $resp['msg'] = Yii::t('string', '3d view loaded successfully.');

        $resp['content'] = $this->renderPartial('view3dDesign', $data, true, FALSE);
        echo json_encode($resp);
    }

    public function actionSubmittedDesignDetails($id) {
        $this->layout = '//layouts/dashboard';
        $designData = JobBid::model()->findByPk($id);
        $job_id = $designData->job->id;
        if (!$designData)
            {
            $this->redirect('user/bothDashboard');
            }
        if ($designData->user_master_id != Yii::app()->user->id)
            {
            $this->redirect('user/bothDashboard');
            }
        $color = '';
        $accepted = '';
        $transactionData = TransactionReport::model()->findByAttributes(['status' => '23', 'bid_id' => $id]);
        if ($transactionData != '')
            {
            $accepted = 'Accepted';
            $color = 'yellow';
            }
        else
            {
            $all_bids = JobBid::model()->findAllByAttributes(['jobs_id' => $job_id]);
            if ($all_bids)
                {
                foreach ($all_bids as $b_index => $bid)
                    {
                    $transaction = TransactionReport::model()->findByAttributes(['status' => '23', 'bid_id' => $bid->id]);
                    if ($transaction)
                        {
                        $accepted = 'Rejected';
                        $color = '#FF0046';
                        break;
                        }
                    else
                        {
                        $accepted = 'Under Review';
                        $color = '#6699ff';
                        }
                    }
                }
            }
        $this->render('submittedDesignDetails', ['designData' => $designData, 'design_accepted' => $accepted, 'color' => $color]);
    }

    public function actionBoughtDesignDetails($id) {
        $this->layout = '//layouts/dashboard';
        if (isset($id) && isset($_GET['type']) && $_GET['type'] != '')
            {
            $data['type'] = $type = $_GET['type'];

            $jobBid = $tpe = $image = '';
            if ($type == 'designer_bid')
                {
                $data['jobBid'] = $jobBid = JobBid::model()->findByPk($id);
                $job_id = $jobBid->jobs_id;
                $tpe = '1';
                $data['image'] = $image = 'jobs/' . $jobBid->uploaded_file;
                $data['description'] = $description = $jobBid->job->description;
                }
            elseif ($type == 'catalog')
                {
                $data['jobBid'] = $jobBid = Catalog::model()->findByPk($id);
                $job_id = $jobBid->id;
                $tpe = '2';
                $data['image'] = $image = 'catalog/' . $jobBid->uploaded_file;
                $data['description'] = $description = $jobBid->title;
                }

            if (!$jobBid)
                {
                $this->redirect('index');
                }
            $data['manufacturer_jobBid'] = $manufacturer_jobBid = ManufacturerJobBid::model()->findAllByAttributes(['jobs_id' => $job_id, 'status' => '1', 'type' => $tpe]);

            $is_transaction = '';
            $true_bid_transaction_id = '';
            $true_bid = '';
            if ($manufacturer_jobBid)
                {
                foreach ($manufacturer_jobBid as $bid)
                    {
                    $bid_true = TransactionReport::model()->findByAttributes(['bid_type' => 2, 'status' => '23', 'bid_id' => $bid->id]);

                    if (count($bid_true) > 0)
                        {
                        $is_transaction = 'yes';
                        $true_bid = $bid_true->bid_id;
                        $true_bid_transaction_id = $bid_true->id;
                        break;
                        }
                    }
                }

            $data['is_transaction'] = $is_transaction;
            $data['true_bid_transaction_id'] = $true_bid_transaction_id;
            $data['true_bid'] = $true_bid;

            $this->render('boughtDesignDetails', $data);
            }
        else
            {
            $this->redirect(Yii::app()->createUrl('site/index'));
            }
    }

    public function actionPrintWindow() {
        $resp = [];
        if (isset($_POST['uploaded_file']) && $_POST['uploaded_file'] != '')
            {
            $data['uploaded_file'] = $_POST['uploaded_file'];

            $resp['type'] = 'success';
            $resp['msg'] = Yii::t('string', 'print view loaded successfully.');

            $resp['content'] = $this->renderPartial('printdesign', $data, true, FALSE);
            }
        else
            {
            $resp['type'] = 'error';
            $resp['msg'] = Yii::t('string', 'Error! No such appointment exists.');
            }

        echo json_encode($resp);
    }

    public function actionCatalog() {
        $this->layout = '//layouts/dashboard';
        if (isset($_GET['id']) && $_GET['id'] != '')
            {
            $data['model'] = $model = Catalog::model()->findByPk($_GET['id']);
            }
        else
            {
            $data['model'] = $model = new Catalog();
            }

        if (isset($_POST['Catalog']))
            {
            $model->attributes = $_POST['Catalog'];
            $model->designer_id = Yii::app()->user->id;
            $model->status = 0;
            $uploadedFile = CUploadedFile::getInstance($model, 'uploaded_file');

            if (!empty($uploadedFile))
                {
                $rnd = rand(0, 9999);
                $fileName = "{$rnd}-{$uploadedFile}";
                $model->uploaded_file = $fileName;
                }
            else
                {
                $model->uploaded_file = '';
                }
            if ($model->validate())
                {
                $model->save();
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if (!empty($uploadedFile))
                    {
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/catalog/' . $fileName);
                    if ($ext != 'stl')
                        {
                        $image = new EasyImage(Yii::app()->basePath . '/../upload/catalog/' . $fileName);
                        $image->resize(225, 225);
                        $image->save(Yii::app()->basePath . '/../upload/catalog/thumb/' . $fileName);
                        }
                    }
                Yii::app()->user->setFlash('success', "This is the preview of your catalog.Confirm to upload the catalog.");
                $this->redirect(Yii::app()->createUrl('bothDashboard/catalogConfirmation', ['id' => $model->id]));
                }
            }
        $this->render('catalog', $data);
    }

    public function actionCatalogConfirmation($id) {
        $this->layout = '//layouts/dashboard';
        $model = Catalog::model()->findByPk($id);
        if ($model->status == '1')
            {
            $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
            }
        $this->render('catalog_confirmation', ['model' => $model]);
    }

    public function actionCatalogConfirmationActions() {
        $catalogID = isset($_GET['id']) ? $_GET['id'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $model = Catalog::model()->findByPk($catalogID);
        if ($model->designer_id != Yii::app()->user->id)
            {
            $this->redirect(Yii::app()->createUrl('site/logout'));
            }
        else
            {
            if ($model->status == '1')
                {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
                }
            else
                {
                if ($type == 'cancel')
                    {
                    $org_file_name = explode(".", $model->uploaded_file);
                    if ($this->getFileExtention($model->uploaded_file) == 'stl')
                        {
                        unlink(Yii::app()->basePath . '/../upload/catalog/' . $org_file_name[0] . '.jpg');
                        }
                    unlink(Yii::app()->basePath . '/../upload/jobs/catalog/' . $org_file_name[0] . '.jpg');
                    unlink(Yii::app()->basePath . '/../upload/catalog/' . $model->uploaded_file);
                    $model = Catalog::model()->DeleteByPk($catalogID);
                    Yii::app()->user->setFlash('success', "You have cancelled the catalog.");
                    $this->redirect(Yii::app()->createUrl('bothDashboard/catalog', ['id' => $model->id]));
                    }
                else
                    {
                    $model->status = '1';
                    $model->save(FALSE);
                    Yii::app()->user->setFlash('success', "You have successfully uploaded the catalog");
                    $this->redirect(Yii::app()->createUrl('site/gallery'));
                    }
                }
            }
    }

    public function actionPurchasedMnaufacturerCatalogs() {
        $this->layout = '//layouts/dashboard';
        if (!Yii::app()->user->isGuest)
            {
            $offset = 0;
            $limit = 6;
            $criteria = new CDbCriteria;
            $criteria->condition = "type = 4 AND employer_id =" . Yii::app()->user->id;
            $criteria->offset = $offset;
            $criteria->limit = $limit;
            $man_catalog_Data = EmployerBoughtDesigns::model()->findAll($criteria);
            $this->render('purchased_manufacturer_catalogs', ['man_catalog_Data' => $man_catalog_Data, 'offset' => $offset, 'limit' => $limit]);
            }
        else
            {
            $this->redirect(Yii::app()->createUrl('site/index'));
            }
    }

    public function actionLoadMorePurchasedMnaufacturerCatalogs($offset = 0, $limit = 6) {
        if (Yii::app()->request->isAjaxRequest)
            {
            $criteria = new CDbCriteria;
            $criteria->condition = "type = 4 AND employer_id =" . Yii::app()->user->id;
            $criteria->offset = $offset;
            $criteria->limit = $limit;

            $man_catalog_Data1 = EmployerBoughtDesigns::model()->findAll($criteria);
            $data = [];
            if (isset($man_catalog_Data1) && $man_catalog_Data1)
                {
                $data['status'] = 'success';
                foreach ($man_catalog_Data1 as $man_catalog_Data)
                    {
                    if ($this->getFileExtention($man_catalog_Data->maufacturerCatalog->uploaded_file) == 'stl')
                        {
                        $org_file_name = explode(".", $man_catalog_Data->maufacturerCatalog->uploaded_file);
                        $man_catalog_Data->maufacturerCatalog->uploaded_file = $org_file_name[0] . '.jpg';
                        }

                    $data['msg'] = [];
                    $data['msg'][$man_catalog_Data->id] = [];
                    $data['msg'][$man_catalog_Data->id]['id'] = $man_catalog_Data->maufacturerCatalog->id;
                    $data['msg'][$man_catalog_Data->id]['image'] = $man_catalog_Data->maufacturerCatalog->uploaded_file != '' ? Yii::app()->request->getBaseUrl(true) . '/upload/manufacturer_catalog/' . $man_catalog_Data->maufacturerCatalog->uploaded_file : Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    $data['msg'][$man_catalog_Data->id]['price'] = $man_catalog_Data->maufacturerCatalog->price;
                    $data['msg'][$man_catalog_Data->id]['title'] = strlen($man_catalog_Data->maufacturerCatalog->title) > 57 ? substr($man_catalog_Data->maufacturerCatalog->title, 0, 57) : $man_catalog_Data->maufacturerCatalog->title;
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

    public function actionPurchasedManufacturerCatalogPaymentRelease() {
        $resp = [];
        
        if (isset($_GET['d_id']) && $_GET['d_id'] != '')
            {
            $design_id = $_GET['d_id'];
            $employerBoughtDesign_data = EmployerBoughtDesigns::model()->findByPk($design_id);
            $employerBoughtDesign_data->payment_notification = 1;
            if ($employerBoughtDesign_data->save(false))
                {
                $resp['type'] = 'success';
                $resp['msg'] = 'Successfully notified admin.';
                Yii::app()->user->setFlash('success', "Successfully notified admin to release the payment.");
                }
            else
                {
                $resp['type'] = 'error';
                $resp['msg'] = 'Error! Something went wrong.Please try again later.';
                Yii::app()->user->setFlash('error', "Error! Something went wrong.Please try again later.");
                }
            }
        else
            {
            $resp['type'] = 'error';
            $resp['msg'] = 'Error! No data posted.';
            Yii::app()->user->setFlash('error', "Error! No data posted.");
            }
            echo json_encode($resp);
    }

    public function actionShowPurchasedManufacturerCatalogs() {
        if (isset($_GET['b_id']) && $_GET['b_id'] != '')
            {
            $design_id = isset($_GET['d_id']) ? $_GET['d_id'] : '';
            $employerBoughtDesign_data = EmployerBoughtDesigns::model()->findByPk($design_id);
            $bidData = ManufacturerCatalog::model()->findByPk($_GET['b_id']);
            if ($bidData)
                {
                $resp['type'] = 'success';
                $resp['img_src'] = '';
                $resp['img_type'] = '';
                if ($this->getFileExtention($bidData->uploaded_file) == 'stl')
                    {
                    $data['rawImage'] = $bidData->uploaded_file;
                    $resp['img_type'] = '3d';
                    $resp['content'] = $this->renderPartial('viewPurchased3dCatalog', $data, true, FALSE);
                    $org_file_name = explode(".", $bidData->uploaded_file);
                    $resp['img_src'] = Yii::app()->baseUrl . '/upload/manufacturer_catalog/' . $org_file_name[0] . '.jpg';
                    }
                else
                    {
                    $resp['img_src'] = Yii::app()->baseUrl . '/upload/manufacturer_catalog/' . $bidData->uploaded_file;
                    $resp['img_type'] = '';
                    }
                    $resp['payment_notification_status']  = $employerBoughtDesign_data->payment_notification;
                }
            }
        echo json_encode($resp);
        die();
    }

    }
