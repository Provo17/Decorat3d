<style>
    .errorMessage{
        color:red;
    }
</style>
<div class="what-we-do inner-wrap">
    <div class="container"> 
        <div class="row">    
            <h2 class="wow fadeInLeft delay-05s">Update Profile</h2>
            <h3 class="sub-head wow fadeInRight delay-05s animated">Please fill up the form to update your profile.</h3>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <br/>
                <div role="alert" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>  
            <div class="login-wrap">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'profile-Form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                ));
                ?> 
                <div class="form-group">
                    <label>First Name *</label>
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control input-lg', 'placeholder' => 'First Name')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>

                <div class="form-group">
                    <label>Country *</label>
                    <?php
                    $countryData = CHtml::listData(Country::model()->findAll(), 'id', 'countryName');
                    echo $form->dropDownList($model, 'country_id', $countryData, array('class' => 'form-control input-lg', 'prompt' => 'Select Country'));
                    ?>
                    <?php echo $form->error($model, 'country_id'); ?>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <?php echo $form->textField($model, 'city', array('class' => 'form-control input-lg', 'placeholder' => 'City')); ?>
                    <?php echo $form->error($model, 'city'); ?>           
                </div>
                <div class="form-group">
                    <label>Profile *</label>
                    <?php echo $form->fileField($model, 'profile_image', array('class' => 'form-control input-lg', 'placeholder' => 'Write Your Message Here..')); ?>
                    <?php echo $form->error($model, 'profile_image'); ?>
                </div>        
                <div class="form-group">
                    <button type="submit" class="btn signup-btn" data-color="info">Update</button>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div><!-- /.row -->
    </div>
</div>