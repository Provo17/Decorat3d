<?php
$this->breadcrumbs = array(
    Yii::t('string','Disputes') => array('index'),
    Yii::t('string','Details'),
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
                    <?php //echo $form->errorSummary($model);   ?>
                    <!--<h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));          ?></h3>-->
                    <h3 class="form-section"><?php echo Yii::t('string', "Disputes Details"); ?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Posted By"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo isset($model->jobBid, $model->jobBid->job, $model->jobBid->job->job_owner) ? $model->jobBid->job->job_owner->username : ""; ?></p>                   

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Reported By"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo isset($model->disputeFrom) ? $model->disputeFrom->username : ""; ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Type"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->type == "1" ? "Designer Bid" : "" ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Dispute From"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->showDisputeFromType(); ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Reason"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->reason ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b>trabea<?php echo Yii::t('string', "Created At"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo date("jS M, Y", strtotime($model->created_at)) ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Status"); ?>:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo ($model->status == "1") ? Yii::t('string',"Active") : Yii::t('string',"Inactive") ?></p> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions right">
                    <a href="<?php echo $this->createUrl('dispute/index') ?>" class="btn <?php echo $this->back_button; ?>"><?php echo Yii::t('string', "Back"); ?></a>
                    <a href="<?php echo $this->createUrl('dispute/update/id/' . $model->id) ?>" class="btn <?php echo $this->update_button; ?>"><?php echo Yii::t('string', "Update"); ?></a>                       
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>