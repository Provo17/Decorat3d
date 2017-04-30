<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo strlen($jobDetails->description) > 57 ? substr($jobDetails->description, 0, 57) : $jobDetails->description; ?>..</h2>
    </div><!--col-md-12-->
</div><!--row-->
<?php
?>
<div class="ds-block-pro">
    <h3> <span></span> Total Bid: <?php echo isset($total_bids) ? $total_bids : '0'; ?> Bids
        <!--<span class="posted_on">3 Days Left</span>-->
    </h3>
    <div class="row">
        <div class="feture-grids">
            <div class="col-md-12">
                <div class="feture-grid">
                    <div class="pro-des" style="height:100%; overflow:hidden;">
                        <h4>Description</h4>
                        <p style="padding-bottom:20px;">
                            <?php echo isset($jobDetails->description) ? $jobDetails->description : '' ?>
                        </p>
                        By <a href="#"><?php echo $jobDetails->job_owner->username; ?></a>
                        <?php
                        if (isset($true_bid) && $true_bid != '') {
                            ?>
                            <a  class="btn btn-primary  btn-large bidButton" href="javascript:void(0);" style="background: #0066CC !important;">Completed</a>
                            <?php
                        } else if ($jobDetails->added_by != Yii::app()->user->id):
                            if ($userData->user_type_id == 2):
                                ?>
                                <a id="show_bid_form_btn" class="btn btn-primary  btn-large bidButton" href="#">Bid on This Project</a>
                                <?php
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--row-->
    <div id="bid_form" style="<?php
    if (isset($err) && $err == 'yes') {
        
    } else {
        ?>display: none;<?php } ?>"class="row">
        <div class="feture-grids">
            <div class="col-md-12">
                <div class="feture-grid">
                    <div class="pro-des" style="height:100%; overflow:hidden;">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'bid-form',
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            //'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price: </label>
                            <?php echo $form->textField($model, 'price', array('class' => 'form-control', 'placeholder' => 'Price')); ?>
                            <?php if (isset($price_err) && $price_err != ''): ?>
                                <div class="errorMessage"><?php echo $price_err; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Upload File: </label>
                            <?php echo $form->fileField($model, 'uploaded_file', array('class' => 'form-control', 'placeholder' => 'color')); ?>
                            <?php if (isset($uploaded_file_err) && $uploaded_file_err != ''): ?>
                                <div class="errorMessage"><?php echo $uploaded_file_err; ?></div>
                            <?php endif; ?>

                            <!--                                <ul class="img-preview">
                                                                <li><img src="images/img4.png"></li>
                                                                <li><img src="images/img5.png"></li>
                                                            </ul>-->
                        </div>
                        <button type="submit" id="sbid-form_submit_btn" class="btn btn-default buyButton">Submit</button>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--row-->
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <br/>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?php
    if ($jobDetails->added_by == Yii::app()->user->id):
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="status-box">
                    <ul class="nav nav-tabs" role="tablist">
                        <h3 class="pull-left">BIDDING (<?php echo isset($total_bids) ? $total_bids : ''; ?>)</h3>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">
                            <div class="table-responsive">
                                <table width="100%" border="0" class="table table-striped" style="margin-bottom:0px;">

                                    <?php
                                    if (isset($bids) && count($bids)) {
                                        ?>
                                        <tr>
                                            <th align="left" valign="top"><strong>Designer</strong></th>
                                            <th align="left" valign="top"><strong>Date</strong></th>
                                            <th align="left" valign="top" width="50"><strong>Price</strong></th>
                                            <th align="left" valign="top" width="70">&nbsp;</th>
                                        </tr>
                                        <?php
                                        foreach ($bids as $b_index => $bid) {
                                            ?>
                                            <tr>
                                                <td align="left" valign="top"><img src="<?php
                                                    if ($bid->designer->profile_image != '') {
                                                        echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $bid->designer->profile_image;
                                                    } else {
                                                        echo Assets::themeUrl("images/avatarImage.jpg");
                                                    }
                                                    ?>" width="50"> <a href="#" class="view-link"><?php echo count($bid->designer) ? $bid->designer->username : ''; ?></a></td>
                                                <td align="left" valign="top"><?php echo date_format(date_create($bid->created_at), 'jS F Y'); ?></td>
                                                <td align="left" valign="top" width="70">$ <?php echo $bid->price; ?></td>
                                                <td align="left" valign="top" width="120">
                                                   <!-- <a href="#" data-bid_id="<?php echo $bid->id; ?>" data-toggle="modal" data-target="#largeModal" class="btn btn-primary buyButton button12 view-design">View Design</a>-->
                                                    <div class="dropdown plustop">
                                                        <button class="btn btn-primary dropdown-toggle togglePlusButton" type="button" data-toggle="dropdown">
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu menu2">
                                                            <li><a href="javascript:void(0);" data-bid_id="<?php echo $bid->id; ?>" data-toggle="modal" data-target="#largeModal" class="view-design">View Design</a></li>
                                                            <li><a href="javascript:void(0);" data-receiver_id="<?php echo $bid->designer->id; ?>" data-track_id="<?php echo $jobDetails->id; ?>" data-type="designer_bid" class="initiate-chat"><i class="fa fa-wechat"></i> Chat</a></a></li>
                                                            <?php
                                                            if ($is_transaction != 'yes') {
                                                                ?>
                                                                <li><a href="<?php echo Yii::app()->createUrl('/bid/' . $bid->id . '/add') ?>?src=designer-bid">Buy Now</a></li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <?php
                                                                if ($true_bid == $bid->id) {
                                                                    ?>
                                                                    <li><a href="javascript:void(0);" style="color:green !important;">Bought</a></li>
                                                                    <?php if ($bid->disputeThread == NULL): ?>
                                                                        <li><a href="javascript:void(0);" data-bid_id="<?php echo $true_bid; ?>" data-toggle="modal" onclick="dispute_modal(this, '<?php echo $true_bid; ?>')" style="color:red !important;" title="Clicking on this will make this project disputed.">Mark as dispute</a></li>
                                                                    <?php else: ?>
                                                                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('dispute/conversations', ['disputeThreadId' => $bid->disputeThread->id]); ?>" style="color:red !important;">Marked as dispute</a></li>
                                                                    <?php endif; ?>
                                                                    <!--<li><a href="javascript:void(0);"  id="release_payment_btn" style="color:#0066CC !important;" title="If you click on this payment will be released from admin to the designer.">Release Payment </a></li>-->
                                                                    <?php
                                                                    $is_notified = EmployerBoughtDesigns::model()->findByAttributes(['transaction_report_id' => $true_bid_transaction_id]);

                                                                    if ($is_notified->payment_notification == '0') {
                                                                        ?>
                                                                        <li><a href="javascript:void(0);" data-true_bid_transaction_id="<?php echo $true_bid_transaction_id; ?>" id="release_payment_btn" style="color:#0066CC !important;" title="If you click on this payment will be released from admin to the designer.">Release Payment </a></li>
                                                                        <?php
                                                                    } else {
                                                                        $payment_curr_status = '';
                                                                        if ($is_notified->payment_notification == '1' || $is_notified->payment_notification == '2') {
                                                                            $payment_curr_status = 'Notified Admin';
                                                                        } elseif ($is_notified->payment_notification == '3') {
                                                                            $payment_curr_status = 'Payment Released';
                                                                        }
                                                                        ?>
                                                                        <li><a href="javascript:void(0);"  style="color:#0066CC !important;"><?php echo $payment_curr_status; ?> </a></li>
                                                                    <?php } ?>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <li><a href="javascript:void(0);" style="color:red !important;">Rejected</a></li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td align="center" valign="top" colspan="4"><strong>No Bidding Yet</strong></td>
                                        </tr>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                        </div> <!--manufacturert-ds-->
                        <!--employer-ds-->
                    </div><!-- tab-content-->
                </div>  <!--status-box-->
            </div><!--col-md-12-->
        </div><!--row-->
    <?php endif; ?>
</div>
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg design-modal">
        <div class="modal-content">
            <button type="button" class="close btnClose" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-body">
                <center><img style="display:none;height: 50px;width: 50px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" /></center>
                <div class="bigImagew"><img id="design_img" src="" /> </div>
                <div class="bigImagew" id="append3dDesign"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default buyButton button12" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="reportDisputeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg design-modal">
        <div class="modal-content">
            <button type="button" class="close btnClose" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-header">
                <center><h4 class="modal-title">Mark as Dispute</h4></center>
            </div>
            <div class="modal-body">
                skjfhsdkjfhsdkf
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default buyButton button12" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>-->
<?php
if ($jobDetails->added_by != Yii::app()->user->id):
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="status-box">
                <ul class="nav nav-tabs" role="tablist">
                    <h3 class="pull-left">BIDDING (<?php echo isset($total_bids) ? $total_bids : ''; ?>)</h3>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">
                        <div class="table-responsive">
                            <table width="100%" border="0" class="table table-striped" style="margin-bottom:0px;">
                                <?php
                                if (isset($bids) && count($bids)) {
                                    ?>
                                    <tr>
                                        <th align="left" valign="top"><strong>Designer</strong></th>
                                        <th align="left" valign="top"><strong>Date</strong></th>
                                        <th align="left" valign="top" width="50"><strong>Price</strong></th>
                                        <th align="left" valign="top" width="70">&nbsp;</th>
                                    </tr>
                                    <?php
                                    foreach ($bids as $b_index => $bid) {
                                        ?>
                                        <tr>
                                            <td align="left" valign="top"><img src="<?php
                                                if ($bid->designer->profile_image != '') {
                                                    echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $bid->designer->profile_image;
                                                } else {
                                                    echo Assets::themeUrl("images/avatarImage.jpg");
                                                }
                                                ?>" width="50"><a href="#" class="view-link"><?php echo count($bid->designer) ? $bid->designer->username : ''; ?></a></td>
                                            <td align="left" valign="top"><?php echo date_format(date_create($bid->created_at), 'jS F Y'); ?></td>
                                            <td align="left" valign="top" width="70">$ <?php echo $bid->price; ?></td>
                                            <td align="left" valign="top" width="120"></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td align="center" valign="top" colspan="4"><strong>No Bidding Yet</strong></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div> <!--manufacturert-ds-->
                    <!--employer-ds-->
                </div><!-- tab-content-->
            </div><!--status-box-->
        </div><!--col-md-12-->
    </div>
<?php endif; ?>
<a id="chatHeart" href="<?php echo Yii::app()->createUrl('/chat/chatHeart'); ?>"></a>
<a id="conversation" href="<?php echo Yii::app()->createUrl('/chat/conversation'); ?>"></a>
<a id="dataJson" href="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/data.json"); ?>"></a>
<!--
CSS and Javascript library definitions.
-->
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap.min.css"); ?>">
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap-theme.min.css"); ?>">
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/style.css"); ?>">
<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.console.js"); ?>"></script>

<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/object_viewer.js"); ?>"></script>
<script>
    $("#show_bid_form_btn").click(function(e) {
        e.preventDefault();
        $("#bid_form").toggle("slow", function() {
            // Animation complete.
        });
    });
    $(document).on('click', '.view-design', function(e) {
        var _this = $(this);
        $('.loader').show();
        $('#design_img').attr('src', '');
        var bid_id = _this.closest('.view-design').data('bid_id');
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('/bothDashboard/showBidImage'); ?>" + '?b_id=' + bid_id,
            success: function(data) {
                $('.loader').hide();
                if (data.type == 'success') {
//                    append3dDesign
                    if (data.img_type == '3d') {
                        $('#append3dDesign').html(data.content);
                        viewer3d('cv');
                    } else {
                        $('#design_img').attr('src', data.img_src);
                    }
                }
            }
        });

    });

    $(document).on('click', '.initiate-chat', function(e) {
        var _this = $(this);
        $('.loader').show();
        var receiver_id = _this.closest('.initiate-chat').data('receiver_id');
        var track_id = _this.closest('.initiate-chat').data('track_id');
        var type = _this.closest('.initiate-chat').data('type');
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: {receiver_id: receiver_id, track_id: track_id, type: type},
            dataType: "json",
            url: $('#chatHeart').attr('href'),
            success: function(data) {
                $('.loader').hide();
                if (data.type == 'success') {
                    window.location.href = $('#conversation').attr('href') + '?cid=' + data.chat_master_id;
                }
            }
        });
    });

    //    $(document).on('click', '#bid-form_submit_btn', function(e) {
    //        e.preventDefault();
//        alert('asd');
//        $('#bid_form').show();
//        var _this = $(this);
//        $('.errorMessage').html('');
//        $('.errorMessage').hide('');
//        $('.loader').show();
//        jQuery.ajax({
//            type: 'POST',
//            cache: false,
//            data: $('#bid-form').serialize(),
//            dataType: "json",
//            url: "<?php echo Yii::app()->createUrl('bothDashBoard/postBid', ['id' => $jobDetails->id]); ?>" ,
//            success: function(data) {
//                $('.loader').hide();
//                if (resp.type == 'success') {
////                    window.location.href
//                } else {
//                    if (typeof (data.msg) !== 'undefined') {
//                        $('#price_err').show();
//                        $('#price_err').html(data.msg.price);
//                    }
//                    if (typeof (data.msg) !== 'undefined') {
//                        $('#uploaded_file_err').show();
//                        $('#uploaded_file_err').html(data.msg.uploaded_file);
//                    }
//                }
//            }
//        });
//    });

    $(document).on('click', '#release_payment_btn', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('transaction/notifyReleasePayment', ['id' => $true_bid_transaction_id]); ?>",
            success: function(data) {
                if (data.type == 'success') {
                    window.location.href = '';
                }
                if (data.type == 'error') {
                    $('.append_area').html(data.msg);
                }
            }
        });
    });


    function dispute_modal(obj, id) {
        $("#reportDisputeModal").modal('show');
        $("#reportDisputeModal").find(".modal-body input[name='bidding_id']").val(id);
        $("#reportDisputeModal").find(".modal-body textArea[name='reason']").val('');
        $("#reportDisputeModal").find(".modal-body .errorMessage").text('').hide('fast');
    }

    $(document).ready(function() {
        $("form#disputeForm").submit(function(event) {
            event.preventDefault();
            if ($("#reportDisputeModal").find(".modal-body textArea[name='reason']").val() == "") {
                $("#reportDisputeModal").find(".modal-body .errorMessage").text('You must give a reason').show('slow');
            } else {
                $("#reportDisputeModal").find(".modal-body .errorMessage").text('').hide('fast');
                $.ajax({
                    url: '<?php echo Yii::app()->createAbsoluteUrl('dispute/reportDispute', ['type' => "1", 'disputeFrom' => "1"]); ?>',
                    data: $("form#disputeForm").serialize(),
                    dataType: 'json',
                    type: 'POST',
                    success: function(result) {
                        if (result.msg == 'success') {
                            window.location.reload();
                        } else if (result.msg == 'error') {
                            var html = '<ul>';
                            if ($.isArray(result.reason)) {
                                $.each(result.reason, function() {
                                    html += '<li>' + this + '</li>';
                                });
                            } else {
                                html += '<li>' + result.reason + '</li>';
                            }
                            html += '</ul>';
                            $("#reportDisputeModal").find(".modal-body .errorMessage").html(html).show('slow');
                        }
                    }
                });
            }
        });
    });
</script>

<!-- /.modal -->
<div class="modal fade bs-modal-lg " id="reportDisputeModal" tabindex="-1" role="dialog" aria-labelledby="reportDisputeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modalPart">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btnClose" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Dispute Form</h4>
            </div>
            <form action="" method="POST" id="disputeForm">
                <div class="modal-body">
                    <input type="hidden" name="bidding_id">
                    <label for="reason">Why do you want to mark this as dispute? </label>
                    <textArea name="reason" placeholder="Write your reason here.." id="reason" class="form-control formTextArea" rows='5'></textArea>
                    <div class="errorMessage" style="display:none; margin-top:10px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style='margin-bottom: 0px;'> Close </button>
                    <button type="submit" class="btn btn-info" style="background-color:#0066cc; "> Report Dispute </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->