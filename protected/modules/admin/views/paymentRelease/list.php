<?php
$this->breadcrumbs = array(
    'Payment Release'
);
?><div>
    <h1 style="display: inline">Manage Payment </h1>
    <?php if (Yii::app()->user->hasFlash('success-msg')): ?>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success-msg'); ?>
        </div>
    <?php endif; ?>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box <?php echo $this->portlet_color ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bars"></i> Payment Notification List 
                </div>
            </div>
            <div class="portlet-body">
                <!----------->
                <div class="table-container">
                    <?php $widget->run(); ?>
                </div>
                <!----------->
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>