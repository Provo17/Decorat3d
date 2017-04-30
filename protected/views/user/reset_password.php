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
                    <h1>Reset Password</h1>  
                    <br/>                    
                    <div class="col-md-12">
                        <div class="msg alert alert-danger" id="newpass_err" style="display: none;"></div>
                        <div class="msg alert alert-danger"  id="confNewPass_err" style="display: none;"></div>
                        <div class="msg alert alert-danger"  id="invalid_link_err" style="display: none;"></div>
                        <div class="registration-form">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'resetPasswordForm',
                                'action' => $this->createAbsoluteUrl('user/DoResetPassword'),
                                'enableClientValidation' => FALSE,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                            ));
                            ?> 
                            <!--<form method="post">-->                                
                            <div class="row">
<!--                                <div class="col-md-4">
                                    <div class="from-label">User Info :</div>
                                </div>-->
                                <div class="col-md-12">
                                    <div class="form-field">
                                        <input type="password" id="newPass"    class="form-control" placeholder="Type New Password">  
                                        <input type="password" id="newConfPass"  class="form-control" placeholder="Confirm New Password">
                                    </div>
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
                                        <!--<button type="submit" class="btn btn-default reg-btn">SEND ENQUIRY</button>-->
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
            $("#newpass_err").hide();
            $("#confNewPass_err").hide();
            $("#invalid_link_err").hide();
            $(".msg").html('');
            e.preventDefault();
            var l = Ladda.create(document.querySelector("#submit"));
            l.start();
            var $form = $(this),
                    url = $form.attr("action");
            jQuery.ajax({
                type: 'POST',
                cache: false,
                dataType: "json",
                data: {
                    'reset_new_password': jQuery('#newPass').val(),
                    'reset_confirm_new_password': jQuery('#newConfPass').val(),
                },
                url: "<?php echo Yii::app()->createUrl('user/DoResetPassword', ['token' => $_GET['token']]); ?>",
                success: function(data) {
                    if (data.type == 'warning') {
                        l.stop();
                        if (data.message.link) {
                            $("#invalid_link_err").show();
                            $("#invalid_link_err").html(data.message.link);
                        }
                        if (data.message.Users_reset_new_password) {
                            $("#newpass_err").show();
                            $("#newpass_err").html(data.message.Users_reset_new_password);
                        }
                        if (data.message.Users_reset_confirm_new_password) {
                            $("#confNewPass_err").show();
                            $("#confNewPass_err").html(data.message.Users_reset_confirm_new_password);
                        }

                    }
                    else if (data.type == 'success') {
                        l.stop();
                        alertify.set('notifier', 'position', 'bottom-right');
                        alertify.success('Your password reset successfully.Now You can login with your new password.');
                    }
                }
            });
            return false;
        });
    });
</script>


