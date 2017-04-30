<?php /* @var $this Controller */ ?>
<?php
$this->bodyClass = 'login';
?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/admin/layout/img/logo.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php echo $content; ?>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">
    <?php echo date("Y"); ?> &copy; Decorat3d. Admin Dashboard.
</div>
<?php $this->endContent(); ?>