<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'],
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
                <label class="col-md-3 control-label">Skill</label>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>
        </div>
    </div>    
</div>  
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('skill/index') ?>" class="btn <?php echo $this->cancel_button; ?>">Cancel</a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo $model->isNewRecord ? "Create" : "Update" ?></button>
</div>
<?php $this->endWidget(); ?>
<!-- form -->
