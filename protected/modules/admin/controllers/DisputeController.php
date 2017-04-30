<?php

class DisputeController extends AdminController {

    protected function columns() {
        return array(
            [
                'name' => 'Posted By',
                'type' => 'raw',
                'value' => 'isset($data->jobBid, $data->jobBid->job, $data->jobBid->job->job_owner)?$data->jobBid->job->job_owner->username:""'
            ],
            [
                'name' => 'Reported By',
                'type' => 'raw',
                'value' => 'isset($data->disputeFrom)?$data->disputeFrom->username:""'
            ],
            [
                'name' => 'Type',
                'type' => 'raw',
                'value' => '$data->type=="1"?"Designer Bid":""'
            ],
            [
                'name' => 'Dispute From',
                'type' => 'raw',
                'value' => '$data->showDisputeFromType()'
            ],
            array(
                'name' => 'created_at',
                'type' => 'raw',
                'value' => 'date("jS M, Y", strtotime($data->created_at))',
            ),
            [
                'name' => 'status',
                'type' => 'raw',
                'value' => '($data->status=="1")?"Active":"Inactive"'
            ],
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '{view} {update} {conversation}',
                'buttons'=>[
                    'conversation'=>[
                        'label' => '<i class="fa fa-comments"></i>',
                        'options' => ['title' => "Reviews",],
                        'url' => '$data->messages?Yii::app()->createUrl("admin/dispute/conversations/", array("id"=>$data->id)):"javascript:alert(\"There are not any reviews.\")"'
                    ]
                ],
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
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';

        $this->performAjaxValidation($model);

        if (isset($_POST['DisputeThread'])) {
            $model->attributes = $_POST['DisputeThread'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success_msg', "Dispute Thread updated successfully");
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    public function actionConversations($id){
        $models=$this->loadModel($id)->messages;
        
        if(!$models){
            Yii::app()->user->setFlash('error_msg', "There are not any reviews in this thread");
            $this->redirect(['index']);
        }
        
        $this->render('conversations', ['models'=>$models]);
    }
    
    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new DisputeThread('search');
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
        $model = DisputeThread::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dispute-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}