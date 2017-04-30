<?php

class ManageContactUsController extends AdminController {

    protected function columns() {
        return array(
            'name:text',
            'email:text',
            array(
                'name' => 'Contact Date',
                'type' => 'date',
                'value' => '$data->created_at',
                'sortable' => true,
            ),
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{view}', //{delete}
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
            ),
        );
    }

    public function actionIndex() {

        $model = new Contact('search');
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

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionError() {
        parent::actionError();
        $this->loadPageCss('error.css');
        $this->render('error-404', $this->data);
    }

    public function actionDelete($id) {

        $under_treatment_category = UnderTreatmentCategory::model()->findAllByAttributes(array('category_id' => $id));
        if ($under_treatment_category != NULL) {
            foreach ($under_treatment_category as $value) {
                $value->delete();
            }
        }

        if ($this->loadModel($id)->delete()) {

            Yii::app()->user->setFlash('success_msg', "Treatment Category Info Delete successfully");
        }
        $this->redirect(array('Index'));
    }

    public function loadModel($id) {
        $model = Contact::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
