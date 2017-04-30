<?php

class PagesController extends AdminController {

    protected function columns() {
        return array(
            array(
                'header' => ' ID',
                'type' => 'text',
                'value' => '$data->id',
            ),
            array(
                'header' => 'Slug',
                'type' => 'text',
                'value' => '$data->slug',
            ),
            array(
                'header' => 'Title',
                'type' => 'text',
                'value' => '$data->title',
            ),
            array(
                'header' => 'Created Date',
                'type' => 'text',
                'value' => '$data->created_at',
            ),
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{view} {update}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
                'header' => 'Actions',
            ),
        );
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {


        $model = Page::model()->findByAttributes(array('id' => $id));
        if (!$model) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model->scenario = 'page_update';

        // $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success_msg', "Page Content Updated Successfully");
                $this->redirect(array('index'));
//                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionIndex() {
//        $model = new Users('search');
//        $model->unsetAttributes();

        /* if (isset($_GET['Users']))
          $model->attributes = $_GET['Users'];

          $this->render('list', array('model' => $model)); */

        $model = new Page('search');
        $model->unsetAttributes();
        $columns = $this->columns();
        $role = 2;

        /**
         * @var $widget EDataTables
         */
        $widget = $this->createWidget('ext.EDataTables.EDataTables', array(
            'id' => 'goldFixing',
            'dataProvider' => $model->search($columns, $role),
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->status = 0;
        $model->admin_approved = 2;
        if ($model->save(FALSE)) {
            $success['msg'] = "deleted";
            echo json_encode($success);
            die;
        }
        $success['msg'] = 'Error';
        echo json_encode($success);
//        return $this->refresh();
//        $this->loadModel($id)->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function loadModel($id) {
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAjaxAdminApprove($id) {
        $model = $this->loadModel($id);
        $model->admin_approved = 1;
        if ($model->save(FALSE)) {
            $res['res'] = '<span style = "color:#35aa47">Approved</span>';
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
