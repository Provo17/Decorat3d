<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> <?php echo Yii::t('string', "Purchased Manufacturer Catalogs"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div role="alert" class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="ds-block-pro">
            <!--<h3> <span></span> <?php // echo Yii::t('string', "Submitted Bids");   ?></h3>-->
            <div class="row">
                <div class="feture-grids">
                    <?php
                    if (isset($man_catalog_Data) && $man_catalog_Data) {
                        foreach ($man_catalog_Data as $man_catalog_Data_index => $man_catalog) {
                            if ($this->getFileExtention($man_catalog->maufacturerCatalog->uploaded_file) == 'stl') {
                                $org_file_name = explode(".", $man_catalog->maufacturerCatalog->uploaded_file);
                                $man_catalog->maufacturerCatalog->uploaded_file = $org_file_name[0] . '.jpg';
                            }
                            ?>
                            <div class="col-md-4">
                                <div class="feture-grid" style="min-height:348px;">
                                    <!--<a href="#">-->
                                    <!--<a href="<?php // echo Yii::app()->createUrl('bothmanufacturerDashboard/jobDetails', ['id' => $man_catalog->id]);                           ?>">-->
                                    <a href="javascript:void(0);"  data-empBoughtDesign_id="<?php echo $man_catalog->id; ?>" data-maufacturerCatalog_id="<?php echo $man_catalog->maufacturerCatalog->id; ?>" data-toggle="modal" data-target="#largeModal" class="view-design">
                                        <img alt="" class="img-responsive" src="<?php echo $man_catalog->maufacturerCatalog->uploaded_file != '' ? Yii::app()->request->getBaseUrl(true) . '/upload/manufacturer_catalog/' . $man_catalog->maufacturerCatalog->uploaded_file : Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg"; ?>">
                                    </a>
                                    <div class="pro-des">
                                        <div class="price-tag">$<?php echo $man_catalog->maufacturerCatalog->price; ?></div>
                                        <p><?php echo strlen($man_catalog->maufacturerCatalog->title) > 57 ? substr($man_catalog->maufacturerCatalog->title, 0, 57) : $man_catalog->maufacturerCatalog->title; ?>..</p>
                                        <!--By <a href="#"><?php // echo $jobs->job_owner->username; ?></a>-->
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
                <input type="hidden" name="offset" id="offset">
                <input type="hidden" name="limit" id="limit">
                <div align="center" id="centralErrorDiv">
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                </div>
            </div><!--/row-->
        </div> <!--/ds-block-pro-->
    </div><!--col-md-12-->
</div><!--row-->
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap.min.css"); ?>">
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap-theme.min.css"); ?>">
<link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/style.css"); ?>">
<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.console.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/object_viewer.js"); ?>"></script>
<script>
    $(document).on('click', '.view-design', function(e) {
        var _this = $(this);
        $('.payment-notification').hide();
        $('.loader').show();
        $('#design_img').attr('src', '');
        var maufacturerCatalog_id = _this.closest('.view-design').attr('data-maufacturerCatalog_id');
        var design_id = _this.closest('.view-design').attr('data-empBoughtDesign_id');
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('/bothDashboard/ShowPurchasedManufacturerCatalogs'); ?>" + '?b_id=' + maufacturerCatalog_id +'&d_id='+design_id,
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
                    if(data.payment_notification_status == '0'){
                        $('#releasePayment').show();
                    }else if(data.payment_notification_status == '1'){
                        $('#notifiedAdmin').show();
                    }else if(data.payment_notification_status == '3'){
                        $('#paymentReleased').show();
                    }
                }
            }
        });

    });
</script>
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg design-modal">
        <div class="modal-content">
            <button type="button" class="close btnClose" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-body">
                <center><img style="display:none;height: 50px;width: 50px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" /></center>
                <div class="bigImagew"><img id="design_img" src="" /> </div>
                <div class="bigImagew" id="append3dDesign"> </div>
                <center><a style="display:none;" class="btn btn-default payment-notification" data-empBoughtDesign_id="<?php echo $man_catalog->id; ?>" id="releasePayment" onclick="" ><?php echo Yii::t('string', "Release Payment"); ?></a></center>
                <center><a style="display:none;" class="btn btn-default payment-notification" id="notifiedAdmin"><?php echo Yii::t('string', "Notified To Admin"); ?></a></center>
                <center><a style="display:none;" class="btn btn-default payment-notification" id="paymentReleased"><?php echo Yii::t('string', "Payment Released"); ?></a></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default buyButton button12" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#offset').val(<?php echo $offset; ?>);
        $('#limit').val(<?php echo $limit; ?>);

        if ($(window).height() == $(document).height()) {
            loadMore($('#offset').val(), $('#limit').val());
        }
    });

    $(document).scroll(function() {
        if ($('#limit').val() == 0) {
            return;
        }
        if ($(window).height() + $(window).scrollTop() == $(document).height()) {
            loadMore($('#offset').val(), $('#limit').val());
        }
    });
    
    $(document).on('click', '#releasePayment', function(e) {
        var _this = $(this);
        $('.loader').show();
        $('#design_img').attr('src', '');
        var employerBoughtDesign_id = _this.attr('data-empBoughtDesign_id');
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('/bothDashboard/purchasedManufacturerCatalogPaymentRelease'); ?>" + '?d_id=' + employerBoughtDesign_id,
            success: function(data) {
                $('.loader').hide();
                if (data.type == 'success') {
                   window.location.href = '';
                }else{
                   window.location.href = ''; 
                }
            }
        });

    });
    
    function loadMore(offset, limit) {
        $(".loader").show('slow');
        $.ajax({
            async: false,
            url: "<?php echo Yii::app()->createAbsoluteUrl('bothDashboard/loadMorePurchasedMnaufacturerCatalogs'); ?>",
            type: "GET",
            dataType: "json",
            data: {offset: parseInt(offset) + parseInt(limit), limit: limit},
            success: function(result) {
                if (result.status == 'error') {
                    $("#centralErrorDiv").append('<div>' + result.msg + '</div>').css({color: red});
                    $(".loader").hide('slow');
                } else if (result.status == 'noMore') {
                    $(".loader").hide('slow', function() {
                        $("#centralErrorDiv").html('<div style="margin-top:25px;">' + result.msg + '</div>').css('color', "red").css('font-weight', "bold").show('slow');
                    });
                } else {
                    $.each(result.msg, function(index, item) {
                        var html = '<div class="col-md-4">'
                                + '<div class="feture-grid" style="min-height:348px;">'
                                + '<a href="javascript:void(0);" data-maufacturerCatalog_id="' + item.id + '" data-toggle="modal" data-target="#largeModal" class="view-design">'
                                + '<img alt="" class="img-responsive" src="' + item.image + '">'
                                + '</a>'
                                + '<div class="pro-des">'
                                + '<div class="price-tag">$' + item.price + '</div>'
                                + '<p>' + item.title + '..</p>'
                                + '</div>'
                                + '</div>'
                                + '</div>';
                        $('.feture-grids').append(html);
                    });
                    $(".loader").hide('slow');
                }
                $('#offset').val(result.offset);
                $('#limit').val(result.limit);
            }
        });
    }
</script>