<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
    'enableClientValidation' => true,
        ));
?>
<div class="form-body">
    <?php //echo $form->errorSummary($model);  ?>
    <!--    <h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));
    ?> </h3>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">User Name</label>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'username', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'username'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'password'); ?>
                    <span style="color:#555">Note: Leave blank for no changes</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Zip code</label>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'zip'); ?>                    
                </div>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Description</label>
                <div class="col-md-9">
                    <?php echo $form->textArea($model, 'description', array('rows'=>6,'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
    </div>  
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('manufacturer/index') ?>" class="btn <?php echo $this->cancel_button; ?>">Cancel</a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo $model->isNewRecord ? "Create" : "Update" ?></button>
</div>
<?php $this->endWidget(); ?>
<!-- form -->
