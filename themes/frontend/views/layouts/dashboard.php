<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- topHeaderSection -->
<?php $this->renderPartial('//partials/header'); ?>

<!--<section class="main">-->
<section class="dash-box">
    <div class="color-box3">
        <div class="container">
            <div class="dash-in"> 
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php
                    
                    if (Yii::app()->user->user_type_id == 2)
                        {                        
                        $this->renderPartial('//menu/both_left');
                        }
                    if (Yii::app()->user->user_type_id == 3)
                        {
                        $this->renderPartial('//menu/manufacture_left');
                        }
                    ?>
                </div>
               <div class="col-md-9  col-sm-8 col-xs-12">
                    <?php echo $content ?>
               </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

</section>

<!--</section>-->
<?php $this->renderPartial('//partials/footer') ?>
<?php $this->endContent(); ?>