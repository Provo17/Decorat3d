<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

<script type="text/javascript">stLight.options({publisher: "e9ab2caa-15e9-419b-967a-ff4c2479ce90", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo Yii::t('string', "Design Details"); ?></h2>
    </div><!--col-md-12-->
</div>
<div class="postDetail">
    <div class="postImage"><img src="<?php
        if ($this->getFileExtention($designData->uploaded_file) == 'stl')
            {
            $org_file_name = explode(".", $designData->uploaded_file);
            echo $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
            }
        else
            {
            echo Yii::app()->baseUrl . '/upload/jobs/' . $designData->uploaded_file;
            }
        ?>"/></div>
        <?php
        if ($this->getFileExtention($designData->uploaded_file) == 'stl')
            {
            ?>
        <a href="javascript:void(0);" data-rawImage="<?php echo $designData->uploaded_file; ?>" style="float: right;display: block;" data-toggle="modal" data-target="#largeModal" id="3dview_btn"><i class="glyphicon glyphicon-eye-open"></i> View 3d Design</a>
    <?php } ?>
    <div class="desButton">
        <a style="margin-bottom: 20px;" class="applyNow pull-right accepted" href="javascript:void(0);">
            <?php echo $design_accepted; ?>
        </a>
        <?php if ($design_accepted == "Accepted"): ?>
            <?php if ($designData->disputeThread == NULL): ?>
                <a class="applyNow pull-right accepted" href="javascript:void(0);" data-bid_id="<?php echo $designData->id; ?>" data-toggle="modal" onclick="dispute_modal(this, '<?php echo $designData->id; ?>')" style="margin-bottom: 20px;background-color:red;" title="Clicking on this will make this project disputed.">Mark as dispute</a>
            <?php else: ?>
                <a class="applyNow pull-right accepted" href="<?php echo Yii::app()->createAbsoluteUrl('dispute/conversations', ['disputeThreadId' => $designData->disputeThread->id]); ?>" style="margin-bottom: 20px;background-color:red;">Marked as dispute</a>
            <?php endif; ?>
        <?php endif; ?>
        <p class="text-center" style="font-size:20px;font-weight: bold;">$<?php echo $designData->price; ?></p>
    </div>
    <div class="share-design" style="float:right; margin-left: 20px; margin-top: 100px;">
        <!--share section-->
        <span class="st_twitter_large" st_title="<?php echo count($designData->designer) ? $designData->designer->username : ''; ?> Design on Decorat3d.com"></span>
        <span class="st_facebook_large"  st_title="<?php echo count($designData->designer) ? $designData->designer->username : ''; ?> Design on Decorat3d.com"></span>
        <span class="st_googleplus_large"  st_title="<?php echo count($designData->designer) ? $designData->designer->username : ''; ?> Design on Decorat3d.com"></span>
        <!--<span class="st_sharethis_large"  st_title="<?php echo count($designData->designer) ? $designData->designer->username : ''; ?> Design on Decorat3d.com"></span>-->
        <!--end of share section-->
    </div>

    <div class="clearfix"></div>
    <h2>Description</h2>
    <div class="postDetailsP">
        <p>
            <?php echo count($designData->job->description) ? $designData->job->description : '' ?>
        </p>
    </div>
    <div class="clearfix"></div>
</div>

<!-- /.modal -->
<div class="modal fade bs-modal-lg " id="reportDisputeModal" tabindex="-1" role="dialog" aria-labelledby="reportDisputeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modalPart">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btnClose" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Reason</h4>
            </div>
            <form action="" method="POST" id="disputeForm">
                <div class="modal-body">
                    <input type="hidden" name="bidding_id">
                    <div>Why are you want to mark it as dispute?</div>
                    <label for="reason">Reason: </label><textArea name="reason" placeholder="Reason" id="reason" class="form-control"></textArea>
                        <div class="errorMessage" style="display: none;margin-top: 10px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default">Report Dispute</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
                                url: '<?php echo Yii::app()->createAbsoluteUrl('dispute/reportDispute', ['type' => "1", 'disputeFrom' => "2"]); ?>',
                                data: $("form#disputeForm").serialize(),
                                dataType: 'json',
                                type: 'POST',
                                success: function(result) {
                                    if (result.msg == 'success') {
                                        window.location.reload(true);
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
                $(document).on('click', '#3dview_btn', function(e) {
                    var _this = $(this);
                    $('.loader').show();
                    var bid_img = $('#3dview_btn').attr('data-rawImage');
                    jQuery.ajax({
                        type: 'POST',
                        cache: false,
                        dataType: "json",
                        url: "<?php echo Yii::app()->createUrl('/bothDashboard/show3dBidImage'); ?>" + '?rawImage=' + bid_img,
                        success: function(data) {
                            $('.loader').hide();
                            if (data.type == 'success') {
                                $('#append3dDesign').html(data.content);
                                viewer3d('cv');
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
                <div class="bigImagew" id="append3dDesign"> </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default buyButton button12" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>