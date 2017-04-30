<?php

class AdminModule extends CWebModule {

    public function init() {
        //set admin default language as english
        Yii::app()->language = 'en';
        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'module/default/error'
            ),
            'defaultController' => 'dashboard',
        ));
        $this->setModules(['settings', 'language']);
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            //'application.models.*',
            'admin.components.*',
            'ext.YiiMailer.YiiMailer',
        ));
        $this->configure(array(
            'components' => array(
                'bootstrap' => array(
                    'class' => 'ext.bootstrap.components.Booster',
                    'coreCss' => false,
                )
            )
        ));
        $this->getComponent('bootstrap');
    }

    public function beforeControllerAction($controller, $action) {

        if (parent::beforeControllerAction($controller, $action)) {
            Yii::app()->setComponent('frontendUser', Yii::app()->user);
            Yii::app()->setComponent('user', Yii::app()->adminUser);

            $route = $controller->id . '/' . $action->id;

            $publicPages = array(
                'auth/login',
                'default/error',
                'manageChat/processChatList',
                'manageChat/procesIntervalChat'
            );
            if (Yii::app()->user->isGuest && !in_array($route, $publicPages)) {
                Yii::app()->user->loginRequired();
            }
            /* if (!Yii::app()->user->isGuest && $route == 'auth/login') {
              $this->redirect('dashboard/');
              } */
            return true;
        } else
            return false;
    }

}
