<?php

class ManageSeoController extends AdminController {

    protected function columns() {
        return array(
            array(
                'name' => 'Title',
                'type' => 'text',
                'value' => '$data->title',
            ),
         
            array(
                'name' => 'Language',
                'type' => 'text',
                'value' => '$data->language',
            ),
            array(
                'name' => 'Route',
                'type' => 'text',
                'value' => '$data->route',
            ),
          
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{view} {update} ',
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
        $model = new Seo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        if (isset($_POST['Seo'])) {
            $model->attributes = $_POST['Seo'];
            

            $model->scenario = "create";
            
            if ($model->save()) {

                Yii::app()->user->setFlash('success_msg', "SEO created successfully");
                $this->redirect(array('index'));
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

        if (isset($_POST['Seo'])) {
            $model->attributes = $_POST['Seo'];
           
            $model->updated_at = date('Y-m-d H:i:s');

            $model->scenario = 'update';

            if ($model->save()) {
                Yii::app()->user->setFlash('success_msg', "SEO updated successfully");
                $this->redirect(array('index'));
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
        $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Seo('search');
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
        $model = Seo::model()->findByPk($id);
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
