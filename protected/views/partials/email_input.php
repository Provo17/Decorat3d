<?php
Assets::loadJsFile('js/signup-signin.js');
Assets::loadPlugin(['hello']);
?>
<?php
if (Yii::app()->user->isGuest) {
    ?>

    <?php
    $script = <<< EOD

 $("form#register").submit(function(e) {
        e.preventDefault();     
        var email = $('#register_email').val();      
             
       if (validateEmail(email)) {
            $("#email_error").hide();
           window.location.href=full_path+'/user/SignupEmail?email='+email;
        
      
        }else{
        
            $("#email_error").show();
            $("#email_error").text("This is not a valid email address.");
        }

    });
        function validateEmail(email) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(email)) {
        return true;
    }
    else {
        return false;
    }
}
        
/* here you write your javascript normally in multiple lines */
EOD;

    Yii::app()->clientScript->registerScript('someId', $script);
    ?>

    <div class="col-lg-12 col-xs-12">
        <div class="resigter_input">
            <h3><?php echo Yii::t("snapfixit", "Do you need help?") ?></h3>
            <div class="register_form" style="width:54%; margin:0 auto;">
                <form method="get" id='register' action="<?php echo Yii::app()->createAbsoluteUrl('user/Signup') ?>">
                    <input type="text" class="form-control" placeholder="Email" id='register_email'>
                    <div class="has-error" ><span class="help-block" id='email_error'></span></div><br />
                    <button type="submit" class="btn btn-primary btn-lg btn-block register_button"><?php echo Yii::t("snapfixit", "REGISTER") ?></button>
                </form>
            </div>
            <div class="col-lg-12 text-center fb_sign">
                <button class="fb_button_sign ladda-button" id="fb-signin-button" data-provider="facebook" type="button" data-style="expand-left">                            
                    <span class="ladda-label"></span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>
        </div>
    </div>
<?php } ?>