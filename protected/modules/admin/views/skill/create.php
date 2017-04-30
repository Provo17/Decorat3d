<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Skill'=>array('index'),
	'Add',
);
?>

<!--<h1>Create User <?php echo $model->id; ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>Add Skill
                </div>                
            </div>
            <div class="portlet-body form">
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>      
            </div>
        </div>
    </div>
</div>