<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> <?php echo Yii::t('string', "Manufacturer"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="row">
    <div class="col-md-12">
        <div class="ds-block-pro">
            <h3> <span></span> <?php echo Yii::t('string', "Print Design"); ?></h3>
            <div class="row">
                <div class="feture-grids">
                    <?php
                    if (isset($manufacturerBids) && $manufacturerBids != NULL) {
                        foreach ($manufacturerBids as $manufacturerBid) {
                            if ($manufacturerBid['img_type'] == 'stl') {
                                $org_file_name = explode(".", $manufacturerBid['image']);

                                $manufacturerBid['image'] = $org_file_name[0] . '.jpg';
                            }
                            ?>
                            <div class="col-md-6 child-listing">
                                <div class="feture-grid">
                                    <a href="javascript:void(0)" data-img_type="<?php echo $manufacturerBid['img_type']; ?>" data-img_src="<?php echo $manufacturerBid['image']; ?>" data-toggle="modal" data-target="#largeModal" class="view-design"><img alt="" class="img-responsive" src="<?php echo $manufacturerBid['image']; ?>"></a>
                                    <div class="pro-des">
                                        <div class="price-tag">$<?php echo $manufacturerBid['amount']; ?></div>
                                        <p> &nbsp;<?php echo strlen($manufacturerBid['description']) > 57 ? substr($manufacturerBid['description'], 0, 57) : $manufacturerBid['description']; ?>...</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="clearfix"></div>
                </div> <!-- feture-grids-->
                <input type='hidden' value='<?php echo $offset; ?>' name='offset' id='offset'>
                <input type='hidden' value='<?php echo $limit; ?>' name='limit' id='limit'>
                <div align="center" id="centralErrorDiv">
                    <!--<a class="btn btn-bs1" href="#" onClick='loadMoreManufacture()' id='loadMoreManufactureButton'><?php echo Yii::t('string', "Load More"); ?>...</a>-->                    
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                    <span id="centerDiv" style="display:none;"></span>
                </div>
            </div><!--/row-->
        </div> <!--/ds-block-pro-->

    </div><!--col-md-12-->
</div><!--row-->

<div class="row">
    <div class="col-md-12">
        <div class="status-box">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <h3 class="pull-left"> Status</h3>
                <li role="presentation" class="active"><a href="#manufacturert-ds" aria-controls="manufacturert-ds" role="tab" data-toggle="tab">Manufacturer</a></li>
                <li role="presentation" ><a href="#employer-ds" aria-controls="employer-ds" role="tab" data-toggle="tab">Employer</a></li>

            </ul>
            <!-- Nav tabs end -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">

                    <table width="100%" border="0" class="table table-bordered">
                        <tr>
                            <td align="center">Monthly / yearly  Revenue</td>
                            <td align="center">Work in Progress</td>
                            <td align="center">Hired Manufacturer</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">Yearly</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$1000.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">1 active milestone</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Lifetime</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </div> <!--manufacturert-ds-->


                <div role="tabpanel" class="tab-pane " id="employer-ds">

                    <table width="100%" border="0" class="table table-bordered">
                        <tr>
                            <td align="center">Monthly / yearly  Revenue</td>
                            <td align="center">Work in Progress</td>
                            <td align="center">Hired Manufacturer</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>300</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">Yearly</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$5000.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">1 active milestone</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Lifetime</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                </div><!--employer-ds-->
            </div><!-- tab-content-->

        </div>  <!--status-box-->

    </div><!--col-md-12-->
</div><!--row-->

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
    $(document).ready(function() {
        if ($(window).height() == $(document).height()) {
            loadMore($('#offset').val(), $('#limit').val());
        }
    });

    $(window).scroll(function() {
        var offset_val = $("#offset").val();
        var limit_val = $("#limit").val();
        if (limit_val == 0) {
            return;
        }

        if ($(window).height() + $(window).scrollTop() == $(document).height()) {
            loadMore(offset_val, limit_val);
        }
    });

    $(document).on('click', '.view-design', function(e) {
        var _this = $(this);
        $('.loader').show();
        $('#design_img').attr('src', '');
        var img_src = _this.closest('.view-design').data('img_src');
        var img_type = _this.closest('.view-design').data('img_type');
        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('/manufacturerDashboard/showBidImage'); ?>" + '?img_src=' + img_src + '&img_type=' + img_type,
            success: function(data) {
                $('.loader').hide();
                if (data.type == 'success') {
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

    function loadMore(offset, limit) {
        $(".loader").show('slow');
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl('user/manufactureDashboardLoadMore'); ?>",
            type: "GET",
            dataType: "json",
            data: {offset: parseInt(offset) + parseInt(limit), limit: limit},
            success: function(result) {
                var insertPos = $('.feture-grids .child-listing:last');
                if (result.status == 'error') {
                    $('#offset').val('0');
                    $('#limit').val('0');
                    $(".loader").hide('slow', function() {
                        $('#centralErrorDiv').append(result.msg).css({color: red});
                    });
                } else if (result.status == 'noMore') {
                    $('#offset').val(0);
                    $('#limit').val(0);
                    $(".loader").hide('slow', function() {
                        $("#centralErrorDiv").html(result.msg).css('color', "red").css('font-weight', "bold").show('slow');
                    });
                } else {
                    $.each(result.manufacturerBids, function() {
                        var html = '<div class="col-md-6 child-listing">'
                                + '<div class="feture-grid">'
                                + '<img alt="" class="img-responsive" src="' + this.image + '">'
                                + '<div class="pro-des">'
                                + '<div class="price-tag">$' + this.amount + '</div>'
                                + '<p>' + this.description + '</p>'
                                + '</div>'
                                + '</div>'
                                + '</div>';
                        insertPos.after(html);
                    });
                    $("#offset").val(result.offset);
                    $("#limit").val(result.limit);
                    $(".loader").hide('slow');
                }
            }
        });
    }
</script>



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
