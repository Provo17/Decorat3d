<link rel="stylesheet" type="text/css" href="<?php echo Assets::themeUrl("vendor/bootstrap-fileinput/bootstrap-fileinput.css"); ?>"/>

<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo Yii::t('string', "Post Project"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="signup-wrap post-form">
    <div class="row">
        <div class="col-md-12">
            <div class="registration-form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'post-project-Form',
//                    'action' => $this->createAbsoluteUrl('user/DoResetPassword'),
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                ));
                ?> 
                <!--<form method="post">-->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Description: </label>
                            <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'placeholder' => 'Write project description here..')); ?>
                            <?php echo $form->error($model, 'description'); ?>
                            <p>200 Words</p>
                        </div> 
                        <div class="form-group">
                            <label>Dimention: </label>
                            <?php echo $form->textField($model, 'description', array('class' => 'form-control', 'placeholder' => 'Write dimension')); ?>
                            <?php echo $form->error($model, 'description'); ?>
<!--                            <select id="basic" class="selectpicker form-control">
                                <option value="-">Select One</option>
                                <option class="size1" >Size1</option>
                            </select>-->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Color: </label>
                            <input type="text" class="form-control" placeholder="color">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Upload File: </label>
                            <!--                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                            </div>
                                                            <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new">
                                                                        Select image </span>
                                                                    <span class="fileinput-exists">
                                                                        Change </span>
                                                                    <input type="file" name="...">
                                                                </span>
                                                                <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                                    Remove </a>
                                                            </div>
                                                        </div>-->


                            <div id="postDropbox">
                                <input id="selectimage_p" type="file" >
                            </div>
                            <ul id="og-grid_p" class="img-preview">
                                <li><img src="images/img4.png"></li>
                                <li><img src="images/img5.png"></li>
                            </ul>
                        </div>
                        <div class="form-group form-field">
                            <button type="submit" class="btn btn-default reg-btn">Submit</button>
                            <a href="#">Cancel</a>
                        </div>   
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <!--</form>-->
            </div>    
        </div>
    </div>     
</div><!--col-md-9-->
<script type="text/javascript" src="<?php echo Assets::themeUrl("vendor/filereader.js"); ?>"></script>
<script type="text/javascript" src="<?php echo Assets::themeUrl("vendor/profile-post-script.js"); ?>"></script>
