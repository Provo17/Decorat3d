<?php

class ContactController extends AdminController {

    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if($model->status=='38'){
            $model->status = '39';
            $model->update();
        }
        
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['ContactUs'])) {
            $model->attributes = $_POST['ContactUs'];
            if ($model->validate()) {
                $model->status = '40';
                $model->update();
                
                // Send mail to 
//                $mail = new YiiMailer();
//                $email_setting = $this->get_email_data('contactus_reply', array('FULL_NAME' => $model->full_name, 'REPLY_MSG' => $model->reply));
//
//                $mail->setView('default');
//                $mail->setData(array('content' => $email_setting['body']));
//                $mail->setLayout('mail');
//                $mail->setFrom(Yii::app()->params['adminEmail'], 'Administrator');
//                $mail->setTo($model->email);
//                $mail->setSubject($email_setting['subject']);
//                $mail->send();
                
                $email_body = EmailNotification::model()->findByAttributes(array('email_code' => 'contact_reply'));
                $name = $model->name;
                $reply = $model->reply;
                $data_array = array($name,$reply);
                $replace_array = array("{{name}}","{{reply}}");
                
                $email_content = str_replace($replace_array, $data_array, $email_body->body);
               
                
                $email_data = [
                       'to' => $model->email,
                       'subject' => $email_body->subject,
                       'template' => 'email_gen',
                       'data' => ['email_content' => $email_content],
                   ];
                   $this->SendMail($email_data);  
                
                Yii::app()->user->setFlash('success_msg', "updated successfully");
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
   public function actionIndex()
	{
		$model=new ContactUs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactUs']))
			$model->attributes=$_GET['ContactUs'];

		$this->render('list', array(
            'model' => $model,
                  ));
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ContactUs the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ContactUs::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ContactUs $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'seo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
