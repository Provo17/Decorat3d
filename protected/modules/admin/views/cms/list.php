<?php
$this->breadcrumbs = array(
    Yii::t('string','CMS') => array('index'),
    Yii::t('string','Manage'),
);
?><div>
    <h1 style="display: inline">trabea<?php echo Yii::t('string', "Manage CMS"); ?></h1>

</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>trabea<?php echo Yii::t('string', "CMS"); ?>                </div>
            </div>
            <div class="portlet-body">
                <!----------->
                <div class="table-container">
                    <?php $widget->run();
                    ?>
                </div>
                <!----------->
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>