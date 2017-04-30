<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs = array(
    'Change Password' ,

);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i> Change Password
                </div>                
            </div>
            <div class="portlet-body form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= "form"],
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions'=> array('validateOnSubmit'=>true,)
                ));
                ?>
                <div class="form-body">     
                    <div class="form-group">
                        <label class="col-md-3 control-label">Current Password</label>
                        <div class="col-md-9">
                            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'value'=> '', 'maxlength' => 20, 'class' => 'form-control', 'placeholder' => "Current password")); ?>
                            <?php  echo $form->error($model, 'password'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">New Password</label>
                        <div class="col-md-9">
                            <?php echo $form->passwordField($model, 'pass', array('size' => 60, 'maxlength' => 20, 'class' => 'form-control', 'placeholder' => "New password")); ?>
                            <?php  echo $form->error($model, 'pass'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Retype Password</label>
                        <div class="col-md-9">
                            <?php echo $form->passwordField($model, 'repeat_password', array('size' => 60, 'maxlength' => 20, 'class' => 'form-control', 'placeholder' => "Retype Password")); ?>
                            <?php  echo $form->error($model, 'repeat_password'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                    <a href="<?php echo $this->createUrl('dashboard/') ?>" class="btn <?php echo $this->back_button; ?>">Cancel</a>
                    <!--<button type="button" class="btn default">Cancel</button>-->
                    <button type="submit" class="btn green">Save</button>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>