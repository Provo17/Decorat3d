<?php

class UserController extends FrontController {

    public $layout = '//layouts/dashboard';

    public function actionBothDashboard() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        $this->layout = '//layouts/dashboard';
        $data = [];

        $data['offset'] = $offset = 0;
        $data['limit'] = $limit = 6;
//        self::BothDashboard();
        $criteria = new CDbCriteria;
        $criteria->condition = "added_by=" . Yii::app()->user->id . " AND status='1'";
        $criteria->order = "id DESC";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $data['own_jobsData'] = $own_jobsData = Jobs::model()->findAll($criteria);
//        $data['own_jobsData'] = $own_jobsData = Jobs::model()->findAllByAttributes(['added_by' => Yii::app()->user->id, 'status' => '1'], ['order' => 'id DESC']);

        $criteria1 = new CDbCriteria;
        $criteria1->condition = "user_master_id=" . Yii::app()->user->id . " AND status='1'";
        $criteria1->order = "id DESC";
        $criteria1->limit = $limit;
        $criteria1->offset = $offset;
        $data['submitted_design'] = $submitted_design = JobBid::model()->findAll($criteria1);

//        $data['submitted_design'] = $submitted_design = JobBid::model()->findAllByAttributes(['user_master_id' => Yii::app()->user->id, 'status' => '1'], ['order' => 'id DESC']);
//        $data['transactions'] = $transactions = TransactionReport::model()->findAllByAttributes(['bid_type' => 1, 'user_id' => Yii::app()->user->id, 'status' => '23']);
        $criteria2 = new CDbCriteria;
        $criteria2->condition = "employer_id=" . Yii::app()->user->id . " AND status='1'";
        $criteria2->order = "id DESC";
        $criteria2->limit = $limit;
        $criteria2->offset = $offset;
        $data['transactions'] = $transactions = EmployerBoughtDesigns::model()->findAll($criteria2);

//        $data['transactions'] = $transactions = EmployerBoughtDesigns::model()->findAllByAttributes(['employer_id' => Yii::app()->user->id, 'status' => '1'], ['order' => 'id DESC']);
        $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
        $transaction_data = [];
        if (count($transactions) > 0) {
            foreach ($transactions as $t_index => $transaction) {
                if ($transaction->type == 1) {
                    $transaction_data[$transaction->id]['image'] = isset($data[$transaction->id]['image']) ? 'jobs/' . $transaction->transaction->bid->job->uploaded_file : 'jobs/' . $transaction->transaction->bid->job->uploaded_file;
                    $transaction_data[$transaction->id]['description'] = isset($data[$transaction->id]['description']) ? $transaction->transaction->bid->job->description : $transaction->transaction->bid->job->description;
                    $transaction_data[$transaction->id]['price'] = isset($data[$transaction->id]['price']) ? $transaction->transaction->bid->price : $transaction->transaction->bid->price;
                    $transaction_data[$transaction->id]['track_id'] = isset($data[$transaction->id]['track_id']) ? $transaction->transaction->bid->id : $transaction->transaction->bid->id;
                    $transaction_data[$transaction->id]['type'] = 'designer_bid';
                }
//                elseif ($transaction->type == 2)
//                    {
//                    $transaction_data[$transaction->id]['image'] = isset($data[$transaction->id]['image']) ? $transaction->transaction->manufacturerbid->bid->uploaded_file : $transaction->transaction->manufacturerbid->bid->uploaded_file;
//                    $transaction_data[$transaction->id]['description'] = isset($data[$transaction->id]['description']) ? $transaction->transaction->manufacturerbid->bid->job->description : $transaction->transaction->manufacturerbid->bid->job->description ;
//                    $transaction_data[$transaction->id]['price'] = isset($data[$transaction->id]['price']) ? $transaction->transaction->manufacturerbid->bid->price : $transaction->transaction->manufacturerbid->bid->price ;
//                    }
                elseif ($transaction->type == 3) {
                    $transaction_data[$transaction->id]['image'] = isset($data[$transaction->id]['image']) ? 'catalog/' . $transaction->transaction->catalog->uploaded_file : 'catalog/' . $transaction->transaction->catalog->uploaded_file;
                    $transaction_data[$transaction->id]['description'] = isset($data[$transaction->id]['description']) ? $transaction->transaction->catalog->title : $transaction->transaction->catalog->title;
                    $transaction_data[$transaction->id]['price'] = isset($data[$transaction->id]['price']) ? $transaction->transaction->catalog->price : $transaction->transaction->catalog->price;
                    $transaction_data[$transaction->id]['track_id'] = isset($data[$transaction->id]['track_id']) ? $transaction->transaction->catalog->id : $transaction->transaction->catalog->id;
                    $transaction_data[$transaction->id]['type'] = 'catalog';
                }
            }
        }
        $data['EmployerAccDesigns'] = $transaction_data;
        $this->render('bothDashboard', $data);
    }

    public function actionLoadMoreBothDashboard($c_tab, $offset, $limit) {
        $data = [];
        $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
        $BothDashboardData = self::BothDashboardData($c_tab, $offset, $limit);
        echo json_encode($BothDashboardData);
    }

    public function BothDashboardData($c_tab, $offset, $limit) {
        $data = [];
        if ($c_tab == '1') {
            $criteria = new CDbCriteria;
            $criteria->condition = "added_by=" . Yii::app()->user->id . " AND status='1'";
            $criteria->order = "id DESC";
            $criteria->limit = $limit;
            $criteria->offset = $offset;
            $own_jobsData = Jobs::model()->findAll($criteria);

            $own_jobs['msg'] = [];
            if (count($own_jobsData) > 0) {
                foreach ($own_jobsData as $j_index => $jobs) {
                    $own_jobs['msg'][$jobs->id]['link'] = Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $jobs->id]);
                    if ($jobs->uploaded_file != '') {
                        if ($this->getFileExtention($jobs->uploaded_file) == 'stl') {
                            $org_file_name = explode(".", $jobs->uploaded_file);
                            $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                        } else {
                            $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $jobs->uploaded_file;
                        }
                    } else {
                        $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    }
                    $own_jobs['msg'][$jobs->id]['image'] = $uploaded_file;
//                $own_jobs['price'] = $own_jobs['price'] ? ;
                    $description = strlen($jobs->description) > 57 ? substr($jobs->description, 0, 57) : $jobs->description;
                    $own_jobs['msg'][$jobs->id]['description'] = $description;
                    $own_jobs['msg'][$jobs->id]['by_whom'] = $jobs->job_owner->username;
                }

                $data['limit'] = $limit;
                $data['offset'] = $offset;
                $data['msg'] = $own_jobs['msg'];
            } else {
                $data['limit'] = 0;
                $data['offset'] = 0;
                $data['status'] = 'noMore';
                $data['msg'] = 'No more results found!';
            }
        } else if ($c_tab == '2') {
            $criteria1 = new CDbCriteria;
            $criteria1->condition = "user_master_id=" . Yii::app()->user->id . " AND status='1'";
            $criteria1->order = "id DESC";
            $criteria1->limit = $limit;
            $criteria1->offset = $offset;
            $submitted_design = JobBid::model()->findAll($criteria1);

            $own_designs['msg'] = [];
            if (count($submitted_design) > 0) {
                foreach ($submitted_design as $d_index => $design) {
                    $own_designs['msg'][$design->id]['link'] = Yii::app()->createUrl('bothDashboard/submittedDesignDetails', ['id' => $design->id]);
                    if ($design->job->uploaded_file != '') {
                        if ($this->getFileExtention($design->job->uploaded_file) == 'stl') {
                            $org_file_name = explode(".", $design->job->uploaded_file);
                            $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                        } else {
                            $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $design->job->uploaded_file;
                        }
                    } else {
                        $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    }
                    $own_designs['msg'][$design->id]['image'] = $uploaded_file;
                    $own_designs['msg'][$design->id]['price'] = $design->price;
                    $description = strlen($design->job->description) > 57 ? substr($design->job->description, 0, 57) : $design->job->description;
                    $own_designs['msg'][$design->id]['description'] = $description;
                    $own_designs['msg'][$design->id]['by_whom'] = $userData->username;
                }
                $data['limit'] = $limit;
                $data['offset'] = $offset;
                $data['msg'] = $own_designs['msg'];
            } else {
                $data['limit'] = 0;
                $data['offset'] = 0;
                $data['status'] = 'noMore';
                $data['msg'] = 'No more results found!';
            }
        } elseif ($c_tab == 3) {
            $criteria2 = new CDbCriteria;
            $criteria2->condition = "employer_id=" . Yii::app()->user->id . " AND status='1'";
            $criteria2->order = "id DESC";
            $criteria2->limit = $limit;
            $criteria2->offset = $offset;
            $transactions = EmployerBoughtDesigns::model()->findAll($criteria2);

            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            $transaction_data = [];
            $transaction_data['msg'] = [];
            if (count($transactions) > 0) {
                foreach ($transactions as $t_index => $transaction) {
                    if ($transaction->type == 1) {
                        $transaction_data[$transaction->id]['image'] = isset($data[$transaction->id]['image']) ? 'jobs/' . $transaction->transaction->bid->job->uploaded_file : 'jobs/' . $transaction->transaction->bid->job->uploaded_file;
                        $transaction_data[$transaction->id]['description'] = isset($data[$transaction->id]['description']) ? $transaction->transaction->bid->job->description : $transaction->transaction->bid->job->description;
                        $transaction_data[$transaction->id]['price'] = isset($data[$transaction->id]['price']) ? $transaction->transaction->bid->price : $transaction->transaction->bid->price;
                        $transaction_data[$transaction->id]['track_id'] = isset($data[$transaction->id]['track_id']) ? $transaction->transaction->bid->id : $transaction->transaction->bid->id;
                        $transaction_data[$transaction->id]['type'] = 'designer_bid';
                    } elseif ($transaction->type == 3) {
                        $transaction_data[$transaction->id]['image'] = isset($data[$transaction->id]['image']) ? 'catalog/' . $transaction->transaction->catalog->uploaded_file : 'catalog/' . $transaction->transaction->catalog->uploaded_file;
                        $transaction_data[$transaction->id]['description'] = isset($data[$transaction->id]['description']) ? $transaction->transaction->catalog->title : $transaction->transaction->catalog->title;
                        $transaction_data[$transaction->id]['price'] = isset($data[$transaction->id]['price']) ? $transaction->transaction->catalog->price : $transaction->transaction->catalog->price;
                        $transaction_data[$transaction->id]['track_id'] = isset($data[$transaction->id]['track_id']) ? $transaction->transaction->catalog->id : $transaction->transaction->catalog->id;
                        $transaction_data[$transaction->id]['type'] = 'catalog';
                    }
                    if ($transaction_data[$transaction->id]['image'] != '') {
                        if ($this->getFileExtention($transaction_data[$transaction->id]['image']) == 'stl') {
                            $org_file_name = explode(".", $transaction_data[$transaction->id]['image']);
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                        } else {
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/" . $transaction_data[$transaction->id]['image'];
                        }
                    } else {
                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    }
                    $transaction_data['msg'][$transaction->id]['link'] = Yii::app()->createUrl('bothDashboard/boughtDesignDetails', ['id' => $transaction_data[$transaction->id]['track_id']]) . '?type=' . $transaction_data[$transaction->id]['type'];
                    $transaction_data['msg'][$transaction->id]['image'] = $uplpoaded_file;
                    $transaction_data['msg'][$transaction->id]['price'] = $transaction_data[$transaction->id]['price'];
                    $transaction_data['msg'][$transaction->id]['description'] = $transaction_data[$transaction->id]['description'];
                    $transaction_data['msg'][$transaction->id]['by_whom'] = $userData->username;
                }
                $data['limit'] = $limit;
                $data['offset'] = $offset;
                $data['msg'] = $transaction_data['msg'];
            } else {
                $data['limit'] = 0;
                $data['offset'] = 0;
                $data['status'] = 'noMore';
                $data['msg'] = 'No more results found!';
            }
        }

        return $data;
    }

    public function actionJobs() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $key = $_GET['key'];
        }
        $offset = 0;
        $limit = 6;
        $criteria = new CDbCriteria;
        if (Yii::app()->user->isGuest) {
            $criteria->condition = "status='1'";
        } else {
            $criteria->condition = "status='1' AND added_by !=" . Yii::app()->user->id;
        }

        $criteria->addSearchCondition('description', $key);
        $criteria->offset = $offset;
        $criteria->limit = $limit;

        $data['all_jobs'] = $all_jobs = Jobs::model()->findAll($criteria);
        $data['userModel'] = $model = UserMaster::model()->findByPk(Yii::app()->user->id);
        $data['key'] = $key;
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        $this->render('jobs', $data);
    }

    public function actionLoadMoreJobs($key = '', $offset = 0, $limit = 6) {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            if (Yii::app()->user->isGuest) {
                $criteria->condition = "status='1'";
            } else {
                $criteria->condition = "status='1' AND added_by !=" . Yii::app()->user->id;
            }

            $criteria->addSearchCondition('description', $key);
            $criteria->offset = $offset;
            $criteria->limit = $limit;

            $jobs = Jobs::model()->findAll($criteria);
            $user = UserMaster::model()->findByPk(Yii::app()->user->id);
            $data = [];
            if (isset($jobs) && $jobs) {
                $data['status'] = 'success';
                foreach ($jobs as $job) {
                    $project_assigned = '';
                    $allJobBid = JobBid::model()->findAllByAttributes(['jobs_id' => $job->id]);
                    if ($allJobBid != '') {
                        foreach ($allJobBid as $allJobBid_key => $bid) {
                            $true_bid = TransactionReport::model()->findByAttributes(['bid_id' => $bid->id, 'status' => '23', 'bid_type' => '1']);
                            if ($true_bid) {
                                $project_assigned = 'yes';
                                continue;
                            }
                        }
                    }

                    $data['msg'] = [];
                    $data['msg'][$job->id] = [];
                    $data['msg'][$job->id]['id'] = $job->id;
                    $data['msg'][$job->id]['username'] = isset($job->job_owner) ? $job->job_owner->username : "";
                    $data['msg'][$job->id]['link'] = Yii::app()->createAbsoluteUrl('bothDashboard/jobDetails', ['id' => $job->id]);

                    if ($job->uploaded_file != '') {
                        if ($this->getFileExtention($job->uploaded_file) == 'stl') {
                            $org_file_name = explode(".", $job->uploaded_file);
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                        } else {
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $job->uploaded_file;
                        }
                    } else {
                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    }
                    $data['msg'][$job->id]['image'] = $uplpoaded_file;
                    $data['msg'][$job->id]['description'] = strlen($job->description) > 57 ? substr($job->description, 0, 57) : $job->description;

                    $data['msg'][$job->id]['created_at'] = date('g:ia \o\n l jS F Y', strtotime($job->created_at));
                    if (isset($project_assigned) && $project_assigned == 'yes') {
                        $data['msg'][$job->id]['project_assigned'] = 'yes';
                    } else if (!Yii::app()->user->isGuest && $user->user_type_id == 2) {
                        $data['msg'][$job->id]['project_assigned'] = 'Bid Now1';
                        $data['msg'][$job->id]['project_assigned_link'] = Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $job->id]);
                    } else {
                        $data['msg'][$job->id]['project_assigned'] = 'Bid Now2';
                        $data['msg'][$job->id]['project_assigned_link'] = Yii::app()->createUrl('site/login', ['return_url' => Yii::app()->getBaseUrl(true) . '/project-detail/' . $job->id . '.html']);
                    }
                }
                $data['offset'] = $offset;
                $data['limit'] = $limit;
            } else {
                $data['status'] = 'noMore';
                $data['msg'] = 'There are no more results...';
                $data['offset'] = 0;
                $data['limit'] = 0;
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'There is an unknown error';
            $data['offset'] = 0;
            $data['limit'] = 0;
        }
        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionJobPost() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        $this->layout = '//layouts/dashboard';
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $model = Jobs::model()->findByPk($_GET['id']);
            if ($model->added_by != Yii::app()->user->id) {
                $this->redirect(Yii::app()->createUrl('site/logout'));
            }
        } else {
            $model = new Jobs;
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jobs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Jobs'])) {
            $model->attributes = $_POST['Jobs'];
            $model->added_by = Yii::app()->user->id;
            $model->status = '0';
            $uploadedFile = CUploadedFile::getInstance($model, 'uploaded_file');
            if (!empty($uploadedFile)) {
                $rnd = rand(0, 9999);
                $fileName = "{$rnd}-{$uploadedFile}";
                $model->uploaded_file = $fileName;
            }
            if ($model->validate()) {
                $model->save();
                if (!empty($uploadedFile)) {
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/jobs/' . $fileName);
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    if ($ext != 'stl') {
                        $image = new EasyImage(Yii::app()->basePath . '/../upload/jobs/' . $fileName);
                        $image->resize(225, 225);
                        $image->save(Yii::app()->basePath . '/../upload/jobs/thumb/' . $fileName);
                    }
                }
                Yii::app()->user->setFlash('success', "This is your posted project preview .Please confirm to post the project.");
                $this->redirect(Yii::app()->createUrl('user/jobConfirmation', ['id' => $model->id]));
            }
        }
        $this->render('jobpost', array('model' => $model));
    }

    public function actionJobConfirmation($id) {
        $this->layout = '//layouts/dashboard';
        if (!Yii::app()->user->isGuest) {

            $model = Jobs::model()->findByPk($id);
            $this->render('jobconfirmation', ['model' => $model]);
        } else {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    public function actionJobConfirmationActions() {
        $jobID = isset($_GET['id']) ? $_GET['id'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $model = Jobs::model()->findByPk($jobID);
        if ($model->added_by != Yii::app()->user->id) {
            $this->redirect(Yii::app()->createUrl('site/logout'));
        } else {
            if ($model->status == '1') {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
            } else {
                if ($type == 'cancel') {
                    if ($this->getFileExtention($model->uploaded_file) == 'stl') {
                        $org_file_name = explode(".", $model->uploaded_file);
                        if (file_exists($org_file_name[0] . '.jpg')) {
                            unlink(Yii::app()->basePath . '/../upload/jobs/' . $org_file_name[0] . '.jpg');
                            unlink(Yii::app()->basePath . '/../upload/jobs/thumb/' . $org_file_name[0] . '.jpg');
                        }
                    }
                    if (file_exists($model->uploaded_file)) {
                        unlink(Yii::app()->basePath . '/../upload/jobs/' . $model->uploaded_file);
                    }
                    $model = Jobs::model()->DeleteByPk($jobID);
                    Yii::app()->user->setFlash('success', "You have cancelled the project.");
                    $this->redirect(Yii::app()->createUrl('user/jobPost'));
                } else {
                    $model->status = '1';
                    $model->save(FALSE);
                    Yii::app()->user->setFlash('success', "The project has been posted successfully.");
                    $this->redirect(Yii::app()->createUrl('user/jobPost'));
                }
            }
        }
    }

    public function actionManufactureDashboard() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        $this->layout = '//layouts/dashboard';
        $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
        if ($userData->user_type_id != 3) {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        $img_type = '';
        $manufacturerBids = ManufacturerJobBid::model()->findAllByAttributes(['status' => '1', 'manufacturer_id' => $userData->id], ['offset' => 0, 'limit' => 6]);
        if ($manufacturerBids) {
            foreach ($manufacturerBids as $manufacturerBid) {
                $acceptedBid = TransactionReport::model()->findByAttributes(['status' => '23', 'bid_id' => $manufacturerBid->id, 'bid_type' => '2']);

                if (isset($acceptedBid)) {
                    if ($manufacturerBid->type == "1") {
                        $image = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->bid) ?
                                Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $acceptedBid->manufacturerbid->bid->uploaded_file :
                                Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                        $description = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->bid, $acceptedBid->manufacturerbid->bid->job) ? $acceptedBid->manufacturerbid->bid->job->description : "";
                        if ($this->getFileExtention($acceptedBid->manufacturerbid->bid->uploaded_file) == 'stl') {
                            $img_type = 'stl';
                        } else {
                            $img_type = 'other';
                        }
                    } else {
                        $image = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->catalog) ?
                                Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $acceptedBid->manufacturerbid->catalog->uploaded_file :
                                Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                        $description = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->catalog) ? $acceptedBid->manufacturerbid->catalog->title : "";
                        if ($this->getFileExtention($acceptedBid->manufacturerbid->catalog->uploaded_file) == 'stl') {
                            $img_type = 'stl';
                        } else {
                            $img_type = 'other';
                        }
                    }
                    $amount = $acceptedBid->amount;

                    $data['manufacturerBids'][$manufacturerBid->id]['image'] = $image;
                    $data['manufacturerBids'][$manufacturerBid->id]['description'] = $description;
                    $data['manufacturerBids'][$manufacturerBid->id]['amount'] = $amount;
                    $data['manufacturerBids'][$manufacturerBid->id]['img_type'] = $img_type;
                }
            }
        }
        $data['offset'] = 0;
        $data['limit'] = 6;

        $this->render('manufactureDashboard', $data);
    }

    public function actionManufactureDashboardLoadMore($offset = 0, $limit = 6) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = [];
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData->user_type_id != 3) {
                $data['status'] = 'error';
                $data['msg'] = 'You are not authorized to access this page';
            } else {
                $manufacturerBids = ManufacturerJobBid::model()->findAllByAttributes(['status' => '1', 'manufacturer_id' => $userData->id], ['offset' => $offset, 'limit' => $limit]);
//                echo '<pre>';
//                print_r($manufacturerBids);
//                echo '</pre>';
//                exit;
                $img_type = '';
                if ($manufacturerBids) {
                    foreach ($manufacturerBids as $manufacturerBid) {
                        $acceptedBid = TransactionReport::model()->findByAttributes(['status' => '23', 'bid_id' => $manufacturerBid->id, 'bid_type' => '2']);
                        if (isset($acceptedBid)) {
                            if ($manufacturerBid->type == "1") {
                                $image = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->bid) ?
                                        Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $acceptedBid->manufacturerbid->bid->uploaded_file :
                                        Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                $description = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->bid, $acceptedBid->manufacturerbid->bid->job) ? $acceptedBid->manufacturerbid->bid->job->description : "";
                                if ($this->getFileExtention($acceptedBid->manufacturerbid->bid->uploaded_file) == 'stl') {
                                    $img_type = 'stl';
                                } else {
                                    $img_type = 'other';
                                }
                            } else {
                                $image = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->catalog) ?
                                        Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $acceptedBid->manufacturerbid->catalog->uploaded_file :
                                        Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                $description = isset($acceptedBid->manufacturerbid, $acceptedBid->manufacturerbid->catalog) ? $acceptedBid->manufacturerbid->catalog->title : "";
                                if ($this->getFileExtention($acceptedBid->manufacturerbid->catalog->uploaded_file) == 'stl') {
                                    $img_type = 'stl';
                                } else {
                                    $img_type = 'other';
                                }
                            }
                            $amount = $acceptedBid->amount;

                            $data['manufacturerBids'][$manufacturerBid->id]['image'] = $image;
                            $data['manufacturerBids'][$manufacturerBid->id]['description'] = $description;
                            $data['manufacturerBids'][$manufacturerBid->id]['amount'] = $amount;
                            $data['manufacturerBids'][$manufacturerBid->id]['img_type'] = $img_type;
                        }
                    }
                    if(isset($data['manufacturerBids'])){
                        $data['status'] = 'success';
                        $data['offset'] = $offset;
                        $data['limit'] = $limit;
                    }else{
                        $data['status'] = 'noMore';
                        $data['msg'] = 'There are not any more results...';
                    }
                } else {
                    $data['status'] = 'noMore';
                    $data['msg'] = 'There are not any more results...';
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionProfile() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }

        $this->layout = '//layouts/dashboard';
        $data['model'] = $model = UserMaster::model()->findByPk(Yii::app()->user->id);
        $image = $model->profile_image;
        $model->setScenario('userProfileUpdate');
        if (isset($_POST['UserMaster'])) {
            $model->attributes = $_POST['UserMaster'];
            $uploadedFile = CUploadedFile::getInstance($model, 'profile_image');
            if (!empty($uploadedFile)) {
                $rnd = rand(0, 9999);
                $fileName = "{$rnd}-{$uploadedFile}";
                $model->profile_image = $fileName;
            }

            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->validate()) {
                $model->save();
                if (!empty($uploadedFile)) {
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/usersImage/' . $fileName);
                    $image = new EasyImage(Yii::app()->basePath . '/../upload/usersImage/' . $fileName);
                    $image->resize(225, 225);
                    $image->save(Yii::app()->basePath . '/../upload/usersImage/thumb/' . $fileName);
                }
                Yii::app()->user->setFlash('success', "Profile updated successfully.");
            }
        }
        $this->render('profile_form', $data);
    }

//==================Forgot Password================//
    public function actionForgotpassword() {
//        if (Yii::app()->user->isGuest)
//        {
//            $this->redirect(Yii::app()->createUrl('site/login'));
//        }
        $user = new UserMaster('forgot-pwd');

        $this->render('forgot_password', ['model' => $user]);
    }

    public function actionDoForgotPassword() {
        if (Yii::app()->user->isGuest) {
            $resp = [];
            $user = new UserMaster('forgot-pwd');
            $user->email = $_POST['email'];
            if ($user->validate()) {
                //find user data from db
                $model = UserMaster::model()->findByAttributes(['email' => $user->email]);
                if ($model) {
                    $resp['message'] = 'Success! We have sent reset password link in your mail please check.';
                    $resp['type'] = 'success';
                    $token = md5('reset_' . $model->id . $model->id . time());
                    $url = "<a href=" . $this->createAbsoluteUrl('ResetPassword', ['token' => $token]) . ">Click Here</a>";
                    $model->forgotten_password_code = $token;
                    $model->save(false);

                    $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'forgot_password'));
                    $name = $model->name;
                    $reset_password_link = $url;
                    $data_array = array($name, $reset_password_link);
                    $replace_array = array("{{name}}", "{{reset_password_link}}");

                    $email_content = str_replace($replace_array, $data_array, $email_body->body);
                    $email_data = [
                        'to' => $model->email,
                        'subject' => $email_body->subject,
                        'template' => 'email_gen',
                        'data' => ['email_content' => $email_content],
                    ];
                    $this->SendMail($email_data);
                } else {
                    $resp['message']['invalid_email'] = 'This email does not exists.';
                    $resp['type'] = 'warning';
                }
            } else {
                $resp['message'] = $user->getErrors();
                $resp['type'] = 'warning';
            }
        }
        echo json_encode($resp);
    }

    public function actionResetPassword() {
        if (!Yii::app()->user->isGuest) {
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            if ($userData && $userData->user_type_id == 2) {
                $this->redirect(Yii::app()->createUrl('user/bothDashboard'));
            } else {
                $this->redirect(Yii::app()->createUrl('user/manufactureDashboard'));
            }
        }
        $data = [];
        if (isset($_GET['token']) && $_GET['token'] != '') {
            $data['token'] = isset($_GET['token']) ? $_GET['token'] : '';
            $data['UserMaster'] = UserMaster::model()->findByAttributes(['forgotten_password_code' => $data['token']]);
            if (!$data['UserMaster']) {
                $this->redirect(Yii::app()->createUrl('site/login'));
            }
            $this->render('reset_password', $data);
        } else {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    public function actionDoResetPassword() {

        if (Yii::app()->user->isGuest) {
            $resp = [];
            $data['token'] = isset($_GET['token']) ? $_GET['token'] : '';
            $model = UserMaster::model()->findByAttributes(['forgotten_password_code' => $data['token']]);
            if ($model) {
                $model->scenario = 'reset-pwd';
                if (isset($_POST['reset_new_password']) && isset($_POST['reset_confirm_new_password'])) {
                    $model->reset_new_password = $_POST['reset_new_password'];
                    $model->reset_confirm_new_password = $_POST['reset_confirm_new_password'];

                    if ($model->validate()) {
                        $resp['message'] = 'Success! Password reset successfully...';
                        $resp['type'] = 'success';
                        $model->password = md5($model->reset_new_password);
                        $model->forgotten_password_code = NULL;
                        $model->save(false);
                        $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'reset_password'));
                        $name = $model->name;
                        $login_link = "<a href=" . Yii::app()->createUrl('site/login') . ">Click Here </a>";
                        $data_array = array($name, $login_link);
                        $replace_array = array("{{name}}", "{{login_link}}");

                        $email_content = str_replace($replace_array, $data_array, $email_body->body);
                        $email_data = [
                            'to' => $model->email,
                            'subject' => $email_body->subject,
                            'template' => 'email_gen',
                            'data' => ['email_content' => $email_content],
                        ];
                        $this->SendMail($email_data);
//                        $email_data = [
//                            'to' => $model->email,
//                            'subject' => 'Password Reset Successfully',
//                            'template' => 'reset_password',
//                            'data' => ['model' => $model],
//                        ];
//                        $this->SendMail($email_data);
                    } else {
                        $errors = [];
                        foreach ($model->getErrors() as $field => $error) {
                            $errors["Users_" . $field] = $error[0];
                        }
                        $resp['message'] = $errors;
                        $resp['type'] = 'warning';
                    }
                }
            } else {
                $resp['message']['link'] = 'Invalid link...';
                $resp['type'] = 'warning';
            }
        }
        echo json_encode($resp);
    }

    public function actionSearch() {
        $this->render('search');
    }

    public function actionSearchResult() {
        $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';
        if (isset($search_type) && ($search_type == 'projects' || $search_type == 'catalog' || $search_type == 'purchased_catalog' || $search_type == 'employer-or-designer' || $search_type == 'manufacturer' || $search_type == 'purchased_designs' || $search_type == 'manufacturer_catalog')) {
            $key = isset($_GET['key']) ? $_GET['key'] : '';
            if ($search_type == 'projects') {
                $this->redirect(Yii::app()->createUrl('user/jobs') . '?search_type=projects&key=' . $key);
            }
            if ($search_type == 'purchased_designs') {
                $this->redirect(Yii::app()->createUrl('user/purchasedDesigns') . '?search_type=projects&key=' . $key);
            }
            if ($search_type == 'employer-or-designer') {
                $this->redirect(Yii::app()->createUrl('site/designer') . '?search_type=employer-or-designer&key=' . $key);
            }
            if ($search_type == 'manufacturer') {
                $this->redirect(Yii::app()->createUrl('site/manufacturer') . '?search_type=manufacturer&key=' . $key);
            }
            if ($search_type == 'catalog') {
                $this->redirect(Yii::app()->createUrl('site/gallery') . '?search_type=catalog&key=' . $key);
            }
            if ($search_type == 'purchased_catalog') {
                $this->redirect(Yii::app()->createUrl('manufacturerDashboard/purchasedCatalog') . '?search_type=purchased_catalog&key=' . $key);
            }
            if ($search_type == 'manufacturer_catalog') {
                $this->redirect(Yii::app()->createUrl('manufacturerDashboard/manufacturerCatalog') . '?search_type=manufacturer_catalog&key=' . $key);
            }
        } else {
            $this->redirect('search');
        }
    }

    public function actionPurchasedDesigns() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $key = $_GET['key'];
        }

        $offset = 0;
        $limit = 2;

        $criteria = new CDbCriteria();

        $criteria->condition = "bid_type=1 AND status ='23'";
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $data['all_jobs'] = $purchasedDesigns = TransactionReport::model()->findAll($criteria);
        $data['userData'] = $model = UserMaster::model()->findByPk(Yii::app()->user->id);
        $data['key'] = $key;
        $data['offset'] = $offset;
        $data['limit'] = $limit;

        $this->render('purchased_designs', $data);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionLoadMorePurchasedDesigns($key, $offset, $limit) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
            $criteria = new CDbCriteria;
            $criteria->condition = "bid_type=1 AND status ='23'";
            $criteria->offset = $offset;
            $criteria->limit = $limit;
            $all_jobs = TransactionReport::model()->findAll($criteria);
            $user = UserMaster::model()->findByPk(Yii::app()->user->id);
            $data = [];
            if (isset($all_jobs) && $all_jobs) {
                $data['status'] = 'success';
                $data['msg'] = [];
                foreach ($all_jobs as $job) {

                    $data['msg'][$job->bid->id] = [];
                    $data['msg'][$job->bid->id]['id'] = $job->bid->id;
                    $data['msg'][$job->bid->id]['username'] = isset($job->job_owner) ? $job->job_owner->username : "";
                    $data['msg'][$job->bid->id]['link'] = Yii::app()->createAbsoluteUrl('manufacturerDashboard/jobDetails', ['id' => $job->bid->id]);

                    if ($job->bid->uploaded_file != '') {
                        if ($this->getFileExtention($job->bid->uploaded_file) == 'stl') {
                            $org_file_name = explode(".", $job->bid->uploaded_file);
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                        } else {
                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $job->bid->uploaded_file;
                        }
                    } else {
                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    }
                    $data['msg'][$job->bid->id]['image'] = $uplpoaded_file;
                    $data['msg'][$job->bid->id]['description'] = strlen($job->bid->job->description) > 57 ? substr($job->bid->job->description, 0, 57) : $job->bid->job->description;

                    $data['msg'][$job->bid->id]['created_at'] = date('g:ia \o\n l jS F Y', strtotime($job->bid->created_at));
//                    if (isset($project_assigned) && $project_assigned == 'yes') {
//                        $data['msg'][$job->bid->id]['project_assigned'] = 'yes';
//                    } else
                    if (!Yii::app()->user->isGuest && $userData->user_type_id == 3) {
                        //$data['msg'][$job->bid->id]['project_assigned'] = 'Bid Now1';
                        $data['msg'][$job->bid->id]['project_assigned_link'] = Yii::app()->createUrl('manufacturerDashboard/jobDetails', ['id' => $job->bid->id]);
                    } else {
                        //$data['msg'][$job->bid->id]['project_assigned'] = 'Bid Now2';
                        $data['msg'][$job->bid->id]['project_assigned_link'] = Yii::app()->createUrl('site/login', ['return_url' => Yii::app()->getBaseUrl(true) . '/design-detail/' . $job->bid->id . '.html']);
                    }
                }

                $data['offset'] = $offset;
                $data['limit'] = $limit;
            } else {
                $data['status'] = 'noMore';
                $data['msg'] = 'There are no more results...';
                $data['offset'] = 0;
                $data['limit'] = 0;
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'There is an unknown error';
            $data['offset'] = 0;
            $data['limit'] = 0;
        }
        echo json_encode($data);
        Yii::app()->end();
    }

}
