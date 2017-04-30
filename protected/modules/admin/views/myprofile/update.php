<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs = array(
    'My Profile' ,

);
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i> My Profile
                </div>                
            </div>
            <div class="portlet-body form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'admin-user-form',
                    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= "form"],
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name</label>
                        <div class="col-md-9">
                            <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => "First Name")); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Email</label>
                        <div class="col-md-9">
                            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 254, 'class' => 'form-control', 'placeholder' => "Email")); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>  

                </div>
                <div class="form-actions right">
                    <a href="<?php echo $this->createUrl('dashboard/') ?>" class="btn <?php echo $this->back_button; ?>">Cancel</a>
                    <!--<button type="button" class="btn default">Cancel</button>-->
                    <button type="submit" class="btn green">Update</button>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>