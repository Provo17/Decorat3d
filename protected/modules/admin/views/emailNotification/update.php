<?php
/* @var $this ManageProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    Yii::t('string', 'Email Notification') => array('index'),
    Yii::t('string', 'Update'),
);
?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <div class="note note-success">
            <p>
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </p>
        </div>
    </div>
<?php elseif (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-danger">
        <div class="note note-danger">
            <p>
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </p>
        </div>
    </div>

<?php endif; ?>
<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-ellipsis-h"></i><?php echo Yii::t('string', "Email Notification Update Form"); ?>
        </div>       
    </div>
    <div class="portlet-body form">
        <?php
        echo $this->renderPartial('_form', array(
            'model' => $model
        ));
        ?>    
    </div>
</div>
<!-- END SAMPLE FORM PORTLET-->