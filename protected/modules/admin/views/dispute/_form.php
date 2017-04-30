<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'dispute-form',
    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form'],
    'enableClientValidation' => true,
        ));
?>
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Posted By"); ?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo isset($model->jobBid, $model->jobBid->job, $model->jobBid->job->job_owner) ? $model->jobBid->job->job_owner->username : ""; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Reported By"); ?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo isset($model->disputeFrom) ? $model->disputeFrom->username : ""; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Type:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo $model->type == "1" ? "Designer Bid" : "" ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Dispute From"); ?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo $model->showDisputeFromType(); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Reason"); ?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo $model->reason ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Created At"); ?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static"><?php echo date("jS M, Y", strtotime($model->created_at)) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Status"); ?>:</label>
                <div class="col-md-9">
                    <div class="radio-list">
                        <label class="radio-inline">
                            <input type="radio" name="DisputeThread[status]" id="optionsRadios25" value="1" <?php
                            if ($model->status == 1)
                                {
                                echo "checked";
                                }
                            ?>> <?php echo Yii::t('string', "Active"); ?> </label>
                        <label class="radio-inline">
                            <input type="radio" name="DisputeThread[status]" id="optionsRadios26" value="0" <?php
                            if ($model->status == 0)
                                {
                                echo "checked";
                                }
                            ?>> <?php echo Yii::t('string', "Inactive"); ?> </label>

                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('dispute/index') ?>" class="btn <?php echo $this->cancel_button; ?>"><?php echo Yii::t('string', "Cancel"); ?></a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo Yii::t('string', "Update"); ?></button>
</div>
<?php $this->endWidget(); ?>
<!-- form -->
