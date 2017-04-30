<style>
    .errorMessage{
        color:red;
    }
</style>
<!--dash box-->
<section class="dash-box">
    <div class="color-box4">
        <div class="container">
            <div class="signup-wrap">
                <div class="row">
                    <h1>Contact Us</h1>         
                    <div class="col-md-12">
                        <div class="registration-form">
                            <?php if (Yii::app()->user->hasFlash('success')): ?>
                                <br/>
                                <div role="alert" class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo Yii::app()->user->getFlash('success'); ?>
                                </div>
                            <?php endif; ?>  
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'contact-Form',
//                    'action' => $this->createAbsoluteUrl('user/DoResetPassword'),
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                            ));
                            ?> 
                            <!--<form method="post">-->                                
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">User Info :</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Name')); ?>
                                        <?php echo $form->error($model, 'name'); ?>
                                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                        <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'placeholder' => 'Contact Number')); ?>
                                        <?php echo $form->error($model, 'phone'); ?>  
                                        <?php echo $form->textArea($model, 'message', array('rows' => 7, 'class' => 'form-control', 'placeholder' => 'Write Your Message Here..')); ?>
                                        <?php echo $form->error($model, 'message'); ?>
<!--                                            <input type="text" class="form-control" id="" placeholder="User Name">
                                        <input type="email" class="form-control" id="" placeholder="Email">
                                        <input type="password" class="form-control" id="" placeholder="Password">
                                        <input type="text" class="form-control" id="" placeholder="Zip Code">-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <button type="submit" class="btn btn-default reg-btn">SEND</button>
                                        <a href="<?php echo Yii::app()->createUrl('site/index'); ?>">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                            <!--</form>-->
                        </div>
                    </div>
                </div>
            </div>
            <!--signup-wrap-->
        </div><!--/.container-->
    </div><!--color-box3-->
</section>
<!--/dash box-->