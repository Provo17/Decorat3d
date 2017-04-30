<?php
$this->breadcrumbs = array(
   Yii::t('string','Disputes') => array('index'),
    Yii::t('string','Reviews'),
);
?>

<!--<h1>View User #<?php // echo $model->id;                  ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    <?php echo Yii::t('string', "View"); ?> <!-Details Disputes #<?php //echo $model->id;                  ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'disputes-form',
                    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form'],
                    'enableClientValidation' => true,
                ));
                ?>
                <div class="form-body">
                    <h3 class="form-section"><?php echo Yii::t('string', "Reviews"); ?></h3>
                    <?php foreach($models as $model):?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo isset($model->user)?$model->user->username:""; ?>:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->message; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-actions right">
                    <a href="<?php echo $this->createUrl('dispute/index') ?>" class="btn <?php echo $this->back_button; ?>"><?php echo Yii::t('string', "Back"); ?></a>
                    <a href="<?php echo $this->createUrl('dispute/update/id/' . $model->disputeThread->id) ?>" class="btn <?php echo $this->update_button; ?>"><?php echo Yii::t('string', "Update"); ?></a>                       
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>