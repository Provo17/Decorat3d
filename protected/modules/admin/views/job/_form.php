<?php //
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
//    'action'=>Yii::app()->createAbsoluteUrl('admin/job/up'),
    'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
        ));
?>
<div class="form-body">
    <?php //echo $form->errorSummary($model);  ?>
    <!--    <h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));
    ?> </h3>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Description"); ?></label>
                <div class="col-md-9">
                    <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Dimension"); ?></label>
                <div class="col-md-9">
                    <?php 
//                    $dimensionData = CHtml::listData(DimentionMaster::model()->findAllByAttributes(['status'=>'1']),'id','dimention');
                    echo $form->textField($model, 'dimention', array('class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'dimention'); ?>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Color"); ?></label>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'colour', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'colour'); ?>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Upload File"); ?></label>
                <div class="col-md-9">
                    <?php echo $form->fileField($model, 'uploaded_file', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => '')); ?>                    
                    <?php echo $form->error($model, 'uploaded_file'); ?>
                </div>
            </div>
        </div>
    </div>    
</div>  
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('job/index') ?>" class="btn <?php echo $this->cancel_button; ?>"><?php echo Yii::t('string', "Cancel"); ?></a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo $model->isNewRecord ? Yii::t('string',"Create") : Yii::t('string',"Update") ?></button>
</div>
<?php $this->endWidget(); ?>
<!-- form -->
