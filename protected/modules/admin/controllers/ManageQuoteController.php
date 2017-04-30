<?php

class ManageQuoteController extends AdminController {

    protected function columns() {
        return array(
            array(
                'header' => 'Quote ID',
                'type' => 'text',
                'value' => '$data->quotes_id',
            ),
            array(
                'header' => 'Customer ID',
                'type' => 'text',
                'value' => '$data->customer_id',
            ),
            array(
                'header' => 'Discount %',
                'type' => 'text',
                'value' => '$data->discount',
            ),
            array(
                'name' => 'Total',
                'type' => 'text',
                'value' => '$data->total',
            ),
            array(
                'name' => 'Created At',
                'type' => 'date',
                'value' => '$data->created_at',
            ),
            array(
                'name' => 'Status',
                'type' => 'text',
                'value' => function($data, $row) {
            if ($data->confirmation == 1) {
                echo "<font color='#4DB8DB'>Confirmed</font>";
            } elseif ($data->status == 0) {
                echo "<font color='red'>Draft</font>";
            } elseif ($data->status == 1) {
                echo "<font color='green'>Quote Sent</font>";
            } elseif ($data->status == 3) {
                echo "Reject";
            }
        },
            ),
            array(// display a column with "update" and "delete" buttons
                'class' => 'EButtonColumn',
//                'template' => '{view}  {delete}',
                'template' => '{view}',
                'viewButtonIcon' => 'glyphicon glyphicon-eye-open',
                //'historyButtonIcon' => 'glyphicon glyphicon-envelope',
//                'historyButtonUrl' => 'Yii::app()->controller->createUrl("message",array("id"=>$data->primaryKey))',
                'deleteButtonIcon' => 'glyphicon glyphicon-trash',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
                'header' => 'Actions',
            ),
        );
    }

    public function actionIndex() {
        $quotes = new Quotes('CreateQuote');
        $quoteOrder = new QuotesDetails('CreateQuote');

        if (isset($_POST['Quotes']) && isset($_POST['QuotesDetails'])) {
            $data = Users::model()->findByPk($_POST['Quotes']['customer']);
            $quotes->attributes = $_POST['Quotes'];
            $quotes->discount = $data->discount;
            $quotes->status = 0;
            $quotes->customer_id = $data->customer_id;
            $quotes->save(FALSE);
            foreach ($_POST['QuotesDetails']['proofread_id'] as $key => $value) {
                $quoteOrder = new QuotesDetails('CreateQuote');
                $quoteOrder->quotes_id = $quotes->id;
                $quoteOrder->proofread_id = $_POST['QuotesDetails']['proofread_id'][$key];
                $quoteOrderRows[] = $quoteOrder;
                $saved = $quoteOrder->save();
            }
            if ($saved) {
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/manageQuote/update', array('qid' => $quotes->id))); //                      
            }
//  $validate = $quotes->validate();
// $valid = TRUE;
//            foreach ($_POST['QuotesDetails']['proofread_id'] as $key => $value) {               
//                $quoteOrder = new QuotesDetails('CreateQuote');
//                $quoteOrder->proofread_id = $_POST['QuotesDetails']['proofread_id'][$key];
//                $quoteOrderRows[] = $quoteOrder;
//                if (!$quoteOrder->validate()) {
//                    $valid = FALSE;
//                    break;
//                }
//            }
//            if ($validate && $valid) {
//                $quotes->customer_id = $data->customer_id;
//                $quotes->save(FALSE);
//                foreach ($quoteOrderRows as $key => $obj) {                      
//                    $quoteOrder = new QuotesDetails('CreateQuote');
//                    $obj->quotes_id = $quotes->id;                    
//                    if($obj->save(false)) {
//                        // echo "<script>alert('Quote Added Successfully!')</script>";     
//                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/manageQuote/update', array('qid' => $quotes->id))); //                      
//                    }
//                }
//            }
        }

        $model = new Quotes('search');
        $model->unsetAttributes();
        $columns = $this->columns();
        //$model->type = 2;
        //$model->status = 1;
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
        $this->render('list', array('widget' => $widget,
            'model' => $quotes,
            'quoteOrder' => $quoteOrder));
    }

    public function actionView($id) {
        $Quotes = Quotes::model()->findByPk($id);
        if (!$Quotes) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $QuotesDetails = QuotesDetails::model()->findAll('quotes_id=:quotes_id', array('quotes_id' => $id));
        $this->render('view', array('quoteOrder' => $QuotesDetails, 'quotes' => $Quotes));
    }

    public function actionMessage($id) {
        $model = $this->loadModel($id);
        $messagemodel = QuoteMessage::model()->findAll("quote_id='{$id}'");
        $this->render('message', array(
            'model' => $model,
            'messagemodel' => $messagemodel,
        ));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
        return $this->redirect(['index']);
        exit;
    }

    public function actionSendMessage() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new QuoteMessage;

            $image_name = "";
            $rnd = rand();
            $uploadedFile = CUploadedFile::getInstanceByName('Quote[image]');
            $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
            if (!empty($uploadedFile)) {
                $model->image_name = $fileName;
            }
            $model->quote_id = $_POST['quote_id'];
            $model->to = 1;
            $model->from = Yii::app()->user->id;
            $model->message = isset($_POST['message']) ? $_POST['message'] : "";
            $model->send_time = date('Y-m-d H:i:s');
            $model->status = 1;
            $user = User::model()->findByPk(Yii::app()->user->id);
            if ($model->save()) {
                if (!empty($uploadedFile)) {
                    $uploadedFile->saveAs(Yii::app()->basePath . '/../upload/print_image/' . $fileName);  // image will uplode to rootDirectory/banner/
                }
                $html = $this->renderPartial("_message", ['name' => "Admin", 'image' => $model->image_name, 'message' => $model->message,], true);
                echo json_encode(array('html' => $html, 'Status' => "SUCC"));
                exit;
            } else {

                echo json_encode(array('html' => $model->getErrors(), 'Status' => "ERR"));
                exit;
            }
        }
    }

    function actionDownloadFiles($id) {

        $files = QuoteImages::model()->findAll("quote_id='{$id}'");

        $archive_file_name = Yii::app()->basePath . '/zip/myzip.zip';
//echo $archive_file_name;die;
        $zip = new ZipArchive();
        if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
            exit("cannot open <$archive_file_name>\n");
        }

        foreach ($files as $v) {
            $zip->addFile(Yii::app()->basePath . '/../upload/print_image/' . $v->file_name, $v->file_name);
        }
        $zip->close();


        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . 'myzip.zip');
        header('Content-Length: ' . filesize($archive_file_name));
        readfile($archive_file_name);
        unlink($archive_file_name);
        exit;
    }

    function actionUpdateStatus($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $quote = $this->loadModel($id);
            if ($quote->save()) {
                $quote->status = $_POST['status'];
                $quote->price = $_POST['price'];
                $quote->save(false);
                echo json_encode(array('status' => "OK"));
            } else {
                echo json_encode(array('status' => "ERROR"));
            }
        }
    }

    public function actionDownloadImage() {
        $image_name = $_GET['image_name'];

        $fileDir = Yii::app()->basePath . '/../upload/print_image/';
        Yii::app()->request->sendFile(
                $image_name, file_get_contents($fileDir . $image_name), $image_name
        );
    }

    public function loadModel($id) {
        $model = Quote::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionUpdate() {
        if (isset($_GET['qid'])) {
            $qid = $_GET['qid'];
            $model = new Quotes;
            $quoteOrder = new QuotesDetails;
            $data1 = Quotes::model()->findByPk($qid);
            if (!$data1) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            $data = QuotesDetails::model()->findAll('quotes_id=:quotes_id', array('quotes_id' => $qid));

            $this->render('update', array('quoteOrder' => $data, 'quotes' => $data1));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionProofreadDropdown() {
        if (isset($_GET['id'])) {
            $uid = $_GET['id'];

            $data1 = Proofread::model()->findAllByAttributes(
                    array('user_id' => $uid), array(
                'condition' => 'status = :status',
                'params' => array(':status' => '1')
                    )
            );

            //$data1 = Proofread::model()->findAll('user_id = :user_id', array(':user_id' => $uid));
            $record = Users::model()->findByPk($uid);
            if ($record) {
                $resp['discount'] = $record['discount'];
            }
            $resp['msg'] = 'Success';
            $options = "<option value=''>------ Select ------</option>";
            foreach ($data1 as $key => $value) {
// echo $form->dropDownList($model, 'state', array($data1[$key]['stateID'] => $data1[$key]['stateName']), array('prompt' => ' ------Select State ------', 'class' => 'form-control'));
                $options .= CHtml::tag('option', array('value' => $data1[$key]['proofread_id']), CHtml::encode($data1[$key]['proofread_id']), true);
            }
            $resp['options'] = $options;
            echo json_encode($resp);
            exit;
        }
    }

    public function actionProductDropdown() {
        $record = Users::model()->findByAttributes(['customer_id' => $_GET['id']]);

        $data1 = Product::model()->findAll('created_by = :created_by', array(':created_by' => $record->id));
//        echo "<pre>";
//        print_r($record);
//        echo "</pre>";
//        exit;
        echo "<option value=''>------ Select ------</option>";
        foreach ($data1 as $key => $value) {
            echo CHtml::tag('option', array('value' => $data1[$key]['product_id']), CHtml::encode($data1[$key]['name']), true);
        }
    }

    public function actionOrgPrice() {
        $res = [
            'msg' => '',
            'type' => 'error', //error or success
            'status' => '',
        ];
        if (isset($_GET['pid'])) {
            $record = Product::model()->findByAttributes(['product_id' => $_GET['pid']]);
            if ($record) {
                $res['type'] = 'success';
                $res['oprice'] = $record->price;
            } else {
                $res['msg'] = "No data found";
                $res['type'] = 'error';
            }
            echo json_encode($res);
            exit;
        }
    }

    public function actionUpdateProcess() {
        $resp = [
            'msg' => '',
            'type' => 'error', //error or success
            'status' => '',
        ];
        if (isset($_GET['qid'])) {
            $qid = $_GET['qid'];
            $model = new Quotes;
            $quoteOrder = new QuotesDetails;
            $data = QuotesDetails::model()->findAll('quotes_id = :quotes_id', array('quotes_id' => $qid));

            $data1 = Quotes::model()->findByPk($qid);
            $cusomerDetails = Users::model()->findByAttributes(['customer_id' => $data1->customer_id]);

            if (isset($_POST['QuotesDetails'])) {
                if ($_POST['Quotes']['total'] == '') {
                    $data1->subtotal = $data1->subtotal;
                    $data1->total = $data1->total;
                } else {
                    $data1->total = $_POST['Quotes']['total'];
                    $data1->subtotal = $_POST['Quotes']['subtotal'];
                }
                $data1->status = $_POST['Quotes']['status'];
                $data1->updated_at = date('Y-m-d H:i:s');
                $valid = TRUE;
                foreach ($data as $key => $value) {
                    $quoteOrder = new QuotesDetails;
                    $value['supplier_id'] = $_POST['QuotesDetails']['supplier_id'][$key];
                    $value['product_id'] = $_POST['QuotesDetails']['product_id'][$key];
                    $value['price'] = $_POST['QuotesDetails']['price'][$key];
                    $value['quantity'] = $_POST['QuotesDetails']['quantity'][$key];
                    if ($_POST['QuotesDetails']['total'][$key] == '') {
                        $value['total'] = $value['total'];
                    } else {
                        $value['total'] = $_POST['QuotesDetails']['total'][$key];
                    }
                    if (!$value->validate()) {
                        $valid = FALSE;
                        $res['msg'] = $value->getErrors();
                        $res['type'] = 'error';
                        break;
                    } else {
                        $quoteSave = $data1->save(FALSE);
                        $data2 = Users::model()->findByPk($_POST['QuotesDetails']['supplier_id'][$key]);
                        $data = QuotesDetails::model()->findAll('quotes_id = :quotes_id', array('quotes_id' => $qid));
                        //$value['supplier_id'] = $data2->customer_id;
                        $value['supplier_id'] = $_POST['QuotesDetails']['supplier_id'][$key];
                        $quote_details_save = $value->save(FALSE);

                       
                        $res['msg'] = 'Successfully updated.';
                        $res['type'] = 'success';
                        $res['status'] = $_POST['Quotes']['status'];
                    }
                }
                  if ($quoteSave && $quote_details_save && $data1->status == 1) {
                            $email_data = [
                                'to' => $cusomerDetails->email,
                                'subject' => 'Profileringsportalen.no har sendt deg et tilbud.',
                                'template' => 'asking_quote_approval',
                                'data' => [
                                    'cusomerDetails' => $cusomerDetails
                                ],
                            ];
                            $this->SendMail($email_data);
                        }
            } else {
                $res['msg'] = "No data submited.";
                $res['type'] = 'error';
            }
        } else {
            $res['msg'] = "No quote ID found.";
            $res['type'] = 'error';
        }
       
        echo json_encode($res);
        exit;
    }

}
