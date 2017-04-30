<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo Yii::t('string', "Bought Design Details"); ?></h2>
    </div><!--col-md-12-->
</div>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <br/>
    <div role="alert" class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div class="postDetail">
    <div class="postImage"><img src="<?php
        if ($image != '') {
            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/" . $image;
        } else {
            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
        }
        echo $uplpoaded_file;
        ?>"></div>
    <a href="javascript:void(0);" style="float: right;display: block;" id="print_btn"><i class="glyphicon glyphicon-print"></i> Print</a>
    <div class="desButton"><a class="applyNow pull-right accepted" href="javascript:void(0);">
            <?php echo $true_bid != '' ? 'Purchased' : 'Yet To Send To Manufacturer' ?>
        </a></div>
    <div class="clearfix"></div>
    <h2>Description</h2>
    <div class="postDetailsP">
        <p><?php echo isset($description) ? $description : ''; ?></p>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="status-box boxStatus">
            <ul role="tablist" class="nav nav-tabs">
                <h3 class="pull-left">BIDDING (
                    <?php echo(isset($manufacturer_jobBid)) ? count($manufacturer_jobBid) : '0' ?>
                    )</h3>
            </ul>
            <div class="tab-content">
                <div id="manufacturert-ds" class="tab-pane active" role="tabpanel">
                    <div class="table-responsive">
                        <table width="100%" border="0" style="margin-bottom:0px;" class="table table-striped rwd-table tablePluss">
                            <tbody>
                            <style>
                                .rwd-table tr th {
                                    text-align: left; 
                                }
                            </style>
                            <tr>
                                <th valign="top" align="left" ><strong>Manufacturer</strong></th>
                                <th valign="top" align="left"><strong>Date</strong></th>
                                <th width="50" valign="top" align="left"><strong>Price</strong></th>
                                <th width="70" valign="top" align="left">&nbsp;</th>
                                <th width="70" valign="top" align="left">&nbsp;</th>
                            </tr>
                            <?php
                            if (isset($manufacturer_jobBid)) {
                                foreach ($manufacturer_jobBid as $mJobBidkey => $job_bid) {
                                    ?>
                                    <tr>
                                        <td valign="top" align="left" data-th="Designer"><img width="50" src="<?php
                                            if ($job_bid->manufacturer->profile_image != '') {
                                                $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/usersImage/" . $job_bid->manufacturer->profile_image;
                                            } else {
                                                $uplpoaded_file = Assets::themeUrl("images/avatarImage.jpg");
                                            }
                                            echo $uplpoaded_file;
                                            ?>"> <a class="view-link" target="blank" href="<?php echo Yii::app()->createUrl('manufacturer-detail/' . $job_bid->manufacturer->id . '/' . str_replace(' ', '-', isset($job_bid->manufacturer->username) ? $job_bid->manufacturer->username : '')); ?>"><?php echo $job_bid->manufacturer->username; ?></a></td>
                                        <td valign="top" align="left" data-th="Date"><?php echo date_format(date_create($job_bid->created_at), 'jS F Y'); ?></td>
                                        <td width="70" valign="top" align="left" data-th="Price">$ <?php echo $job_bid->price; ?></td>
        <!--                                        <td width="20" valign="top" align="left">&nbsp;</td>
                                        <td width="120" valign="top" align="left">-->
                                        <?php
                                        if ($is_transaction != 'yes') {
                                            ?>
                                            <td width="20" valign="top" align="left">&nbsp;</td>
                                            <td width="100" valign="top" align="left">
                                                <a href="<?php echo Yii::app()->createUrl('/bid/' . $job_bid->id . '/add') ?>?src=manufacturer-bid&type=<?php echo $type; ?>" class="buyNow2 button">&nbsp;</span>Accept</a>
                                            </td>
                                            <td width="20" valign="top" align="left"><a href="javascript:void(0);" data-receiver_id="<?php echo $job_bid->manufacturer_id; ?>" data-track_id="<?php echo $job_bid->id; ?>" data-type="designer_bid" class="initiate-chat"><i class="fa fa-wechat"></i> Chat</a></td>

                                            <?php
                                        } else {
                                            ?>
                                            <?php
                                            if ($true_bid == $job_bid->id) {
                                                ?>
                                                <td width="20" valign="top" align="left"></td>
                                                <td width="120" valign="top" align="left">
                                <!--                                                    <a href="javascript:void(0);" class="buyNow2 button" style="width:106px !important;"><span class="glyphicon glyphicon-ok">&nbsp;</span>Accepted</a>                                                    
                                                                                </td>-->

                                                    <div class="dropdown plustop">
                                                        <button class="btn btn-primary dropdown-toggle togglePlusButton" type="button" data-toggle="dropdown">
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu menu2">                                                            
                                                            <li><a href="javascript:void(0);" style="color:green !important;"><i class="glyphicon glyphicon-ok">&nbsp;</i>Accepted</a></li>
                                                            <li><a href="javascript:void(0);" data-receiver_id="<?php echo $job_bid->manufacturer_id; ?>" data-track_id="<?php echo $job_bid->id; ?>" data-type="designer_bid" class="initiate-chat"><i class="fa fa-wechat"></i> Chat</a></li>
                                                            <?php
                                                            $is_notified = EmployerBoughtDesigns::model()->findByAttributes(['transaction_report_id' => $true_bid_transaction_id]);

                                                            if ($is_notified->payment_notification == '0') {
                                                                ?>
                                                                <li><a href="javascript:void(0);" data-true_bid_transaction_id="<?php echo $true_bid_transaction_id; ?>" id="release_payment_btn" style="color:#0066CC !important;" title="If you click on this payment will be released from admin to the manufacturer.">Release Payment </a></li>
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
                                                        </ul>
                                                    </div>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td width="20" valign="top" align="left">&nbsp;</td>
                                                <td width="120" valign="top" align="left">
                                                    <a href="javascript:void(0);" class="buyNow2 button" style="background: #FF0046 !important;width:106px!important;"><span class="glyphicon glyphicon-remove">&nbsp;</span>Rejected</a>
                                                </td>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <!--</td>-->
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!--manufacturert-ds-->
                <!--employer-ds-->
            </div><!-- tab-content-->
        </div>  <!--status-box--> 
    </div>
</div>
<a id="chatHeart" href="<?php echo Yii::app()->createUrl('/chat/chatHeart'); ?>"></a>
<a id="conversation" href="<?php echo Yii::app()->createUrl('/chat/conversation'); ?>"></a>
<script>
    $(document).on('click', '#print_btn', function(e) {
        e.preventDefault();
//                $("#print_btn").hide();
//                $(".loader").show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: {uploaded_file: "<?php echo $uplpoaded_file; ?>"},
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('bothDashboard/printWindow'); ?>",
            success: function(data) {
//                        $("#print_btn").show();
//                       s $(".loader").hide();
                if (data.type == 'success') {
                    w = window.open();
                    w.document.write(data.content);
                    w.print();
                    w.close();
                }
                if (data.type == 'error') {
                    $('.append_area').html(data.msg);
                }
            }
        });
    });

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
</script>
