<!--dash box-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<section class="dash-box">
    <div class="color-box4">
        <div class="container">
            <div class="signup-wrap">
                <div class="row">
                    <h1>Register</h1>
                    <div class="col-md-12">
                        <?php if (Yii::app()->user->hasFlash('success')): ?>
                            <br/>
                            <div role="alert" class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php endif; ?> 
                        <?php if (Yii::app()->user->hasFlash('error')): ?>
                            <br/>
                            <div role="alert" class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </div>
                        <?php endif; ?> 

                        <div class="social-login">
                            <ul>
                                <li><h5>Sign In Using  -</h5></li>
                                <li>
                                    <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=facebook&type=employee" class="auth-service facebook"><img src="<?php echo Assets::themeUrl("images/social-ico1.png"); ?>" alt="fb"></a>
<!--                                    <a href="#"><img src="<?php echo Assets::themeUrl("images/social-ico1.png"); ?>"></a>-->
                                </li>
                                <li>
                                    <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=twitter&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-ico2.png"); ?>" alt="gp"></a>
<!--                                    <a href="#"><img src="<?php echo Assets::themeUrl("images/social-ico2.png"); ?>"></a>-->
                                </li>
                                <li>
                                    <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=linkedin&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-ico3.png"); ?>" alt="gp"></a>
<!--                                    <a href="#"><img src="<?php echo Assets::themeUrl("images/social-ico3.png"); ?>"></a>-->
                                </li>
<!--                                <li><a href="#"><img src="<?php echo Assets::themeUrl("images/social-ico4.png"); ?>"></a></li>-->
                                <li>
                                    <a  href="<?php echo Yii::app()->homeUrl; ?>sns-auth?service=google_oauth&type=employee" class="auth-service google_oauth"><img src="<?php echo Assets::themeUrl("images/social-ico5.png"); ?>" alt="gp"></a>
<!--                                    <a href="#"><img src="<?php echo Assets::themeUrl("images/social-ico5.png"); ?>"></a>-->
                                </li>
                            </ul>
                        </div>
                        <div class="or-divider"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="registration-form">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'signup-form',
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
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <!--                                        <label>
                                                                                    <input type="radio" name="UserMaster[user_type_id]" id="" value="2" checked>
                                                                                    Emplyer or Cad Designer
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="UserMaster[user_type_id]" id="" value="3">
                                                                                    Manufacturer
                                                                                </label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">User Info :</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'User Name')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
                                        <?php echo $form->error($model, 'password'); ?>
                                        <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>
                                        <?php echo $form->error($model, 'zip'); ?>
                                    </div>
                                </div>
                            </div>                                     
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">Security Question :</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">       
                                        <?php echo $form->dropDownList($model, 'security_question_id', $securityQuestions,array('class' => 'form-control', 'prompt' => 'Please select question')); ?>                                        
<!--                                        <select name="UserMaster['security_question_id']" id="basic" class="selectpicker form-control">
                                            <option value="-">Please select question</option>
                                            <?php
                                            if ($securityQuestions)
                                                {
                                                foreach ($securityQuestions as $index => $questions)
                                                    {
                                                    ?>
                                                    <option class="question1"  value="<?php echo $index; ?>"><?php echo $questions; ?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </select>-->
                                        <?php echo $form->error($model, 'security_question_id'); ?>
                                        <?php echo $form->textField($model, 'security_question_ans', array('class' => 'form-control', 'placeholder' => 'Answer')); ?>
                                        <?php echo $form->error($model, 'security_question_ans'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">Security :</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <div class="captcha">
                                            <?php $recaptcha_sitekey = Settings::model()->findByAttributes(array('slug' => 'google_recaptcha_sitekey')); ?>
                                            <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_sitekey->value; ?>"></div>
                                            <?php if ($captcha_msg != ''): ?><span class='errorMessage'><?php echo $captcha_msg; ?></span><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <p>
                                            <span class="color" style="float:left;">
                                                <input type="hidden" name="" value="0" id="">
                                                <input type="checkbox" value="1" id="UserMaster_accept_term_condition" name="UserMaster[accept_term_condition]">                                                
                                            </span> <span style=" float:left; font-size:13px; padding-left:10px; text-align: left;"> I have read, understood &amp; agree to the <a  data-toggle="modal" href="#large"  title="" style="color:#0076EC;"> Terms &amp; Policies</a></span>
                                        </p>                                        
                                    </div>
                                    <?php echo $form->error($model, 'accept_term_condition'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <button type="submit" class="btn btn-default reg-btn">Register</button>
                                        <a href="#">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <p>
                                            <span style="font-size:13px;">Already have an account? <a href="<?php echo Yii::app()->createUrl('login') ?>" target="_blank" title="" style="color:#0076EC;">Login</a></span>
                                        </p>
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
<script src="<?php echo Assets::themeUrl("js/bootstrap-select.js"); ?>"></script>
<script>
    $(document).ready(function() {
        var mySelect = $('#first-disabled2');

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    });
</script>
<!-- /.modal -->
<div class="modal fade bs-modal-lg " id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modalPart" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Terms & Policies</h4>
            </div>
            <div class="modal-body">
                <?php
                if (isset($tc))
                    {
                    echo $tc;
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default signButton" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn blue">Save changes</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
