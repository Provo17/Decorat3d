<?php

class SkillController extends AdminController
    {

    protected function columns() {
        return array(
            array(
                'header' => 'Name',
                'type' => 'text',
                'value' => '$data->name',
            ),
            array(
                'header' => 'Created Date',
                'type' => 'text',
                'value' => '$data->created_at',
            ),
            array(
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data, $row) {
            if ($data->status == 0)
                {
                echo "<span><font color='#4DB8DB'>Pending Approval</font></span>";
                }
            elseif ($data->status == 1)
                {
                echo "<span><font color='#35aa47'>Active</font></span>";
                }
            elseif ($data->status == 2)
                {
                echo "<span><font color='red'>Inactive</font><span>";
                }
        }),
//                'value' => '$data->status==1 ? "<span style=\'color:#35aa47\'>Approved</span>" : "<span style=\'color:red\'>Pending Approval</span>"',
            //'value' => '$data->admin_approved==1 ? "<span style=\'color:#35aa47\'>Approved</span>" : "<span id=\'s_$data->id\'>". CHtml::link(\'Pending\',\'\',array(\'name\'=>$data->id,\'id\'=>$data->id,\'style\'=>\'color:red;cursor:pointer\',\'onclick\'=>"approval(".$data->id.")")) ."</span>"',
//                'value' => '$data->status==1 ? \'active\' : "<span id=\'status\' style=\'color: red\'> Deleted </span>" ',
//            ),
            /*  'currency.name:text', */
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => ' {update}  &nbsp;&nbsp;{Approval}{Pending Approval} &nbsp;{delete}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
                'header' => 'Actions',
                'buttons' => array
                    (
                    'Approval' => array
                        (
                        'label' => '',
                        'options' => array('title' => 'Do Inactive', 'class' => 'admin_processing glyphicon glyphicon-ok'
                        ),
                        'visible' => '$data->status==1',
                        'url' => 'Yii::app()->createUrl("admin/skill/cancelapprove/", array("id"=>$data->id))',
                    ),
                    'Pending Approval' => array
                        (
                        'label' => '',
                        'options' => array('title' => 'Do Active', 'class' => 'admin_processing1 glyphicon glyphicon-remove'),
                        'visible' => '$data->status==2||$data->status==0',
                        'url' => 'Yii::app()->createUrl("admin/skill/approve/", array("id"=>$data->id))',
                    ),
                )
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Skill();
        if (isset($_POST['Skill']))
            {
            $model->attributes = $_POST['Skill'];
            if ($model->validate())
                {
                $model->status =1;
                $model->save();
                 Yii::app()->user->setFlash('success_msg', "Skill added Successfully");
                $this->redirect(array('index'));
                }
            }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = Skill::model()->findByAttributes(array('id' => $id));
        if (!$model)
            {
            throw new CHttpException(404, 'The requested page does not exist.');
            }
//        $model->scenario = 'admin_both_update';

//         $this->performAjaxValidation($model);

        if (isset($_POST['Skill']))
            {
            $model->attributes = $_POST['Skill'];

            if ($model->validate())
                {
                $model->save();
                Yii::app()->user->setFlash('success_msg', "Skill Updated Successfully");
                $this->redirect(array('index'));
                }
            }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionIndex() {

        $model = new Skill('search');
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

    public function actionApprove($id) {
        $model = $this->loadModel($id);

        $model->status = 1;
        if ($model->save(FALSE))
            {
            $res['res'] = '<span style="color:#35aa47">Active</span>';
            $res['status'] = '<a class="admin_processing glyphicon glyphicon-ok" title="Do Inactive" rel="tooltip" href="' . Yii::app()->request->baseUrl . '/admin/skill/cancelapprove/id/' . $model->id . '" data-original-title=""></a>';
            
            echo json_encode($res);
            die;
            }
        $res['res'] = 'Error';
        echo json_encode($res);
    }

    public function actionCancelapprove($id) {
        $model = $this->loadModel($id);
        $model->status = 2;
        if ($model->save(FALSE))
            {
            $res['res'] = '<span style="color:red">Inactive</span>';
            $res['status'] = '<a class="admin_processing1 glyphicon glyphicon-remove" title="Do Active" rel="tooltip" href="' . Yii::app()->request->baseUrl . '/admin/skill/approve/id/' . $model->id . '" data-original-title=""></a>';

            echo json_encode($res);
            die;
            }
        $res['res'] = 'Error';
        echo json_encode($res);
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->status = 3;
        if ($model->save(FALSE))
            {
            return $this->redirect(['index']);
            exit;
            }
    }

    /**
     * Manages all models.
     */
    public function loadModel($id) {
        $model = Skill::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form')
            {
            echo CActiveForm::validate($model);
            Yii::app()->end();
            }
    }

    }
