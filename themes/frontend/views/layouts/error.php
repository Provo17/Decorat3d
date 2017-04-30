<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- topHeaderSection -->
<header>
    <div class="header-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="logo">
                        <a href="<?= $this->createAbsoluteUrl('site/index') ?>" title="Home">
                            <img class="img-responsive center-block" src="<?php echo Assets::themeUrl("images/logo.png") ?>" alt="logo"/>
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="main">
                    <?php echo $content ?>
</section>
<footer>
    <address>&copy; <a href="<?php echo Yii::app()->baseUrl ?>" title="RobustWealth">Robustwealth</a> <?php echo date('Y') ?>. All Right Reserved.</address>
</footer>
<?php $this->endContent(); ?>