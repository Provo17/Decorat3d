<?php
$this->breadcrumbs = array(
    'Manufacturer' => array('index'),
    'Details',
);
?>

<!--<h1>View User #<?php // echo $model->id;                 ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    View <!-Details User #<?php //echo $model->id;                 ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'htmlOptions' => ['class' => 'form-horizontal', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                    'enableClientValidation' => true,
                ));
                ?>
                <div class="form-body">
                    <?php //echo $form->errorSummary($model);   ?>
                    <!--<h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));         ?></h3>-->
                    <h3 class="form-section">Manufacturer Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b>User Name:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->username; ?></p>                   

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b>Email:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->email; ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><b>Zip code:</b></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?php echo $model->zip ?></p>                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="form-section">Action</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Choose Action</label>

                                <div class="col-md-3">                                        
                                    <div class="form-body" style="padding:0px;">
                                        <?php echo $form->dropDownList($model, 'status', [1 => 'Active', 2 => 'Inactive'], array('class' => 'form-control input-medium', 'placeholder' => '')); ?>                    
                                        <?php // echo $model->address; ?>                                            
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
                <div class="form-actions right">
                    <a href="<?php echo $this->createUrl('manufacturer/index') ?>" class="btn <?php echo $this->back_button; ?>">Back</a>
                    <a href="<?php echo $this->createUrl('manufacturer/update/id/' . $model->id) ?>" class="btn <?php echo $this->update_button; ?>">Update</a>                       
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function approval(id) {
//        alert($('#' + id).attr('name'));
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('admin/manageUser/AjaxAdminApprove'); ?>/id/' + id,
//            data: {'id': id},
            dataType: 'json',
            success: function(res) {
                $('#approval').html(res['res']);
            }
        });
    }
</script>