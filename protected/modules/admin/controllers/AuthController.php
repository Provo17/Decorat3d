<?php

class AuthController extends AdminController {

    public $defaultAction = 'login';

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('dashboard/'));
        }
        $model = new LoginForm('login');
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            $errors = CActiveForm::validate($model);
            if ($errors != '[]') {
                echo $errors;
                Yii::app()->end();
            }
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                    echo CJSON::encode(array(
                        'authenticated' => true,
                        'redirectUrl' => Yii::app()->user->returnUrl,
                        "param" => "Any additional param"
                    ));
                    Yii::app()->end();
                }
                $this->redirect($this->createUrl('dashboard/')); //Yii::app()->user->returnUrl
            } else {                
                Yii::app()->user->setFlash('login_error', $model->getError('password'));
            }
        }
        // display the login form
        $this->layout = '//layouts/auth';
        $this->data['model'] = $model;
        $this->loadJsPlugin('jquery-validation')
                ->loadPageJs('login.js')
                ->loadPageCss('login.css');
        $this->render('login', $this->data);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->controller->createUrl('login'));
    }

}