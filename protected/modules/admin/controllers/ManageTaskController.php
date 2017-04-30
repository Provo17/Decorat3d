<?php

class ManageTaskController extends AdminController {

    protected function columns() {
        return array(
            array(
                'name' => 'Name',
                'type' => 'text',
                'value' => '$data->user->first_name." ".$data->user->last_name',
            ),
            array(
                'name' => 'Title',
                'type' => 'text',
                'value' => '$data->headline',
            ),
            array(
                'name' => 'Start Date',
                'type' => 'date',
                'value' => '$data->start_date',
            ),
            array(
                'name' => 'End Date',
                'type' => 'date',
                'value' => '$data->end_date',
            ),
            array(
                'name' => 'Post Date',
                'type' => 'date',
                'value' => '$data->created_at',
            ),
            array(
                'name' => 'Price',
                'type' => 'text',
                'value' => '$data->price',
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
        $model = new Task;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];


            $model->scenario = "create";

            if ($model->save()) {

                Yii::app()->user->setFlash('success_msg', "User created successfully");
                $this->redirect(array('view', 'id' => $model->id));
            }
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
        $taskImage = TaskImage::model()->findByAttributes(array('task_id' => $model->id));
        //   print_r($_POST);die();
        if (isset($_POST['Task'])) {
            $model->attributes = $_POST['Task'];
            $taskImage->attributes = $_POST['TaskImage'];
            $imageUploadFile = CUploadedFile::getInstance($taskImage, 'image');
            if (isset($imageUploadFile)) {
                $path = rand() . '-' . $imageUploadFile->name;
                $taskImage->image = $path;
            }
            $model->updated_at = date('Y-m-d H:i:s');

            $model->scenario = 'update';
            $taskImage->scenario = 'admin_task_update';

            if ($model->save()) {
                $taskImage->save();
                if (isset($imageUploadFile)) {
                    $imageUploadFile->saveAs(Yii::app()->basePath . '/../upload/task_image/' . $path);
                }

                Yii::app()->user->setFlash('success_msg', "Task updated successfully");
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'taskImage' => $taskImage
        ));
    }

    public function actionBid() {
        $task_id = $_POST['Task']['id'];

        if (isset($_POST['Bid'])) {
            foreach ($_POST['Bid'] as $key => $value) {
                $bid = Bid::model()->findByAttributes(array('user_id' => $key, 'task_id' => $task_id));
                $bid->status = $value;
                $bid->save();
                unset($bid);
            }
        }
        $this->redirect(Yii::app()->createAbsoluteUrl('admin/manageTask/view', array('id' => $task_id)));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $bid = Bid::model()->findAllByAttributes(array('task_id' => $id));
        foreach ($bid as $row) {
            $bid1 = Bid::model()->findByPk($row->id);
            $bid1->delete();
        }
        $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Task('search');
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Task::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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
