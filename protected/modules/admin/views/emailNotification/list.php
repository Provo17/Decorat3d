<?php
$this->breadcrumbs = array(
    Yii::t('string', 'Email Notifications')
);
?>
<div>
    <h1 style="display: inline"><?php echo Yii::t('string', "Manage Email Notifications"); ?></h1>
    <?php if (Yii::app()->user->hasFlash('success-msg')): ?>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success-msg'); ?>
        </div>
    <?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('error-msg')): ?>
        <div role="alert" class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('error-msg'); ?>
        </div>
    <?php endif; ?>
    <div class="pull-right">        
        <!--<a class="btn green" href="<?php echo Yii::app()->createUrl('admin/emailnotification/create');?>"> Add New</a>-->
    </div>
</div>
<br/><br/>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pencil"></i><?php echo Yii::t('string', "Content List"); ?> </div>
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
