<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> <?php echo Yii::t('string', "Manufacturer"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="row">
    <div class="col-md-12">
        <div class="ds-block-pro">
            <h3> <span></span> <?php echo Yii::t('string', "Submitted Bids"); ?></h3>
            <div class="row">
                <div class="feture-grids">
                    <?php
                    if (isset($bidData) && $bidData) {
                        foreach ($bidData as $b_index => $bid) {
                            if ($bid['img_type'] == 'stl') {
                                $org_file_name = explode(".", $bid['uplpoaded_file']);
                                $bid['uplpoaded_file'] = $org_file_name[0] . '.jpg';
                            }
                            ?>
                            <div class="col-md-4">
                                <div class="feture-grid" style="min-height:348px;">
                                    <!--<a href="#">-->
                                    <!--<a href="<?php // echo Yii::app()->createUrl('bothmanufacturerDashboard/jobDetails', ['id' => $bid->id]);          ?>">-->
                                    <a href="javascript:void(0);">
                                        <img alt="" class="img-responsive" src="<?php echo $bid['uplpoaded_file'] != '' ? $bid['uplpoaded_file'] : Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg"; ?>">
                                    </a>
                                    <div class="pro-des">
                                        <div class="price-tag">$<?php echo $bid['price']; ?></div>
                                        <p><?php echo strlen($bid['description']) > 57 ? substr($bid['description'], 0, 57) : $bid['description']; ?>..</p>
                                        <!--By <a href="#"><?php // echo $jobs->job_owner->username; ?></a>-->
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                </div> <!-- feture-grids-->
                <div align="center" id="centralErrorDiv">
                    <input type="hidden" name="offset" id="offset">
                    <input type="hidden" name="limit" id="limit">
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                </div>
                <!--<a class="show-more" href="/apps/decorate3d/public/blog"><i class="fa fa-eye"></i> <span>Show More</span></a>-->
                <!--<div align="center">  <a class="btn btn-bs1" href="#"><?php echo Yii::t('string', "Show More"); ?></a></div>-->
            </div><!--/row-->
        </div> <!--/ds-block-pro-->
    </div><!--col-md-12-->
</div><!--row-->

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

    function loadMore(offset, limit) {
        $(".loader").show('slow');
        $.ajax({
            async: false,
            url: "<?php echo Yii::app()->createAbsoluteUrl('manufacturerDashboard/loadMoreSubmittedBids'); ?>",
            type: "GET",
            dataType: "json",
            data: {offset: parseInt(offset) + parseInt(limit), limit: limit},
            success: function(result) {
                if (result.status == 'error') {
                    $("#centralErrorDiv").append('<div>' + result.msg + '</div>').css({color: red});
                    $(".loader").hide('slow');
                } else if (result.status == 'noMore') {
                    $(".loader").hide('slow', function() {
                        $("#centralErrorDiv").append('<div style="margin-top:25px;">' + result.msg + '</div>').css('color', "red").css('font-weight', "bold").show('slow');
                    });
                } else {
                    $.each(result.msg, function(index, item) {
                        var html = '<div class="col-md-4">'
                                + '<div class="feture-grid" style="min-height:348px;">'
                                + '<a href="javascript:void(0);">'
                                + '<img alt="" class="img-responsive" src="' + item.uplpoaded_file + '">'
                                + '</a>'
                                + '<div class="pro-des">'
                                + '<div class="price-tag">$' + item.price + '</div>'
                                + '<p>' + item.description + '..</p>'
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