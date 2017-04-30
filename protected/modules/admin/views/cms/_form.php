<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cms-form',
    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form'],
    'enableAjaxValidation' => false,
        ));
?>
<div class="form-body">
    <?php //echo $form->errorSummary($model);  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_0" data-toggle="tab">
                            <?php echo Yii::t('string', "CMS"); ?> </a>
                    </li>
<!--                    <li>
                        <a href="#tab_1" data-toggle="tab">
                            Greek </a>
                    </li>-->

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">    
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Content"); ?></label>
                                <div class="col-md-9">
                                    <?php echo $form->textArea($model, 'content_en', array('rows' => 6, 'cols' => 50, 'class' => 'wysihtml5 form-control', 'id' => 'content_en', 'placeholder' => Yii::t('Content English'))); ?>                    
                                    <?php echo $form->error($model, 'content_en'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab_1">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo Yii::t('string', "Content In Denis"); ?></label>
                                <div class="col-md-9">
                                    <?php echo $form->textArea($model, 'content_gr', array('rows' => 6, 'cols' => 50, 'class' => 'wysihtml5 form-control', 'id' => 'content_gr', 'placeholder' => Yii::t('Content Greek'))); ?>                    
                                    <?php echo $form->error($model, 'content_gr'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="<?php echo $this->createUrl('Cms/') ?>" class="btn <?php echo $this->cancel_button; ?>"><?php echo Yii::t('string', "Cancel"); ?></a>
    <button type="submit" class="btn <?php echo $this->save_button; ?>"><?php echo $model->isNewRecord ? "Create" : "Save" ?></button>
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