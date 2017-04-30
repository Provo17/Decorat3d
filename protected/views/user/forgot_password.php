<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/ladda-bootstrap/ladda-themeless.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/alertify-dialog/themes/alertify.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/alertify-dialog/themes/alertify.core.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/alertify-dialog/lib/alertify.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/alertify-dialog/src/alert_custom.js"></script>

<!--dash box-->
<section class="dash-box">
    <div class="color-box4">
        <div class="container">
            <div class="signup-wrap">
                <div class="row">
                    <h1>Forgot Password</h1>  
                    <br/>                    
                    <div class="col-md-12">
                        <div class="msg alert alert-danger" style="display: none;"></div>
                        <div class="registration-form">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'ForgotPasswordForm',
                                'action' => $this->createAbsoluteUrl('user/DoForgotPassword'),
                                'enableClientValidation' => FALSE,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                            ));
                            ?> 
                            <!--<form method="post">-->                               
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="email" id="inputEmail" name="email"  class="form-control input-lg" placeholder="Enter your e-mail">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-label">&nbsp;</div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-field">
                                        <button id="submit"  type="button" class="btn ladda-button" data-style="expand-left" data-color="info">
                                            <span class="ladda-label"><?php echo Yii::t('label', 'Submit') ?></span>
                                            <span class="ladda-spinner"></span>
                                        </button>
                                        <a href="<?php echo Yii::app()->createUrl('login') ?>">Cancel</a>
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
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/ladda-bootstrap/spin.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/themes/frontend/assets/vendor/ladda-bootstrap/ladda.min.js"></script>
<script>
    jQuery(function($) {
        $('#submit').on('click', function(e) {
            $(".msg").hide();
            $(".msg").html('');
            e.preventDefault();
            var l = Ladda.create(document.querySelector("#submit"));
            l.start();
//            var $form = $(this),
//                    url = $form.attr("action");
            jQuery.ajax({
                type: 'POST',
                cache: false,
                dataType: "json",
                data: {'email': jQuery('#inputEmail').val()},
                url: "<?php echo Yii::app()->createUrl('user/DoForgotPassword'); ?>",
                success: function(data) {
                    if (data.type == 'warning' && data.message.email) {
                        l.stop();
                        $(".msg").show();
                        $(".msg").html(data.message.email);
                    }
                    if (data.type == 'warning' && data.message.invalid_email) {
                        l.stop();
                        $(".msg").show();
                        $(".msg").html(data.message.invalid_email);
                    }
                    else if (data.type == 'success') {
                        l.stop();
                        alertify.set('notifier', 'position', 'bottom-right');
                        alertify.success('Password Reset Link Has Been Sent To Your Email.');
                    }
                }
            });
            return false;
        });
    });
</script>

