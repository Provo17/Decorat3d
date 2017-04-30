<?php

class ManageUserController extends AdminController {

    protected function columns() {
        return array(
            'name:text',
            'email:text',
            'registration_no:text',
//            'address:text',
//            'pin:text',
            array(
                'name' => 'created_at',
                'type' => 'date',
                'value' => '$data->created_at',
            ),
            array(
                'header' => 'Type',
                'name'=>'role_id',
                'value' => '$data->role->role',
            ),
            array(
                'header' => 'Admin Approval',
                'type' => 'raw',
                'value' => '$data->admin_approved==1 ? "<span style=\'color:#35aa47\'>Approved</span>" : "<span id=\'s_$data->id\'>". CHtml::link(\'Pending\',\'\',array(\'name\'=>$data->id,\'id\'=>$data->id,\'style\'=>\'color:red;cursor:pointer\',\'onclick\'=>"approval(".$data->id.")")) ."</span>"',
//                'value' => '$data->status==1 ? \'active\' : "<span id=\'status\' style=\'color: red\'> Deleted </span>" ',
            ),
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{view} {update} {delete}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Users('create');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = 1;
            $model->admin_approved = 1;
            $role_name = Roles::model()->findByPk($model->role_id)->role;
            $logo = CUploadedFile::getInstance($model, 'logo');
            $valid = $model->validate();
            if ($role_name == 'store' && $logo == NULL) {
                $model->addError('logo', 'Logo cannot be blank.');
                $valid = FALSE;
            }
//            print_r($model->errors);
            if ($valid) {
                if ($model->save(false)) {
                    if ($role_name == 'store') {
                        $logo_name = '';
                        if (isset($logo)) {
                            $logo_name = time() . rand(1111111, 9999999) . $logo->name;
                            $logo->saveAs(Yii::app()->basePath . '/../upload/logo/' . $logo_name);
                        }
                        $store_details = new StoreDetails;
                        $store_details->user_id = $model->id;
                        $store_details->name = $model->name;
                        $store_details->logo = $logo_name;
                        $store_details->save();
                    }
                    Yii::app()->user->setFlash('success_msg', "User created successfully");
                    $this->redirect(array('index'));
                }
            }
//            $imageUploadFile = CUploadedFile::getInstance($model, 'profile_image');
//            if (isset($imageUploadFile)) {
//                $path = rand() . '-' . $imageUploadFile->name;
//                $model->profile_image = $path;
//            }
//
//            $model->scenario = "create";
//
//            if ($model->save()) {
//                if (isset($imageUploadFile)) {
//                    $imageUploadFile->saveAs(Yii::app()->basePath . '/../upload/profile_image/' . $path);
//                }
//                Yii::app()->user->setFlash('success_msg', "User created successfully");
//                $this->redirect(array('view', 'id' => $model->id));
//            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $storeDetails = StoreDetails::model()->findByAttributes(array('user_id' => $model->id));
        $role_name = Roles::model()->findByPk($model->role_id)->role;

        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
//            $model->updated_at = date('Y-m-d H:i:s');
            $logo = CUploadedFile::getInstance($model, 'logo');
            if(empty($model->password)){
                $model->password=$model->init_password;
            }
            $model->scenario = 'update';
            
            if ($model->save()) {
                if ($role_name == 'store' && $logo != NULL) {
                    $logo_name = time() . rand(1111111, 9999999) . $logo->name;
                    $logo->saveAs(Yii::app()->basePath . '/../upload/logo/' . $logo_name);
                    $store_details->logo = $logo_name;
                    $store_details->save();
                }
                Yii::app()->user->setFlash('success_msg', "User updated successfully");
                $this->redirect(array('index'));
//                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
//        $model = $this->loadModel($id);
//        $model->deleted_at = date('Y-m-d H:i:s');
//        $model->status = 0;
//        $model->save();
////        return $this->refresh();

        $this->loadModel($id)->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
//        $model = new Users('search');
//        $model->unsetAttributes();

        /* if (isset($_GET['Users']))
          $model->attributes = $_GET['Users'];

          $this->render('list', array('model' => $model)); */

        $model = new Users('search');
        $model->unsetAttributes();
        $columns = $this->columns();

        /**
         * @var $widget EDataTables
         */
        $widget = $this->createWidget('ext.EDataTables.EDataTables', array(
            'id' => 'goldFixing',
            'dataProvider' => $model->search($columns),
            'ajaxUrl' => $this->createUrl($this->getAction()->getId()),
            'columns' => $columns,
            'htmlOptions' => array('class' => ''),
            'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable no-footer',
            'pagerCssClass' => 'dataTables_paginate paging_bootstrap_full_number',
            //<'dataTables_toolbar'>
            'datatableTemplate' => "<r> <'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'<'pull-right'f>r>> t <'row'<'col-md-4 col-sm-12'i><'col-md-8 col-sm-12'p>>",
            'bootstrap' => true,
        ));
        $sEcho = isset($_GET['sEcho']) ? $_GET['sEcho'] : '';
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo json_encode($widget->getFormattedData(intval($sEcho)));
            Yii::app()->end();
            return;
        }
        $this->render('list', array('widget' => $widget,));
    }

    public function loadModel($id) {
        $model = Users::model()->with("storeDetails")->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAjaxAdminApprove($id) {
        $model = $this->loadModel($id);
        $model->admin_approved = 1;
        if ($model->save(FALSE)) {
            $res['res'] = '<span style="color:#35aa47">Approved</span>';
            echo json_encode($res);
            die;
        }
        $res['res'] = 'Error';
        echo json_encode($res);
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
