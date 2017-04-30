<?php
/* @var $this CmsController */
/* @var $model Cms */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'static-page-form',
            'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form'],
	'enableAjaxValidation'=>false,
)); ?>
<div class="form-body">
    <?php //echo $form->errorSummary($model); ?>
            
    <div class="form-group">
              <?php echo $form->labelEx($model, 'name', array('class' => "col-md-3 control-label")); ?>
            <div class="col-md-9">
                                    <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class' => 'form-control','disabled'=>'true','id'=>'{full_name}')); ?>                    
            </div>
        </div>

    <div class="form-group">
              <?php echo $form->labelEx($model, 'email', array('class' => "col-md-3 control-label")); ?>
            <div class="col-md-9">
                                    <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'disabled'=>'true','class' => 'form-control','id'=>'{email}')); ?>                    
            </div>
        </div>
                 <div class="form-group">
               <?php echo $form->labelEx($model, 'phone', array('class' => "col-md-3 control-label")); ?>
            <div class="col-md-9">
                                 <?php echo $form->textField($model,'phone',array('class' => 'form-control', 'disabled'=>'true','id'=>'contact_number')); ?>                    
            </div>
        </div>
        <div class="form-group">
               <?php echo $form->labelEx($model, 'message', array('class' => "col-md-3 control-label")); ?>
            <div class="col-md-9">
                <?php echo $model->message;?>             
            </div>
        </div>
        <?php if($model->status !='40'):?>
                <div class="form-group">
                        <?php echo $form->labelEx($model, 'reply', array('class' => "col-md-3 control-label")); ?>
                     <div class="col-md-9">
                                          <?php echo $form->textArea($model,'reply',array('cols'=>'10','rows'=>'10','class' => 'form-control', 'id'=>'reply', 'placeholder'=>'write your reply here.')); ?>                    
                         <?php echo $form->error($model, 'reply'); ?>
                     </div>
                 </div>
        <?php else:?>
        <div class="form-group">
               <?php echo $form->labelEx($model, 'reply', array('class' => "col-md-3 control-label")); ?>
            <div class="col-md-9">
                <?php echo $model->reply;?>             
            </div>
        </div>
        <?php endif;?>
        </div>
<div class="form-actions right1">
    <a href="<?php echo $this->createUrl('contact/') ?>" class="btn <?php echo $this->cancel_button; ?>">Cancel</a>
    <?php if($model->status !='40'):?><button type="submit" class="btn green">Reply</button><?php endif;?>
    
</div>
<?php $this->endWidget(); ?>
<!-- form -->