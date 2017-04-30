<style>
    .errorMessage{
        color: red;
    }
</style> 

<!--dash box-->
<section class="dash-box">
    <div class="color-box4">
        <div class="container">
            <div class="signup-wrap login-sec">
                <div class="row">
                    <h1>Login</h1>
                    <div class="col-md-6">
                        <div class="login-left">
                            <div class="facebook-box">
                                <img src="<?php echo Assets::themeUrl("images/facebook-box.png"); ?>" style="display:block; margin:0 auto;">
                            </div>
                            <div class="login-with">
                                <ul>
                                    <li>
                                        <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=facebook&type=employee" class="auth-service facebook"><img src="<?php echo Assets::themeUrl("images/social-login1.png"); ?>" alt="fb"></a>
<!--                                        <a href="#"><img src="<?php echo Assets::themeUrl("images/social-login1.png"); ?>"></a>-->
                                    </li>
                                    <li>
                                        <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=twitter&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-login2.png"); ?>" alt="gp"></a>
<!--                                        <a href="#"><img src="<?php echo Assets::themeUrl("images/social-login2.png"); ?>"></a>-->
                                    </li>
<!--                                    <li><a href="#"><img src="<?php echo Assets::themeUrl("images/social-login3.png"); ?>"></a></li>-->
                                    <li>
                                        <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=linkedin&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-login4.png"); ?>" alt="gp"></a>
<!--                                        <a href="#"><img src="<?php echo Assets::themeUrl("images/social-login4.png"); ?>"></a>-->
                                    </li>
                                    <li>
                                        <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=google_oauth&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-login5.png"); ?>" alt="gp"></a>
<!--                                        <a href="#"><img src="<?php echo Assets::themeUrl("images/social-login5.png"); ?>"></a>-->
                                    </li>
<!--                                    <li><a href="#"><img src="<?php echo Assets::themeUrl("images/social-login6.png"); ?>"></a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login-right">
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
                                    'id' => 'login-form',
//                    'action' => $this->createAbsoluteUrl('user/DoResetPassword'),
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                    'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                                ));
                                ?> 
                                <!--<form method="post">-->
                                <div class="form-field">
                                    <!--<input type="text" class="form-control" id="" placeholder="User Name">-->
                                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Enter your e-mail')); ?>
                                    <?php echo $form->error($model, 'username'); ?>
                                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control ', 'placeholder' => 'Password')); ?>
                                    <?php echo $form->error($model, 'password'); ?>
<!--<input type="password" class="form-control" id="" placeholder="Password">-->
                                    <p>
                                        <span class="color" style="float:left;">
                                            <input type="hidden" name="" value="0" id="">
                                            <input type="checkbox" value="1" id="" name="">
                                        </span> <span style=" float:left; font-size:13px; padding-left:10px; text-align: left;"> Remember me on this computer.</span>
                                    </p>
                                </div>
                                <div class="form-field" style="color:#4aa5ff;">
                                    <a href="<?php echo Yii::app()->createUrl('user/forgotpassword') ?>">Forgot Password?</a> | <a href="<?php echo Yii::app()->createUrl('signup') ?>">Sign Up</a>
                                </div>
                                <div class="form-field">
                                    <button type="submit" class="btn btn-default reg-btn">Log In</button>
                                </div>
                                <?php $this->endWidget(); ?>
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <!--signup-wrap-->
        </div><!--/.container-->
    </div><!--color-box3-->
</section>
<!--/dash box-->


