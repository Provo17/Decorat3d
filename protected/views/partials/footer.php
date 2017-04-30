<?php
//if ($this->beginCache('footer'))
//{
?>
<footer  class="footer">
    <div class="container">

        <ul class="foot-nav" >
            <li> <a href="<?php echo Yii::app()->createUrl('how-it-works'); ?>">  How it works </a></li>    <li> <a href="<?php echo Yii::app()->createUrl('acceptable-use-policy'); ?>"> Acceptable Use Policy</a></li>
        </ul>
        <ul class="foot-nav" >
            <li><a href="<?php echo Yii::app()->createUrl('about-us'); ?>">About us</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('site/contact'); ?>">Contact Us</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('privacy-policy'); ?>">Privacy Policy</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('terms-and-conditions'); ?>">Terms &amp; Conditions</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('faq'); ?>">FAQ</a>
        </ul>
        <div class="row">
            <div class="col-sm-12">
                <div align="center"> Copyright &copy; <?php echo date("Y"); ?>  Decorat3d, All Rights Reserved. </div>
            </div>
        </div>
    </div>
</footer>
<?php
//    $this->endCache();
//}
?>