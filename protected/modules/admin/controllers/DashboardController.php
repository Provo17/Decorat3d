<?php

class DashboardController extends AdminController {

    public function actionIndex() {
        $this->redirect(Yii::app()->createAbsoluteUrl('admin'));
//        echo "<pre>";
//        print_r(Yii::app()->user->roles);
//        echo "</pre>";
      //  exit;
      //  $this->render('index');
    }

}