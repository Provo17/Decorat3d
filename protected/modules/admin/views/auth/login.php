<form class="login-form" action="<?php echo $this->createUrl('login'); ?>" method="post">
    <h3 class="form-title"><?php echo Yii::t('string', "Login to your account"); ?></h3>
    <div class="alert alert-danger <?php if (!Yii::app()->user->hasFlash('login_error')): ?>display-hide<?php endif; ?>">
        <button class="close" data-close="alert"></button>
        <span><?php echo Yii::app()->user->getFlash('login_error'); ?></span>
<!--        <span>Enter any username and password.</span>-->
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php echo Yii::t('string', "Username"); ?></label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo Yii::t('string', "Username")?>" name="LoginForm[username]" value=""/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php echo Yii::t('string', "Password")?>" name="LoginForm[password]" value=""/>
        </div>
    </div>
    <div class="form-actions">   
        <button type="submit" class="btn green pull-right">
            <?php echo Yii::t('string', "Login"); ?> <i class="m-icon-swapright m-icon-white"></i>
        </button><br/>
    </div>
</form>