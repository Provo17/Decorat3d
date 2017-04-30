<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customer-form',
    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
    'enableClientValidation' => true,
        ));
?>
<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo Yii::t('string', 'Email Code'); ?>
        <span class="required">*</span>
        </label>
        <div class="col-md-9">
            <?php echo $form->textField($model, 'email_code', array('disabled'=>'true','maxlength'=>60,'class' => "form-control ", 'placeholder' => Yii::t('string', 'Enter  Your Email Code'))); ?>                   
            <?php echo $form->error($model, 'email_code'); ?>

        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo Yii::t('string', 'About'); ?>
        <span class="required">*</span>
        </label>
        <div class="col-md-9">
            <?php echo $form->textField($model, 'about', array('class' => "form-control ", 'placeholder' => Yii::t('string', 'Enter  About Content'))); ?>                   
            <?php echo $form->error($model, 'about'); ?>

        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo Yii::t('string', 'Subject'); ?>
        <span class="required">*</span>
        </label>
        <div class="col-md-9">
            <?php echo $form->textField($model, 'subject', array('class' => "form-control ", 'placeholder' => Yii::t('string', 'Enter Subject'))); ?>                   
            <?php echo $form->error($model, 'subject'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo Yii::t('string', 'Mail Body') ?>
        <span class="required">*</span>
        </label>
        <div class="col-md-9">
            <?php echo $form->textArea($model, 'body', array('class' => "wysihtml5 form-control", 'rows'=>10,'placeholder' => Yii::t('string', 'Write Mail Body Content Here ..'))); ?>                   
            <?php echo $form->error($model, 'body'); ?>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('emailNotification/index') ?>" class="btn <?php echo $this->cancel_button; ?>"><?php echo Yii::t('string', 'Cancel') ?></a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo $model->isNewRecord ? Yii::t('string', 'Create') : Yii::t('string', 'Update'); ?></button>
</div>
<?php $this->endWidget(); ?>
<!-- form -->

<?php
$script = <<< EOD
           $('.wysihtml5').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": false //Button to change color of font  
        });    
/* here you write your javascript normally in multiple lines */
EOD;

Yii::app()->clientScript->registerScript('someId', $script);
?>
