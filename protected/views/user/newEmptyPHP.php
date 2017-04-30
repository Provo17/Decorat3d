<!--<div  class="col-md-9  col-sm-8 col-xs-12">

    <div class="row">
        <div class="col-md-12">
            <h2 class="top-title"> Post Project</h2>
        </div>col-md-12
    </div>row
    <div class="signup-wrap post-form">
        <div class="row">
            <div class="col-md-12">
                <div class="registration-form">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sign-up-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data',
                        ),
                        'clientOptions' => array('validateOnSubmit' => true,)
                    ));
                    ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Description: </label>

                                    <?php echo $form->textarea($model, 'description', array('class' => 'form-control', 'placehoder' => 'Description')); ?>
                                    <?php echo $form->error($model, 'description'); ?>
                                    <p>200 Words</p>
                                </div> 
                                <div class="form-group">
                                    <label>Dimention: </label>
                                    <select id="basic" class="selectpicker form-control">
                                        <option value="-">Select One</option>
                                        <option class="size1" >Size1</option>
                                    </select>
                                    <?php
                                    echo $form->dropDownList($model, 'dimention',  array('placeholder' => '', 'prompt' => 'Select Dimention'));
                                    echo $form->error($model, 'dimention');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Colour: </label>
                                    <input type="text" class="form-control" placeholder="color">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Upload File: </label>
                                    <input type="file" id="exampleInputFile">
                                    <ul class="img-preview">
                                        <li><img src="<?php echo Assets::themeUrl("images/img4.png"); ?>"></li>
                                        <li><img src="<?php echo Assets::themeUrl("images/img5.png"); ?>"></li>
                                    </ul>
                                </div>
                                <div class="form-group form-field">
                                    <button type="submit" class="btn btn-default reg-btn">Submit</button>
                                    <a href="#">Cancel</a>
                                </div>   

                            </div>
                        </div>


                    </form>
                    <?php $this->endWidget(); ?>
                </div>    
            </div>
        </div>        




    </div>col-md-9

    <div class="clearfix"></div>
</div> dash-in-->