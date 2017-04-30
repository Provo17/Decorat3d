<?php

class EmailNotificationController extends AdminController {

    protected function columns()
    {
        return array(
            array(
                'header' => Yii::t('string', 'Email Code'),
                'type' => 'raw',
                'value' => '$data->email_code',
                'sortable' => true,
            ),
            array(
                'header' => Yii::t('string', 'About'),
                'type' => 'raw',
                'value' => '$data->about',
                'sortable' => true,
            ),
            array(
                'header' => Yii::t('string', 'Subject'),
                'type' => 'text',
                'value' => '$data->subject',
                'sortable' => true,
            ),
            array(// display a column with "update" and "delete" buttons
                'header' => 'Actions',
                'class' => 'EButtonColumn',
                'template' => ' {update}',
//                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
//                'updateButtonUrl' => 'Yii::app()->createUrl("admin/manageCakes/details/", array("id"=>$data->id))',
            ),
        );
    }

    public function actionIndex()
    {
        $model = new EmailNotification('search');
        $model->unsetAttributes();
        $columns = $this->columns();
        $status = 1;
        /**
         * @var $widget EDataTables
         */
        $widget = $this->createWidget('ext.EDataTables.EDataTables', array(
            'id' => 'goldFixing',
            'dataProvider' => $model->search($columns, $status),
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

    public function actionCreate()
    {
        $model = new EmailNotification;

        if (isset($_POST['EmailNotification']))
        {
            $model->attributes = $_POST['EmailNotification'];
            if ($model->validate())
            {  
                $model->save(false);
                }

                Yii::app()->user->setFlash('success-msg', Yii::t('string', 'Successfully Added New Notification Content.'));
//                $email_data = [
//                    'to' => $model->email,
//                    'subject' => ' Customer Account Creation',
//                    'template' => 'sub_admin_creation',
//                    'data' => [
//                        'adminData' => $model->email
//                    ],
//                ];
//                $this->SendMail($email_data);
                $this->redirect('index');
            }
//        }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        if (isset($id))
        {
            $emailNotificationData = EmailNotification::model()->findByPk($id);
            if (!$emailNotificationData)
            {
                $this->redirect($this->createAbsoluteUrl('dashboard/'));
            }
            if (isset($_POST['EmailNotification']))
            {
                $emailNotificationData->attributes = $_POST['EmailNotification'];
                if ($emailNotificationData->validate())
                {
                    $emailNotificationData->save();
                    Yii::app()->user->setFlash('success-msg', Yii::t('string', 'Successfully updated the content.'));                   
                    $this->redirect($this->createUrl('index'));
                }
            }
            $this->render('update', ['model' => $emailNotificationData]);
        }
        else
        {
            $this->redirect('index');
        }
    }

    public function actionDelete($id)
    {
        $adminData = AdminUser::model()->findByPk($id);
        $adminData->status = 0;
        $adminData->save(FALSE);
        return $this->redirect(['index']);
        exit;
    }


}
