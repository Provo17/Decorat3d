<?php
$this->breadcrumbs = array(
    'Transaction' => array('index'),
    'Details',
);
?>

<!--<h1>View User #<?php // echo $model->id;            ?></h1>-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    View <!-Details User #<?php //echo $model->id;            ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Transaction ID:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->transaction_id; ?></p>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Amount:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">$ <?php echo $model->amount; ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Employer:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->user->username; ?></p>                    

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Done At:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $model->created_at ;?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">Transaction Status</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Status:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php
                                            if ($model->status == 21)
                                                {
                                                echo "<span><font color='#4DB8DB'>Initiated</font></span>";
                                                }
                                            elseif ($model->status == 23)
                                                {
                                                echo "<span><font color='#35aa47'>Confirmed</font></span>";
                                                }
                                            elseif ($model->status == 22)
                                                {
                                                echo "<span><font color='red'>Pending</font><span>";
                                                }
                                            ?>
                                        </p>     
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        <h3 class="form-section">Project Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Designer:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo count($model->bid->designer) > 0 ? $model->bid->designer->username : '';?></p>                    
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Description:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo count($model->bid->job) > 0 ? $model->bid->job->description : '';?></p>                    
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $this->createUrl('transaction/index') ?>" class="btn <?php echo $this->back_button; ?>">Back</a>
                        <!--<a href="<?php // echo $this->createUrl('both/update/id/' . $model->id)     ?>" class="btn <?php // echo $this->update_button;     ?>">Update</a>-->                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--<script type="text/javascript">
    function approval(id) {
//        alert($('#' + id).attr('name'));
        $.ajax({
            type: 'POST',
            url: '<?php // echo Yii::app()->createUrl('admin/manageUser/AjaxAdminApprove');     ?>/id/' + id,
//            data: {'id': id},
            dataType: 'json',
            success: function(res) {
                $('#approval').html(res['res']);
            }
        });
    }
</script>-->