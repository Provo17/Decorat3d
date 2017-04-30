<?php

class DefaultController extends AdminController {

    public function actionIndex() {
        if (!Yii::app()->user->isGuest) {
            /*
              Yii::import('application.vendor.dompdf.*');
              require_once('dompdf_config.inc.php');
              Yii::registerAutoloader('DOMPDF_autoload');
              $dompdf = new DOMPDF();
              $html = $this->renderPartial('/invoice/inv-pdf', null, true);
              $dompdf->load_html($html);
              $dompdf->render();
              //file_put_contents('assets/tmp/invoice.pdf', $dompdf->output());
              $email_data = [
              'to' => 'sumanta.ghosh@infoway.us',
              //'from_email' => 'admin@yopmail.com',
              'subject' => 'Profileringsportalen :: Order return',
              'template' => 'test_mail',
              'data' => [],
              'attachement_string' => $dompdf->output(),
              'attachement_name' => 'invoice.pdf',
              ];
              $this->SendMail($email_data, false);
             */
            //return $dompdf->stream("sample.pdf");
            $this->render('/dashboard/index', $this->data);
        } else {//non login user
            $this->layout = '//layouts/auth';
            $this->loadJsPlugin('jquery-validation')
                    ->loadPageJs('login.js')
                    ->loadPageCss('login.css');
            $this->render('//login', $this->data);
        }
    }

    public function actionError() {
        parent::actionError();
//        $error = Yii::app()->errorHandler->error;
//        if ($error != NULL)
//            echo $error['message'];exit;
        $this->loadPageCss('error.css');
        $this->render('error-404', $this->data);
    }

}