<?php
$this->breadcrumbs = array(
    Yii::t('string','Employer / Designer') => array('index'),
    Yii::t('string','Details'),
);
?>

<!--<h1>View User #<?php // echo $model->id;        ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    <?php echo Yii::t('string', "View"); ?> <!-Details User #<?php //echo $model->id;        ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal">
                    <div class="form-body">
                        <?php //echo $form->errorSummary($model);   ?>
                        <!--<h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));?></h3>-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "User Name"); ?>:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->username; ?></p>                   

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Email"); ?>:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->email; ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b><?php echo Yii::t('string', "Zipcode"); ?>:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->zip ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <h3 class="form-section">Address</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php // echo $model->address; ?></p>                    

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Phone</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php // echo $model->phone; ?> </p>                  

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pin</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php // echo $model->pin; ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!--<h3 class="form-section">Experience</h3>-->
<!--                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Created At</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php // echo date($model->created_at); ?></p>                    

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Admin Approval</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">                        
                                            <p class="form-control-static"><?php // echo $model->admin_approved == 1 ? '<span style=\'color:#35aa47\'>Approved</span>' : '<span id=\'approval\' onclick=approval(' . $model->id . ');><span style=\'color:red;cursor:pointer;\'>Pending</span>'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
<!--                        <h3 class="form-section">Payment Options</h3>
                           <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Discount %</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php // echo date($model->discount); ?></p>                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payment Grace Period</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">                        
                                            <p class="form-control-static"><?php // echo $model->time_period; ?> Days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $this->createUrl('both/index') ?>" class="btn <?php echo $this->back_button; ?>"><?php echo Yii::t('string', "Back"); ?></a>
                        <a href="<?php echo $this->createUrl('both/update/id/' . $model->id) ?>" class="btn <?php echo $this->update_button; ?>"><?php echo Yii::t('string', "Update"); ?></a>                       
                    </div>
                </form>
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