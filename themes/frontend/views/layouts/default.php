<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- topHeaderSection -->
<?php $this->renderPartial('//partials/header'); ?>

<!--<section class="main">-->

<?php echo $content ?>
<!--</section>-->
<?php $this->renderPartial('//partials/footer') ?>
<?php $this->endContent(); ?>