<?php

class MyprofileController extends AdminController {

    public function actionIndex() {        
        $model = AdminUserMaster::model()->findByPk(Yii::app()->user->id);
       
        $this->data['model'] = $model;
        if (isset($_POST['AdminUserMaster'])) {
            $model->attributes = $_POST['AdminUserMaster'];
            $model->scenario = 'update';

            if ($model->save()) {
                Yii::app()->user->setFlash('success_msg', "Profile updated successfully");
                $this->refresh();
            } else {
                // $erros = $model->getErrors();
                // $error = array_pop($erros);
                //Yii::app()->user->setFlash('error_msg', $error);
            }
        }
        $this->render('update', $this->data);
    }

    public function actionChangePassword() {
        $data = new AdminUserMaster('updateProfilePassword');
      
        $model = AdminUser::model()->findByPk(Yii::app()->user->id);
       
    //   $model->scenario = 'updateProfilePassword';
        if (isset($_POST['AdminUserMaster'])) {
            $model['password'] = $_POST['AdminUserMaster']['pass'];
            $model['repeat_password'] = $_POST['AdminUserMaster']['repeat_password'];

            if ($model->initialPassword == md5($_POST['AdminUserMaster']['password']) && $model->validate()) {
                $model['password'] = $_POST['AdminUserMaster']['pass'];

                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success_msg', "Password updated successfully");
                    $this->refresh();
                }
            } else {
                echo"<script>alert('You have entered wrong password!')</script>";
            }
        }
        
        $this->render('changePassword', array('model' => $data));
    }

}
