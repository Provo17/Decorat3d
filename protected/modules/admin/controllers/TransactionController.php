<?php

class TransactionController extends AdminController
    {

    protected function columns() {
        return array(
            array(
                'header' => 'Transaction ID',
                'type' => 'text',
                'value' => '$data->transaction_id',
            ),
            array(
                'header' => 'Amount',
                'type' => 'text',
                'value' => '$data->amount',
            ),
            array(
                'header' => 'User',
                'type' => 'text',
                'value' => '$data->user->username',
            ),
            
            array(
                'header' => 'Done At',
                'type' => 'text',
                'value' => '$data->created_at',
            ),
            
            array(
                'header' => 'Through',
                'type' => 'raw',
                'value' => function($data, $row) {
            if ($data->payment_type == 1)
                {
                echo "<span><font color='#994C3E'>Paypal</font></span>";
                }
            elseif ($data->payment_type == 2)
                {
                echo "<span><font color='#A38EC5'>Credit Card</font></span>";
                }
        }),
            array(
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data, $row) {
            if ($data->status == 21)
                {
                echo "<span><font color='#4DB8DB'>Initiated</font></span>";
                }
            elseif ($data->status == 23)
                {
                echo "<span><font color='#35aa47'>Confirmed</font></span>";
                }
            elseif ($data->status == 22)
                {
                echo "<span><font color='red'>Pending</font><span>";
                }
        }),
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
//                'template' => ' {update}  &nbsp;&nbsp;{Approval}{Pending Approval} &nbsp;{delete}',
                'template' => ' {view}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
                'header' => 'Actions',
//                'buttons' => array
//                    (
//                    'Approval' => array
//                        (
//                        'label' => '',
//                        'options' => array('title' => 'Do Inactive', 'class' => 'admin_processing glyphicon glyphicon-ok'
//                        ),
//                        'visible' => '$data->status==1',
//                        'url' => 'Yii::app()->createUrl("admin/skill/cancelapprove/", array("id"=>$data->id))',
//                    ),
//                    'Pending Approval' => array
//                        (
//                        'label' => '',
//                        'options' => array('title' => 'Do Active', 'class' => 'admin_processing1 glyphicon glyphicon-remove'),
//                        'visible' => '$data->status==2||$data->status==0',
//                        'url' => 'Yii::app()->createUrl("admin/skill/approve/", array("id"=>$data->id))',
//                    ),
//                )
            ),
        );
    }

    public function actionIndex() {

        $model = new TransactionReport('search');
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
        if (Yii::app()->getRequest()->getIsAjaxRequest())
            {
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
    
     public function loadModel($id) {
        $model = TransactionReport::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    }
