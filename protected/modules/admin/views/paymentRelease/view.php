<?php
$this->breadcrumbs = array(
    Yii::t('string','Payment Release') => array('index'),
    Yii::t('string','Details'),
);
?>

<!--<h1>View User #<?php // echo $model->id;                                    ?></h1>-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
        <div role="alert" class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>
<?php if ($employerBD->payment_notification != '3'): ?>
    <div class="row" id="before_payemnt_released_section">
        <div class="col-md-12">
            <div class="note note-info">
                <p><?php echo Yii::t('string', "If You click on the"); ?> <b><?php echo Yii::t('string', "Release Payment"); ?> </b> <?php echo Yii::t('string', "button ,payment will go to the respective payee"); ?> . &nbsp;
                    <a href="<?php echo Yii::app()->createUrl('admin/paymentRelease/doReleasePayment',['id'=> $employerBD->id]); ?>"type="button" id="payment_release_btn" class="btn green-meadow btn-lg"><?php echo Yii::t('string', "Release Payment"); ?></a>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($employerBD->payment_notification == '3'): ?>
    <div class="row" id="before_payemnt_released_section">
        <div class="col-md-12">
            <div class="note note-info">
                <p><?php echo Yii::t('string', "Payment made to the user successfully."); ?> &nbsp;                    
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row" id="after_payemnt_released_section" style="display:none;">
    <div class="col-md-12">
        <div class="note note-success">
            <p>Payment Released Successfully to payee.
            </p>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="portlet box <?php echo $this->portlet_color; ?>">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-eye"></i>
                    View <!-Details User #<?php //echo $model->id;                                    ?>-->
                </div>                
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal">
                    <div class="form-body">
                        <h3 class="form-section"><?php echo $all_doc['Buy_type']; ?></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Transaction ID:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $all_doc['transaction_id']; ?></p>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b> Token:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">$ <?php echo $all_doc['token']; ?></p>     
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Payment Status:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static" id="payment_release_status"><?php echo $all_doc['payment_release_status']; ?></p>                    

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Done At:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $all_doc['payment_made_at']; ?></p>                    

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b> Through:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo $all_doc['payment_through']; ?></p>     
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b> Payment Amount:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"><?php echo sprintf("%01.2f", $all_doc['payment_amount']); ?></p> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">Transaction Between</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Made By:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo $all_doc['payment_made_by']; ?>
                                        </p>     
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Made To:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo $all_doc['payment_made_to']; ?>
                                        </p>     
                                    </div>
                                </div>
                            </div>  
                        </div>

                        <h3 class="form-section">Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Description:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo $all_doc['description']; ?></p>                    
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><b>Design:</b></label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> 
                                            <img src="<?php echo Yii::app()->getBaseUrl(true) . '/upload/' . $all_doc['purchased_img']; ?>" width="660" height="371"/>
                                        </p>                    
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $this->createUrl('paymentRelease/') ?>" class="btn <?php echo $this->back_button; ?> " data-paypal-button="true">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--<script type="text/javascript">
    $("#payment_release_btn").on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->createUrl('admin/paymentRelease/doReleasePayment',['id'=> $employerBD->id]); ?>",
            dataType: 'json',
            success: function(resp) {
                if (resp.type == 'success') {
                    $('#before_payemnt_released_section').remove();
                    $('#after_payemnt_released_section').show();
                    $('#payment_release_status').html('Payment released');
                }
            }
        });
    });
</script>-->