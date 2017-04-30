<style>
    .page-logo .logo-default {
    margin: 5px 0 0 0 !important;
}
</style>
<div class="page-header-inner">    
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="<?php echo $this->createUrl('dashboard/') ?>"  style="color: #428bca;
    padding-top: 8px;
    display: inline-block;
    padding-left: 10px;
    font-size: 16px;
    font-family: 'Open Sans', sans-serif;
    ">
            <img  src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/admin/layout/img/logo.png" alt="logo" class="logo-default" />            
        </a>
        <div class="menu-toggler sidebar-toggler hide">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown dropdown-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" class="img-circle" src="<?php echo Yii::app()->theme->getBaseUrl() ?>/assets/admin/layout/img/default_admin_img.png"/>
                    <span class="username username-hide-on-mobile"><?php echo Yii::app()->user->name; ?></span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo $this->adminUrl('myprofile/'); ?>">
                            <i class="icon-user"></i> My Profile </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo $this->adminUrl('myprofile/changepassword'); ?>">
                            <i class="icon-lock"></i> Change Password </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo $this->adminUrl('auth/logout'); ?>">
                            <i class="icon-key"></i> Log Out </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
</div>