<?php

class PaymentReleaseController extends AdminController
    {

    protected function columns() {
        return array(
            array(
                'header' => 'Transaction ID',
                'type' => 'raw',
                'value' => '$data->transaction->transaction_id',
            ),
            array(
                'header' => 'Made By',
                'type' => 'raw',
                'value' => '$data->employer->username',
            ),
            array(
                'header' => 'Made To',
                'type' => 'text',
                'value' => '$data->getPayername($data->id)',
//                'value' => 'substr($data->description,0,70)',
            ),
            array(
                'header' => 'Created Date',
                'type' => 'text',
                'value' => '$data->created_at',
            ),
            array(
                'header' => 'Updated Date',
                'type' => 'text',
                'value' => '$data->updated_at',
            ),
            array(
                'header' => 'Payment Notification',
                'type' => 'raw',
                'value' => function($data, $row) {
            if ($data->payment_notification == 1)
                {
                echo "<span><font color='#4DB8DB'>New</font></span>";
                }
            elseif ($data->payment_notification == 2)
                {
                echo "<span><font color='#35aa47'>Viewed</font></span>";
                }
            elseif ($data->payment_notification == 3)
                {
                echo "<span><font color='red'>Payment Released</font><span>";
                }
        }),
            array(// display a column with "update" and "delete" buttons

                'class' => 'EButtonColumn',
                'template' => '  {view} &nbsp;',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'updateButtonIcon' => 'glyphicon glyphicon-pencil',
                'header' => 'Actions',
            ),
        );
    }

    public function actionIndex() {
        $model = new EmployerBoughtDesigns('search');
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
        if (isset($id))
            {
            $data['employerBD'] = $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
            if (!$employerBD)
                {
                throw new CHttpException(404, 'The requested page does not exist.');
                }

            if ($employerBD->payment_notification == '1')
                {
                $employerBD->payment_notification = 2;
                $employerBD->update(false);
                }
            $data['all_doc'] = $employerBD->getAllDoc($id); // see the function in the model

            $this->render('view', $data);
            }
        else
            {
            throw new CHttpException(404, 'The requested page does not exist.');
            }
    }

    public function actionDoReleasePayment($id) {

        $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
//        $employerBD->payment_notification = 3;
        $data['all_doc'] = $employerBD->getAllDoc($id); // see the function in the model
        if ($data['all_doc']['payment_made_to_paypal_email'] == '')
            {
            Yii::app()->user->setFlash('error', Yii::t('No paypal email is set for the user you are trying to pay.Please contact to the user.'));
            $resp['type'] = 'error';
            $resp['msg'] = 'No paypal email is set for the user you are trying to pay.Please contact to the user.';
            }
        else
            {
            $paypal_email = $data['all_doc']['payment_made_to_paypal_email'];
            $amount = $data['all_doc']['payment_amount'];
            $returnUrl = Yii::app()->createAbsoluteUrl('/admin/PaymentRelease/success/id/' . $id);
            $cancelUrl = Yii::app()->createAbsoluteUrl('/admin/PaymentRelease/view/id/' . $id);
            if ($paypal_email != '')
                {
                $params = array(
                    //'clientDetails.applicationId' => 'APP-80W284485P519543T', # App Id
                    'feesPayer' => 'SENDER', #The payer of PayPal fees. Allowable values are: SENDER, PRIMARY RECEIVER, EACH RECEIVER & SECONDARY ONLY
                    'receiverList.receiver(0).amount' => $amount, #Amount to be credited to the primary receiver's account
                    'receiverList.receiver(0).email' => $paypal_email, //'', # Primary receiver's E-mail account
                    'receiverList.receiver(0).primary' => false,
                    'returnUrl' => $returnUrl,
                    'cancelUrl' => $cancelUrl,
                    'currencyCode' => 'USD',
                );

                $response = Yii::app()->AdminPaypal->pay($params);

                $ack = $response["responseEnvelope_ack"];
                if ($ack == "Success")
                    {
                    $payKey = $response["payKey"];
                    $employerBD->payment_token = $payKey;
                    $employerBD->update();
                    $redirect_url = Yii::app()->AdminPaypal->getPayLink($payKey);
                    Yii::app()->user->setFlash('success', Yii::t('string', 'Payment made to the user successfully.'));
                    $this->redirect($redirect_url);
                    }
                else
                    {
                    Yii::app()->user->setFlash('error', Yii::t('string', 'Something went wrong.Please try again later'));
                    }
                }
            }
//        echo json_encode($resp);
    }

    public function actionSuccess($id) {
        $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
        $employerBD->payment_notification = 3;
        $employerBD->update(false);
        Yii::app()->user->setFlash('success', Yii::t('string', 'Payment made to the user successfully.'));
        $this->redirect(Yii::app()->createAbsoluteUrl('/admin/PaymentRelease/success/id/' . $id));
    }

    }
