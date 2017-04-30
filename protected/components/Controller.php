<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $pageName = '';
    public $pageDetails = '';
    /*
     * store ajax response details
     */
    public $ajax_resp = [];

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        //for ajax request
        $this->ajax_resp['type'] = 'success';
        $this->ajax_resp['message'] = '';
    }

    public function SendMail($data, $php_mail = true)
    {
        $email = [
            'to' => $data['to'],
            'subject' => $data['subject'],
            'template' => $data['template'], //view file to render
            'data' => $data['data'], //view file to render
            'from_email' => isset($data['from_email']) ? $data['from_email'] : 'no-reply@decorat3d.com', //view file to render
            'from_name' => isset($data['from_name']) ? $data['from_name'] : 'Decorat3d.com', //view file to render
        ];

        if ($php_mail)
        {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: admin@decprat3d.com' . "\r\n" .
                        'Reply-To: no-reply@decprat3d.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
            $content = $this->renderPartial('//mail/' . $email['template'], $email['data'], true, false);
            // mail($email['to'], $email['subject'], $content, $headers);
        }
        
        
        $mail = new YiiMailer();
        $mail->UseSendmailOptions = false;
        //addStringAttachment
        if (isset($data['attachement_string']))
        {
            $mail->addStringAttachment($data['attachement_string'], $data['attachement_name']);
        }

        $mail->setView($email['template']);
        $mail->setData($email['data']);
        $mail->setFrom($email['from_email'], $email['from_name']);
        $mail->setTo($email['to']);
        $mail->setSubject($email['subject']);
        //$mail->setAttachment('something.pdf');
        //$mail->setSmtp('smtp.gmail.com', 465, 'ssl', true, 'sumanta.ghosh@gmail.com', 'xxxxxx');
        
        return $mail->send();
        //echo $mail->getError();
        //exit;
    }

    public function renderAjax($data = [], $type = 'json')
    {
        $this->ajax_resp['is_login'] = !Yii::app()->user->isGuest;
        $temp = array_merge($data, $this->ajax_resp);
        //header('Content-type: application/json');
        echo CJSON::encode($temp);
        Yii::app()->end();
    }

    public function generatePassword($digits = 8)
    {
        $alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $num = "0123456789";
        $spec = "@#$%&)(";
        $rand = substr(str_shuffle($alpha), 0, ($digits - 3));
        $rand.= substr(str_shuffle($spec), 0, 1);
        $rand.= substr(str_shuffle($num), 0, 2);

        $val = $rand;

        return $val;
    }

//To  Get Admin Email
    public function AdminEmail()
    {
        $admin = AdminUser::model()->findByPk(1);
        $admin_email = $admin->email;
        return $admin_email;
    }

    public function render($view, $data = null, $return = false)
    {
//        $cs = Yii::app()->clientScript;
//        if ($this->pageName)
//        {
//            $seo = Page::model()->findByAttributes(array('slug' => $this->pageName));
//        }
//        if (isset($seo) && $seo != NULL)
//        {
//            $this->pageDetails = $seo;
//            $cs->registerMetaTag($seo->seo_title, null, null, array('property' => 'og:title'));
//            $cs->registerMetaTag($seo->meta_description, null, null, array('name' => 'meta_description'));
//            $cs->registerMetaTag($seo->meta_keywords, null, null, array('name' => 'keywords'));
//            $this->pageTitle = $seo->seo_title;
//        }
//        else
//        {
//            $this->pageTitle = Yii::app()->name;
//        }
//        $cs->registerMetaTag('width=device-width, initial-scale=1, maximum-scale=1', null, null, array('name' => 'viewport'));
        parent::render($view, $data, $return);
    }

}
