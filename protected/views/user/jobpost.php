

<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> Post Project</h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="signup-wrap post-form">
    <div class="row">
        <div class="col-md-12">
            <div class="registration-form">
                <?php if (Yii::app()->user->hasFlash('success')): ?>
                    <br/>
                    <div role="alert" class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php endif; ?>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'jobs-form',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    //'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Description: </label>
                            <?php echo $form->textarea($model, 'description', array('class' => 'form-control', 'placehoder' => 'Description')); ?>
                            <?php echo $form->error($model, 'description'); ?>
                            <p>200 Words</p>
                        </div> 
                        <div class="form-group">
                            <label>Dimension: </label>
                            <?php // echo $form->dropDownList($model, 'dimention', CHtml::listData(DimentionMaster::model()->findAll(), 'id', 'dimention'), array('empty' => 'Select One', 'class' => 'selectpicker form-control', 'id' => "basic")); ?>
                             <?php echo $form->textField($model, 'dimention',array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'dimention'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Color: </label>
                            <?php echo $form->textField($model, 'colour', array('class' => 'form-control', 'placeholder' => 'color')); ?>
                            <?php echo $form->error($model, 'colour'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Upload File: </label>
                            <?php echo $form->fileField($model, 'uploaded_file', array('class' => 'form-control', 'placeholder' => 'color')); ?>
                            <?php echo $form->error($model, 'uploaded_file'); ?>
                            <!--                                <ul class="img-preview">
                                                                    <li><img src="images/img4.png"></li>
                                                                <li><img src="images/img5.png"></li>
                                                            </ul>-->
                        </div>
                        <div class="form-group form-field">
                            <button type="submit" class="btn btn-default reg-btn">Submit</button>
                            <a href="#">Cancel</a>
                        </div>   

                    </div>
                </div>


                <?php $this->endWidget(); ?>
            </div>    
        </div>
    </div>        




</div><!--col-md-9-->

<div class="clearfix"></div>

<script src="<?php echo Assets::themeUrl("js/bootstrap-select.js"); ?>"></script>
<script>
    $(document).ready(function() {
        var mySelect = $('#first-disabled2');

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    });
</script>