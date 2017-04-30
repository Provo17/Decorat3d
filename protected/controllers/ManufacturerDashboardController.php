<?php

class ManufacturerDashboardController extends FrontController {

    public function actionJobDetails($id) {
        if (isset($id) && $id) {
            if (Yii::app()->user->isGuest) {
                $this->redirect(Yii::app()->createUrl('site/login'));
            }
            $jobs_id = '';
            $data = [];
            if (isset($_GET['type']) && $_GET['type'] == 'acc_design') {
                $jobBidDetails = JobBid::model()->findByPk($id);
                $jobs_id = $jobBidDetails->jobs_id;
                $data['description'] = $description = $jobBidDetails->job->description;
                $data['uploaded_file'] = $uploaded_file = 'jobs/' . $jobBidDetails->uploaded_file;
                $data['posted_by_id'] = $posted_by_id = $jobBidDetails->user_master_id;
                $data['posted_by'] = $posted_by = $jobBidDetails->designer->username;
                $job_bid_id = $id;
                $type = 1;
            } else if (isset($_GET['type']) && $_GET['type'] == 'catalog_design') {
                $trackID = isset($_GET['track_id']) ? $_GET['track_id'] : ''; // Pk of transaction_report table purchased by the employer
                $jobBidDetails = Catalog::model()->findByPk($id);
                $jobs_id = $jobBidDetails->id;
                $data['description'] = $description = $jobBidDetails->title;
                $data['uploaded_file'] = $uploaded_file = 'catalog/' . $jobBidDetails->uploaded_file;
                $purchasedCatalog = TransactionReport::model()->findByPk($trackID);
                $data['posted_by_id'] = $posted_by_id = $purchasedCatalog->user->id;
                $data['posted_by'] = $posted_by = $purchasedCatalog->user->username;
                $job_bid_id = 0;
                $type = 2;
            }
            if ($jobBidDetails) {
                $this->layout = '//layouts/dashboard';

                $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                $data['total_bids'] = $total_bids = count(ManufacturerJobBid::model()->findAllByAttributes(['jobs_id' => $jobs_id, 'status' => '1', 'type' => $type]));
                $data['manufacturer_bids'] = $manufacturer_bids = ManufacturerJobBid::model()->findAllByAttributes(['jobs_id' => $jobs_id, 'status' => '1', 'type' => $type]);

                $data['model'] = new ManufacturerJobBid();
                $data['jobBidDetails'] = $jobBidDetails;
                $data['price_err'] = '';
                if (isset($_POST['ManufacturerJobBid'])) {
                    $model = new ManufacturerJobBid;
                    $model->attributes = $_POST['ManufacturerJobBid'];
                    $model->manufacturer_id = $userData->id;
                    $model->job_bid_id = $job_bid_id;
                    $model->jobs_id = $jobs_id;
                    $model->is_featured = 1;
                    $model->type = $type;
                    $model->status = 1;

                    if ($model->validate()) {
                        if ($model->save())
                            Yii::app()->user->setFlash('success', "You have successfully bid on this design.");
                    }
                    else {
                        $err = $model->getErrors();
                        $data['err'] = "yes";
                        $data['price_err'] = isset($err['price']) ? $err['price'][0] : '';
                    }
                }
                $this->render('jobDetails', $data);
            } else {
                
            }
        }
    }

    public function actionSubmittedBids() {
        $this->layout = '//layouts/dashboard';
        $data['userData'] = $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
        if ($userData->user_type_id != 3) {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        $offset = 0;
        $limit = 6;
        $submittedBids = ManufacturerJobBid::model()->findAllByAttributes(['manufacturer_id' => Yii::app()->user->id, 'status' => '1'], ['offset' => $offset, 'limit' => $limit]);
        $bidData = [];
        if (isset($submittedBids) && $submittedBids) {
            foreach ($submittedBids as $b_index => $bid) {
                if ($bid->type == '1') {
                    $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $bid->bid->uploaded_file;
                    $description = $bid->bid->job->description;
                    $img_ext = $this->getFileExtention($bid->bid->uploaded_file);
                } else {
                    $img_ext = $this->getFileExtention($bid->catalog->uploaded_file);
                    $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $bid->catalog->uploaded_file;
                    $description = $bid->catalog->title;
                }
                if ($img_ext == 'stl') {
                    $img_type = 'stl';
                } else {
                    $img_type = 'other';
                }
                $bidData[$bid->id]['uplpoaded_file'] = isset($bidData[$bid->id]['uplpoaded_file']) ? $uplpoaded_file : $uplpoaded_file;
                $bidData[$bid->id]['description'] = isset($bidData[$bid->id]['description']) ? $description : $description;
                $bidData[$bid->id]['price'] = isset($bidData[$bid->id]['price']) ? $bid->price : $bid->price;
                $bidData[$bid->id]['img_type'] = isset($bidData[$bid->id]['img_type']) ? $img_type : $img_type;
            }
        }
        $this->render('submittedBids', ['submittedBids' => $submittedBids, 'bidData' => $bidData, 'offset' => $offset, 'limit' => $limit]);
    }

    public function actionLoadMoreSubmittedBids($offset = 0, $limit = 6) {
        if (Yii::app()->request->isAjaxRequest) {
            $submittedBids = ManufacturerJobBid::model()->findAllByAttributes(['manufacturer_id' => Yii::app()->user->id, 'status' => '1'], ['offset' => $offset, 'limit' => $limit]);
            $data = [];
            if (isset($submittedBids) && $submittedBids) {
                $data['status'] = 'success';
                foreach ($submittedBids as $b_index => $bid) {
                    if ($bid->type == '1') {
                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $bid->bid->uploaded_file;
                        $description = $bid->bid->job->description;
                        $img_ext = $this->getFileExtention($bid->bid->uploaded_file);
                    } else {
                        $img_ext = $this->getFileExtention($bid->catalog->uploaded_file);
                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $bid->catalog->uploaded_file;
                        $description = $bid->catalog->title;
                    }
                    if ($img_ext == 'stl') {
                        $img_type = 'stl';
                    } else {
                        $img_type = 'other';
                    }
                    if ($img_type == 'stl') {
                        $org_file_name = explode(".", $uplpoaded_file);
                        $uplpoaded_file = $org_file_name[0] . '.jpg';
                    }

                    $data['msg'] = [];
                    $data['msg'][$bid->id] = [];
                    $data['msg'][$bid->id]['uplpoaded_file'] = isset($data['msg'][$bid->id]['uplpoaded_file']) ? $uplpoaded_file : $uplpoaded_file;
                    $data['msg'][$bid->id]['uplpoaded_file'] = $data['msg'][$bid->id]['uplpoaded_file'] != '' ? $data['msg'][$bid->id]['uplpoaded_file'] : Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                    $data['msg'][$bid->id]['description'] = isset($data['msg'][$bid->id]['description']) ? $description : $description;
                    $data['msg'][$bid->id]['description'] = strlen($data['msg'][$bid->id]['description']) > 57 ? substr($data['msg'][$bid->id]['description'], 0, 57) : $data['msg'][$bid->id]['description'];
                    $data['msg'][$bid->id]['price'] = isset($data['msg'][$bid->id]['price']) ? $bid->price : $bid->price;
//                    $data['msg'][$bid->id]['img_type'] = isset($data['msg'][$bid->id]['img_type']) ? $img_type : $img_type;
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

    public function actionPurchasedCatalog() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $key = $_GET['key'];
        }
        $criteria = new CDbCriteria;
        $criteria->condition = 'status =1';
//        $criteria->limit = 4;
//        $criteria->offset = 0;
        $criteria->addSearchCondition('title', $key);
        $data['catalog'] = $allCatalogs = Catalog::model()->findAll($criteria);
//        echo "<pre>";
//        print_r($allCatalogs);
//        echo "</pre>";
//        exit;
        $data['limit'] = 4;
        $data['key'] = $key;
        $data['offset'] = 0;
        $this->render('purchased_catalog', $data);
    }

    public function actionPurchasedCatalogLoadMore($last_acc_catalog, $key) {
        $resp = [];
        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1';
        $criteria->addSearchCondition('title', $key);
        $data['catalog'] = $catalog = Catalog::model()->findAll($criteria);
        $resp['last_acc_catalog'] = $data['last_acc_catalog'] = $last_acc_catalog;
        $acc_catalogs = [];
        $i = 0;
        $last_acc_catalog = $acc_catalog = '';
        if (count($catalog) > 0) {

            foreach ($catalog as $c_key => $clg) {

                //  echo $i;
                $acc_catalog = TransactionReport::model()->findByAttributes(['bid_type' => '3','status'=>'23', 'bid_id' => $clg->id]);
                if ($acc_catalog) {
                    $i = $i + 1;
                    $acc_catalogs[] = $acc_catalog;
                    //  echo $i;
                    if ($i > 1) {
                        //  echo 'a';
                        continue;
                    }
                    //  echo 'b';
                    $last_acc_catalog = $acc_catalog->bid_id;
                }
            }
//        echo "<pre>";
//        print_r();
//        echo "</pre>";
//        exit;
//            $last_acc_catalog = $last_acc_catalog;
//                if($last_acc_catalog)
            $data['acc_catalogs'] = $acc_catalogs;
            $resp['type'] = 'success';
            $resp['msg'] = 'Data loaded successfully';
            $resp['last_acc_catalog'] = $last_acc_catalog;
            $resp['html'] = $this->renderPartial('_purchased_catalog', $data, true, false);
        } else {
            $resp['last_acc_catalog'] = '';
            $resp['type'] = 'nomore';
            $resp['msg'] = 'No more results found!';
            $resp['html'] = '';
        }

        echo json_encode($resp);
        die();
    }

    public function actionShowBidImage() {

        if (isset($_GET['img_src']) && $_GET['img_src'] != '') {
            $bidImg = $_GET['img_src'];
            $bidImg_type = $_GET['img_type'];
            if ($bidImg) {
                $resp['type'] = 'success';
                $resp['img_src'] = '';
                $resp['img_type'] = '';
                if ($bidImg_type == 'stl') {
                    $data['rawImage'] = $bidImg;
                    $resp['img_type'] = '3d';
                    $resp['content'] = $this->renderPartial('../bothDashboard/view3dDesign', $data, true, FALSE);
//                    $org_file_name = explode(".", $bidData->uploaded_file);
//                    $resp['img_src'] = Yii::app()->baseUrl . '/upload/jobs/' . $org_file_name[0] . '.jpg';
                } else {
                    $resp['img_src'] = $bidImg;
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

    public function actionUploadCatalog() {
        if (!Yii::app()->user->isGuest) {
            $this->layout = '//layouts/dashboard';
            $data = [];
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $data['model'] = $model = ManufacturerCatalog::model()->findByPk($_GET['id']);
            } else {
                $data['model'] = $model = new ManufacturerCatalog();
            }

            if (isset($_POST['ManufacturerCatalog'])) {
                $model->attributes = $_POST['ManufacturerCatalog'];
                $model->manufacturer_id = Yii::app()->user->id;
                $model->status = 0;
                $uploadedFile = CUploadedFile::getInstance($model, 'uploaded_file');

                if (!empty($uploadedFile)) {
                    $rnd = rand(0, 9999);
                    $fileName = "{$rnd}-{$uploadedFile}";
                    $model->uploaded_file = $fileName;
                } else {
                    $model->uploaded_file = '';
                }
                if ($model->validate()) {
                    $model->save();
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    if (!empty($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/manufacturer_catalog/' . $fileName);
                        if ($ext != 'stl') {
                            $image = new EasyImage(Yii::app()->basePath . '/../upload/manufacturer_catalog/' . $fileName);
                            $image->resize(225, 225);
                            $image->save(Yii::app()->basePath . '/../upload/manufacturer_catalog/thumb/' . $fileName);
                        }
                    }
                    Yii::app()->user->setFlash('success', "This is your uploaded catalog preview .Please confirm to post the catalog.");
                    $this->redirect(Yii::app()->createUrl('manufacturerDashboard/catalogConfirmation', ['id' => $model->id]));
                }
            }
            $this->render('catalog', $data);
        } else {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
    }

    public function actionCatalogConfirmation($id) {
        $this->layout = '//layouts/dashboard';
        $model = ManufacturerCatalog::model()->findByPk($id);
        $this->render('catalog_confirmation', ['model' => $model]);
    }

    public function actionCatalogConfirmationActions() {
        $catalogID = isset($_GET['id']) ? $_GET['id'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $model = ManufacturerCatalog::model()->findByPk($catalogID);
        if ($model->manufacturer_id != Yii::app()->user->id) {
            $this->redirect(Yii::app()->createUrl('site/logout'));
        } else {
            if ($model->status == '1') {
                $this->redirect(Yii::app()->createUrl('user/manufacturerDashboard'));
            } else {
                if ($type == 'cancel') {
                    $org_file_name = explode(".", $model->uploaded_file);
                    if ($this->getFileExtention($model->uploaded_file) == 'stl') {
                        unlink(Yii::app()->basePath . '/../upload/manufacturer_catalog/' . $org_file_name[0] . '.jpg');
                    }
                    unlink(Yii::app()->basePath . '/../upload/manufacturer_catalog/thumb/' . $org_file_name[0] . '.jpg');
                    unlink(Yii::app()->basePath . '/../upload/manufacturer_catalog/' . $model->uploaded_file);
                    $model = ManufacturerCatalog::model()->DeleteByPk($catalogID);
                    Yii::app()->user->setFlash('success', "You have cancelled the catalog.");
                    $this->redirect(Yii::app()->createUrl('manufacturerDashboard/uploadCatalog'));
                } else {
                    $model->status = '1';
                    $model->save(FALSE);
                    Yii::app()->user->setFlash('success', "The catalog has been posted successfully.");
                    $this->redirect(Yii::app()->createUrl('manufacturerDashboard/uploadCatalog'));
                }
            }
        }
    }

    public function actionManufacturerCatalog() {
        $key = '';
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $key = $_GET['key'];
        }
        $offset = 0;
        $limit = 4;
        $criteria = new CDbCriteria;
        $criteria->condition = "status='1'";
        $criteria->order = 'id DESC';
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->addSearchCondition('title', $key);
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['key'] = $key;
        $data['catalog'] = $all_manufacturer_catalogs = ManufacturerCatalog::model()->findAll($criteria);
        $this->render('manufacturer_catalog', $data);
    }

    public function actionManufacturerCatalogLoadMore($key, $limit, $offset) {
        $resp = [];

        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1';
        $criteria->order = 'id DESC';
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->addSearchCondition('title', $key);
        $data['catalog'] = $all_manufacturer_catalogs = ManufacturerCatalog::model()->findAll($criteria);
        $resp['limit'] = $data['limit'] = $limit;
        $resp['offset'] = $data['offset'] = $offset;
        if (count($all_manufacturer_catalogs) > 0) {
            $resp['type'] = 'success';
            $resp['msg'] = 'Data loaded successfully';
            $resp['html'] = $this->renderPartial('_manufacturer_catalog', $data, true, false);
        } else {
            $resp['type'] = 'nomore';
            $resp['msg'] = 'No more results found!';
            $resp['html'] = '';
        }


        echo json_encode($resp);
        die();
    }

}
