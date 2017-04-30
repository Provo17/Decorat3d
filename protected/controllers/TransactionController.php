<?php

class TransactionController extends FrontController {

    public function actionAddItem($id) {
        $src = isset($_GET['src']) ? $_GET['src'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';

        if ($src == 'manufacturer-bid') {
            $bidData = ManufacturerJobBid::model()->findByPk($id);
        } else if ($src == 'designer-bid') {
            $bidData = JobBid::model()->findByPk($id);
        } else if ($src == 'designer_catalog') {
            $bidData = Catalog::model()->findByPk($id);
        } else if ($src == 'manufacturer_catalog') {
            $bidData = ManufacturerCatalog::model()->findByPk($id);
        }
        $user_id = Yii::app()->user->id;
        Cart::model()->deleteAllByAttributes(array('user_id' => $user_id));

        $model = new Cart;
        $model->bid_id = $id;
        $model->user_id = $user_id;
        $model->amount = $bidData->price;
        $model->save();
        $this->redirect(Yii::app()->homeUrl . 'checkout' . '?src=' . $src . '&type=' . $type);
    }

    function actionCheckout() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }

        $design_img = $description = '';
        $src = '';

        if (isset($_GET['src']) && $_GET['src'] == 'designer-bid') {
            $src = 'dsnr';
            $data['model'] = $model = Cart::model()->with('bid')->findByAttributes(array('user_id' => Yii::app()->user->id));
            if ($this->getFileExtention($model->bid->uploaded_file) == 'stl') {
                $org_file_name = explode(".", $jobs->uploaded_file);
                $design_img = 'jobs/thumb/' . $org_file_name[0] . '.jpg';
            } else {
                $design_img = 'jobs/thumb/' . $model->bid->uploaded_file;
            }
            $description = $model->bid->job->description;
        } else if (isset($_GET['src']) && $_GET['src'] == 'manufacturer-bid') {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $src = 'manufacturer-bid';
            $data['model'] = $model = Cart::model()->with('manufacturerbid')->findByAttributes(array('user_id' => Yii::app()->user->id));
            if ($type == 'designer_bid') {
                if ($this->getFileExtention($model->manufacturerbid->bid->uploaded_file) == 'stl') {
                    $org_file_name = explode(".", $model->manufacturerbid->bid->uploaded_file);
                    $design_img = 'jobs/thumb/' . $org_file_name[0] . '.jpg';
                } else {
                    $design_img = 'jobs/thumb/' . $model->manufacturerbid->bid->uploaded_file;
                }
                $description = $model->manufacturerbid->bid->job->description;
            } else {
                if ($this->getFileExtention($model->manufacturerbid->catalog->uploaded_file) == 'stl') {
                    $org_file_name = explode(".", $model->manufacturerbid->catalog->uploaded_file);
                    $design_img = 'jobs/thumb/' . $org_file_name[0] . '.jpg';
                } else {
                    $design_img = 'catalog/thumb/' . $model->manufacturerbid->catalog->uploaded_file;
                }
                $description = $model->manufacturerbid->catalog->title;
            }
        }
//        if (isset($_GET['src']) && $_GET['src'] == 'designer-bid'){
//            $src = 'dsnr';
//            $data['model'] = $model = Cart::model()->with('bid')->findByAttributes(array('user_id' => Yii::app()->user->id));
//            if ($this->getFileExtention($model->bid->uploaded_file) == 'stl')
//                {
//                $org_file_name = explode(".", $model->bid->uploaded_file);
//                $design_img = 'jobs/thumb/' . $org_file_name[0] . '.jpg';
//                }
//            else
//                {
//                $design_img = 'jobs/thumb/' . $model->bid->uploaded_file;
//                }
//            $description = $model->bid->job->description;
//            }
        if (isset($_GET['src']) && $_GET['src'] == 'manufacturer_catalog') {
            $src = 'manufacturer_catalog';
            $data['model'] = $model = Cart::model()->with('bid')->findByAttributes(array('user_id' => Yii::app()->user->id));
            if ($this->getFileExtention($model->manufacturerCatalog->uploaded_file) == 'stl') {
                $org_file_name = explode(".", $model->manufacturerCatalog->uploaded_file);
                $design_img = 'manufacturer_catalog/thumb/' . $org_file_name[0] . '.jpg';
            } else {
                $design_img = 'manufacturer_catalog/thumb/' . $model->manufacturerCatalog->uploaded_file;
            }
            $description = $model->manufacturerCatalog->title;
        } else if (isset($_GET['src']) && $_GET['src'] == 'designer_catalog') {
            $src = 'designer_catalog';
            $data['model'] = $model = Cart::model()->with('designer_catalog')->findByAttributes(array('user_id' => Yii::app()->user->id));

            if ($this->getFileExtention($model->designer_catalog->uploaded_file) == 'stl') {
                $org_file_name = explode(".", $model->designer_catalog->uploaded_file);
                $design_img = 'catalog/thumb/' . $org_file_name[0] . '.jpg';
            } else {
                $design_img = 'catalog/thumb/' . $model->designer_catalog->uploaded_file;
            }
            $description = $model->designer_catalog->title;
        }

        $data['design_img'] = $design_img;
        $data['src'] = $src;
        $data['description'] = $description;

        //=============== Credit Card Integration ===============

        $bid_type = isset($_GET['src']) && $_GET['src'] != '' ? $_GET['src'] : 'dsnr';
        $user_id = Yii::app()->user->id;
        $model = new Cart;
        $cart_data = $model->findByAttributes(array('user_id' => $user_id));
        $pay_fund = $cart_data->amount;
        $data['creditModel'] = $creditModel = new TransactionReport('creditCard');
        if (isset($_POST['TransactionReport'])) {
            $creditModel->attributes = $_POST['TransactionReport'];
            $creditModel->tc = isset($_POST['TransactionReport']['tc']) && $_POST['TransactionReport']['tc'] != 0 ? $_POST['TransactionReport']['tc'] : '';
            if ($creditModel->validate()) {
                $paymentInfo = array(
                    'CreditCard' =>
                    array(
                        'first_name' => $creditModel->card_holder_name,
                        'credit_type' => $creditModel->credit_card_type,
                        'card_number' => $creditModel->card_number,
                        'expiration_month' => $creditModel->expiry_month,
                        'expiration_year' => $creditModel->expiry_year,
                        'cv_code' => $creditModel->cvv,
                    ),
                    'Order' =>array('theTotal' => $pay_fund)
                );
                $result = Yii::app()->Paypal->DoDirectPayment($paymentInfo);
                if (!Yii::app()->Paypal->isCallSucceeded($result)) {
                    if (Yii::app()->Paypal->apiLive === true) {
                        $error = 'We were unable to process your request. Please try again later';
                    } else {
                        $error = 'We were unable to process your request. Please try again later';
                    }
                    Yii::app()->user->setFlash('error', $error);
                    $this->refresh();
//                    $this->redirect(Yii::app()->createAbsoluteUrl('site/CreditCardDetails'));
                } else {
                    $token = urldecode($result['TRANSACTIONID']);
                    $payPalURL = Yii::app()->Paypal->paypalUrl . $token;

                    $transaction_model = new TransactionReport('paypal');
                    $transaction_model->user_id = $user_id;
                    $transaction_model->bid_id = $cart_data->bid_id;
                    if ($bid_type == 'dsnr') {
                        $transaction_model->bid_type = 1;
                    } elseif ($bid_type == 'manufacturer-bid') {
                        $transaction_model->bid_type = 2;
                    } elseif ($bid_type == 'designer_catalog') {
                        $transaction_model->bid_type = 3;
                    } elseif ($bid_type == 'manufacturer_catalog') {
                        $transaction_model->bid_type = 4;
                    }
                    $transaction_model->transaction_id = self::generateTransactionId('4');
                    $transaction_model->amount = $result['AMT'];
                    $transaction_model->token = $result['TRANSACTIONID'];
                    $transaction_model->payment_type = '2';
                    if ($transaction_model->save()) {
                        $user_id = Yii::app()->user->getId();
                        $transaction_model->status = '23';
                        $transaction_model->update();

                        $employerBoughtDesigns = new EmployerBoughtDesigns;
                        $employerBoughtDesigns->transaction_report_id = $transaction_model->id;
                        $employerBoughtDesigns->employer_id = $transaction_model->user_id;
                        $employerBoughtDesigns->track_id = $transaction_model->bid_id;
                        $employerBoughtDesigns->type = $transaction_model->bid_type;
                        $employerBoughtDesigns->status = 1;
                        $employerBoughtDesigns->save();
//                        $this->redirect($payPalURL);
                        $this->redirect(Yii::app()->createUrl('transaction/success'));
                    }
                }
            } else {
                
            }
        }
        $this->render('checkout', $data);
    }

    public function actionSuccess() {
        $this->render('confirm');
    }

    public function actionPayNow() {
        $bid_type = isset($_GET['src']) && $_GET['src'] != '' ? $_GET['src'] : 'dsnr';
        $user_id = Yii::app()->user->id;
        $model = new Cart;
        $cart_data = $model->findByAttributes(array('user_id' => $user_id));
        $pay_fund = $cart_data->amount;
        // set

        $paymentInfo['Order']['theTotal'] = $pay_fund;
        $paymentInfo['Order']['description'] = "Some payment description here";
        $paymentInfo['Order']['quantity'] = '1';

        // call paypal
        $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo);
        //Detect Errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            echo $error;
            Yii::app()->end();
        } else {
            // send user to paypal
            $token = urldecode($result["TOKEN"]);

            $payPalURL = Yii::app()->Paypal->paypalUrl . $token;

            // initiate the order
            $transaction_model = new TransactionReport('paypal');
            $transaction_model->user_id = $user_id;
            $transaction_model->bid_id = $cart_data->bid_id;
            if ($bid_type == 'dsnr') {
                $transaction_model->bid_type = 1;
            } elseif ($bid_type == 'manufacturer-bid') {
                $transaction_model->bid_type = 2;
            } elseif ($bid_type == 'designer_catalog') {
                $transaction_model->bid_type = 3;
            } elseif ($bid_type == 'manufacturer_catalog') {
                $transaction_model->bid_type = 4;
            }
            $transaction_model->transaction_id = self::generateTransactionId('4');
            $transaction_model->amount = $pay_fund;
            $transaction_model->token = $token;
            $transaction_model->payment_type = '1';
            if ($transaction_model->save()) {
                $this->redirect($payPalURL);
            } else {
                print_r($transaction_model->errors);
                exit();
            }
        }
    }

    public function actionConfirm() {

        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);

        $model = new TransactionReport;
        $transaction_data = $model->findByAttributes(array('token' => $token));

        $data['pay_fund'] = $pay_fund = $transaction_data->amount;

        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);

        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $pay_fund;

        //Detect errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            echo $error;
            Yii::app()->end();
        } else {

            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            //Detect errors
            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                if (Yii::app()->Paypal->apiLive === true) {
                    //Live mode basic error message
                    $error = 'We were unable to process your request. Please try again later';
                } else {
                    //Sandbox output the actual error message to dive in.
                    $error = $paymentResult['L_LONGMESSAGE0'];
                }
                echo $error;
                Yii::app()->end();
            } else {
                //payment was completed successfully
                $user_id = Yii::app()->user->getId();
                $transaction_data->status = '23';
                $transaction_data->update();

                $employerBoughtDesigns = new EmployerBoughtDesigns;
                $employerBoughtDesigns->transaction_report_id = $transaction_data->id;
                $employerBoughtDesigns->employer_id = $transaction_data->user_id;
                $employerBoughtDesigns->track_id = $transaction_data->bid_id;
                $employerBoughtDesigns->type = $transaction_data->bid_type;
                $employerBoughtDesigns->status = 1;
                $employerBoughtDesigns->save();

                $this->render('confirm', $data);
            }
        }
    }

    public function actionCancel() {
//        The token of the cancelled payment typically used to cancel the payment within your application
        $token = $_GET['token'];
        $model = new TransactionReport;
        $transaction_data = $model->findByAttributes(array('token' => $token));

        $transaction_data->status = '22';
        $transaction_data->update();

        $this->render('cancel');
    }

    public function actionDirectPayment() {
        $paymentInfo = array('Member' =>
            array(
                'first_name' => 'name_here',
                'last_name' => 'lastName_here',
                'billing_address' => 'address_here',
                'billing_address2' => 'address2_here',
                'billing_country' => 'country_here',
                'billing_city' => 'city_here',
                'billing_state' => 'state_here',
                'billing_zip' => 'zip_here'
            ),
            'CreditCard' =>
            array(
                'card_number' => 'number_here',
                'expiration_month' => 'month_here',
                'expiration_year' => 'year_here',
                'cv_code' => 'code_here'
            ),
            'Order' =>
            array('theTotal' => 1.00)
        );

        /*
         * On Success, $result contains [AMT] [CURRENCYCODE] [AVSCODE] [CVV2MATCH]
         * [TRANSACTIONID] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD]
         *
         * On Fail, $ result contains [AMT] [CURRENCYCODE] [TIMESTAMP] [CORRELATIONID]
         * [ACK] [VERSION] [BUILD] [L_ERRORCODE0] [L_SHORTMESSAGE0] [L_LONGMESSAGE0]
         * [L_SEVERITYCODE0]
         */

        $result = Yii::app()->Paypal->DoDirectPayment($paymentInfo);

        //Detect Errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            echo $error;
        } else {
            //Payment was completed successfully, do the rest of your stuff
        }

        Yii::app()->end();
    }

    private function generateTransactionId($digits) {
        $alphanum = "123456789";

        // generate the random string
        $rand = substr(str_shuffle($alphanum), 0, $digits);
        $time = time();
        $val = 'SB-' . $time . $rand;

        return $val;
    }

    public function actionHistory() {
        $criteria = new CDbCriteria();
        $user_id = Yii::app()->user->getId();
        $criteria->addCondition("user_id =$user_id");
        $count = TransactionReport::model()->count($criteria);
        $pages = new CPagination($count);
        // results per page
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $models = TransactionReport::model()->findAll($criteria);
        $this->render('history', array(
            'models' => $models,
            'count' => $count,
            'pages' => $pages
        ));
        //$this->render('history');
    }

    public function actionCreditCardDetails() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/Index'));
        }

        $bid_type = isset($_GET['src']) && $_GET['src'] != '' ? $_GET['src'] : 'dsnr';
        $user_id = Yii::app()->user->id;
        $model = new Cart;
        $cart_data = $model->findByAttributes(array('user_id' => $user_id));
        $pay_fund = $cart_data->amount;

        $model = new TransactionReport;
        $model->scenario = 'creditCard';
        if (isset($_POST['TransactionReport'])) {
            $model->attributes = $_POST['TransactionReport'];
            if ($model->validate()) {
                $paymentInfo = array(
                    'CreditCard' =>
                    array(
                        'credit_type' => $model->card_type,
                        'card_number' => $model->card_no,
                        'expiration_month' => $model->month,
                        'expiration_year' => $model->year,
                        'cv_code' => $model->cvvno,
                    ),
                    'Order' =>
                    array('theTotal' => Yii::app()->user->subcription_price,)
                );
                $result = Yii::app()->Paypal->DoDirectPayment($paymentInfo);
                if (!Yii::app()->Paypal->isCallSucceeded($result)) {
                    if (Yii::app()->Paypal->apiLive === true) {
                        $error = 'We were unable to process your request. Please try again later';
                    } else {
                        $error = 'We were unable to process your request. Please try again later';
                    }
                    Yii::app()->user->setFlash('error', $error);
                    $this->redirect(Yii::app()->createAbsoluteUrl('site/CreditCardDetails'));
                } else {
                    $payment_model = new SubcriptionTransuctionCredit;
                    $payment_model->amount = $result['AMT'];
                    $payment_model->paypal_transuction_id = $result['TRANSACTIONID'];
                    $payment_model->random_id = $this->rand_string(16);
                    $payment_model->user_id = Yii::app()->user->id;
                    $payment_model->ip_address = $_SERVER['REMOTE_ADDR'];
                    $payment_model->all_paypal_details = serialize($result);
                    $payment_model->transuction_date = date('Y-m-d H:i:s');
                    $payment_model->save(false);

                    $model = UserDetails::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
                    if (count($model) > 0) {
                        $model = UserDetails::model()->findByPk($model->id);
                        $model->subcription_status = 1;
                        $model->subcription_date = date('Y-m-d H:i:s');
                        $month = '+' . $this->settings['general']['subcription_validity'] . ' month';
                        $date = date("Y-m-d H:i:s");
                        $date = strtotime($date);
                        $date = strtotime("$month", $date);
                        $model->subcription_end_date = date('Y-m-d H:i:s', $date);
                        $model->save(false);
                    } else {
                        $model = new UserDetails;
                        $model->user_id = Yii::app()->user->id;
                        $model->subcription_status = 1;
                        $model->subcription_date = date('Y-m-d H:i:s');
                        $month = '+' . $this->settings['general']['subcription_validity'] . ' month';
                        $date = date("Y-m-d H:i:s");
                        $date = strtotime($date);
                        $date = strtotime("$month", $date);
                        $model->subcription_end_date = date('Y-m-d H:i:s', $date);
                        $model->save(false);
                    }
                    $user = User::model()->findByPk(Yii::app()->user->id);
                    $payment = SubcriptionTransuctionCredit::model()->findByPk($payment_model->id);
                    $email_data = [
                        'to' => $user->email,
                        'subject' => 'Milano :: Payment',
                        'template' => 'subcription_purchase',
                        'data' => ['payment' => $payment, 'user' => $user, 'type' => 'Credi Card']
                    ];
                    $this->SendMail($email_data);
                    unset(Yii::app()->session['subcription_price']);
                    Yii::app()->user->setFlash('success', 'You have successfully Subcribe .');
                    $this->redirect(Yii::app()->createAbsoluteUrl('user/Dashboard'));
                }
            } else {
                
            }
        }
        $this->render('credit_card_payment', ['model' => $model]);
    }

    // Notifying Admin About Payment Release

    public function actionNotifyReleasePayment($id) {
        if (isset($id)) {
            $resp = [];
            $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
            $employerBD->payment_notification = 1;
            if ($employerBD->update(FALSE)) {
                Yii::app()->user->setFlash('success', "Successfully Notified Admin To Release Payment .");
                $resp['type'] = 'success';
                $resp['msg'] = 'Successfully Notified Admin To Release Payment ';
            }
        }
        echo json_encode($resp);
        die();
    }

}
