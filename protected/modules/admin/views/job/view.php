<?php
$this->breadcrumbs = array(
    'Job' => array('index'),
    'Details',
);
?>

<!--<h1>View User #<?php // echo $model->id;             ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    View <!-Details User #<?php //echo $model->id;             ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal">
                    <div class="form-body">
                        <?php //echo $form->errorSummary($model);   ?>
                        <!--<h3 class="form-section">User Type <?php //echo CHtml::activeDropdownList($model, 'role_id', CHtml::listData(Roles::model()->findAll(), 'id', 'role'), array('disabled' => !$model->isNewRecord ? 'disabled' : ''));     ?></h3>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Added By</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->job_owner->username; ?></p>                   

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Description</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->description; ?></p>                   

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Dimension</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">
                                            <?php echo count($model->dimention) ? $model->dimention : '' ?>
                                            <?php // echo count($model->dimention_master->dimention) ? $model->dimention_master->dimention : '' ?>
                                        </p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Color</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->colour; ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b></b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">
                                            <img src="<?php
                                            if ($model->uploaded_file != '')
                                                {
                                                $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $model->uploaded_file;
                                                }
                                            else
                                                {
                                                $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                                }
                                            echo $uplpoaded_file;
                                            ?>" height="100px" width="100px"/>
                                        </p>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $this->createUrl('job/') ?>" class="btn <?php echo $this->back_button; ?>">Back</a>
                        <a href="<?php echo $this->createUrl('job/update/id/' . $model->id) ?>" class="btn <?php echo $this->update_button; ?>">Update</a>                       
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