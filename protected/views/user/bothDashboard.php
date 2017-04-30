<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo Yii::t('string', "Employer / Cad designer"); ?></h2>
    </div><!--col-md-12-->
</div><!--row-->
<span id='action_result'></span>
<div class="row">
    <div class="col-md-12">
        <div class="topr-up-box">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="tab_section active" data-active_section="1"><a href="#browse-ds" aria-controls="browse-ds" role="tab" data-toggle="tab">Browse designs</a></li>
                <li role="presentation" class="tab_section" data-active_section="2"><a href="#submit-ds" aria-controls="submit-ds" role="tab" data-toggle="tab">Submit Design</a></li>
                <li role="presentation" class="tab_section" data-active_section="3"><a href="#manufacturer" aria-controls="manufacturer" role="tab" data-toggle="tab">Design Send to Manufacturer</a></li>
            </ul>
            <!-- Nav tabs end -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="browse-ds">
                    <div class="ds-block-pro">
                        <h3> <span></span> Recent Post</h3>
                        <div class="row">
                            <div class="feture-grids">
                                <?php
                                if (isset($own_jobsData) && $own_jobsData) {
                                    foreach ($own_jobsData as $j_index => $jobs) {
                                        ?>
                                        <div class="col-md-4">
                                            <div class="feture-grid" style="min-height:348px;">
                                                <!--<a href="#">-->
                                                <a href="<?php echo Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $jobs->id]); ?>">
                                                    <img alt="" class="img-responsive" src="<?php
                                                    if ($jobs->uploaded_file != '') {
//                                                        $ext = $this->getFileExtention($jobs->uploaded_file)
                                                        if ($this->getFileExtention($jobs->uploaded_file) == 'stl') {
                                                            $org_file_name = explode(".", $jobs->uploaded_file);
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                                                        } else {
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $jobs->uploaded_file;
                                                        }
                                                    } else {
                                                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                                    }
                                                    echo $uplpoaded_file;
                                                    ?>">
                                                </a>
                                                <div class="pro-des">
                                                    <!--<div class="price-tag">$15</div>-->
                                                    <p><?php echo strlen($jobs->description) > 57 ? substr($jobs->description, 0, 57) : $jobs->description; ?>..</p>
                                                    By <a href="#"><?php echo $jobs->job_owner->username; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="append_area" id="selfPosted_projects_append_area"></div>
                                <div class="clearfix"></div>
                                <div align="center" class="centralErrorDiv">
                                    <input type="hidden" name="offset" class="offset">
                                    <input type="hidden" name="limit" class="limit">
                                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                                </div>
                            </div> <!-- feture-grids-->
                        </div><!--/row-->
                    </div> <!--/ds-block-pro-->
                </div><!--Browse designs-->
                <div role="tabpanel" class="tab-pane" id="submit-ds">
                    <div class="ds-block-pro">
                        <h3> <span></span> Recent Post</h3>
                        <div class="row">
                            <div class="feture-grids">
                                <?php
                                if (isset($submitted_design) && $submitted_design) {
                                    foreach ($submitted_design as $d_index => $design) {
                                        ?>
                                        <div class="col-md-4">
                                            <div class="feture-grid" style="min-height:348px;">
                                                <!--<a href="<?php // echo Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $design->jobs_id]);                            ?>">-->
                                                <a href="<?php echo Yii::app()->createUrl('bothDashboard/submittedDesignDetails', ['id' => $design->id]); ?>">
                                                    <img alt="" class="img-responsive" src="<?php
                                                    if ($design->job->uploaded_file != '') {
                                                        if ($this->getFileExtention($design->job->uploaded_file) == 'stl') {
                                                            $org_file_name = explode(".", $design->job->uploaded_file);
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                                                        } else {
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $design->job->uploaded_file;
                                                        }
                                                    } else {
                                                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                                    }
                                                    echo $uplpoaded_file;
                                                    ?>">
                                                </a>
                                                <div class="pro-des">
                                                    <div class="price-tag">$<?php echo $design->price; ?></div>
                                                    <p><?php echo strlen($design->job->description) > 57 ? substr($design->job->description, 0, 57) : $design->job->description; ?>..</p>
                                                    By <a href="#"><?php echo $userData->username; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="append_area" id="selfPosted_design_append_area"></div>
                                <div class="clearfix"></div>
                                <div align="center" class="centralErrorDiv">
                                    <input type="hidden" name="offset" class="offset">
                                    <input type="hidden" name="limit" class="limit">
                                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                                </div>
                            </div> <!-- feture-grids-->
                        </div><!--/row-->
                    </div> <!--/ds-block-pro-->
                </div> <!--Submit Design-->
                <div role="tabpanel" class="tab-pane" id="manufacturer">
                    <div class="ds-block-pro">
                        <h3> <span></span> Recent Post</h3>
                        <div class="row">
                            <div class="feture-grids">
                                <?php
                                if (isset($EmployerAccDesigns) && $EmployerAccDesigns) {
                                    foreach ($EmployerAccDesigns as $t_index => $EmployerAccDesign) {
                                        ?>
                                        <div class="col-md-4">
                                            <div class="feture-grid">
                                                <a href="<?php echo Yii::app()->createUrl('bothDashboard/boughtDesignDetails', ['id' => $EmployerAccDesign['track_id']]); ?>?type=<?php echo $EmployerAccDesign['type']; ?>">
                                                    <img alt="" class="img-responsive" src="<?php
                                                    if ($EmployerAccDesign['image'] != '') {
                                                        if ($this->getFileExtention($EmployerAccDesign['image']) == 'stl') {
                                                            $org_file_name = explode(".", $EmployerAccDesign['image']);
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $org_file_name[0] . '.jpg';
                                                        } else {
                                                            $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/" . $EmployerAccDesign['image'];
                                                        }
                                                    } else {
                                                        $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
                                                    }
                                                    echo $uplpoaded_file;
                                                    ?>">
                                                </a>
                                                <div class="pro-des">
                                                    <div class="price-tag">$<?php echo $EmployerAccDesign['price']; ?></div>
                                                    <p><?php echo substr($EmployerAccDesign['description'], 0, 57); ?>..</p>
                                                    By <a href="#"><?php echo $userData->username; ?></a>
                                                    <!--<button type="button" class="disputButton" data-toggle="modal" data-target="#basicModal">Dispute</button>
                                                                            <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <button class="close btnClose" aria-hidden="true" data-dismiss="modal" type="button">x</button>
        <div class="modal-body bodyPart">
        <div class="form-group textareaPlus">
        <label>Reason For Dispute:</label>
        <textarea class="textarea"></textarea>
        <button type="sublit" class="submitBut">Submit</button>
        </div>
        </div>
        <div class="modal-footer">
        </div>
        </div>
        </div>
        </div>-->
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="append_area" id="selfAcc_design_append_area"></div>
                                <div class="clearfix"></div>
                                <div align="center" class="centralErrorDiv">
                                    <input type="hidden" name="offset" class="offset">
                                    <input type="hidden" name="limit" class="limit">
                                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                                </div>
                            </div><!-- feture-grids-->
                        </div><!--/row-->
                    </div><!--/ds-block-pro-->
                </div> <!--Design Send to Manufacturer-->
            </div><!-- tab-content-->
        </div><!--topr-up-box-->
    </div><!--col-md-12-->
</div><!--row-->

<div class="row">
    <div class="col-md-12">
        <div class="status-box">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <h3 class="pull-left leftPart"> Status</h3>
                <li role="presentation" class="active"><a href="#manufacturert-ds" aria-controls="manufacturert-ds" role="tab" data-toggle="tab">Manufacturer</a></li>
                <li role="presentation" ><a href="#employer-ds" aria-controls="employer-ds" role="tab" data-toggle="tab">Employer</a></li>

            </ul>
            <!-- Nav tabs end -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">

                    <table width="100%" border="0" class="table table-bordered rwd-table">
                        <tr>
                            <th align="center">Monthly / yearly  Revenue</th>
                            <th align="center">Work in Progress</th>
                            <th align="center">Hired Manufacturer</th>
                        </tr>
                        <tr>
                            <td data-th="Monthly / yearly  Revenue">
                                <table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                        <td align="center" valign="top" class="ssClass">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                        <td align="center" valign="top" class="ssClass">Yearly</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">Past 30 Days</td>
                                        <td align="center" valign="top" class="ddClass">&nbsp;</td>
                                        <td align="center" valign="top" class="ddClass">Yearly</td>
                                    </tr>
                                </table>                                
                            </td>
                            <td data-th="Work in Progress">
                                <table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top" class="ssClass">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$1000.00</strong></td>
                                        <td align="center" valign="top" class="ssClass">1 active milestone</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">1 active project</td>
                                        <td align="center" valign="top" class="ddClass">&nbsp;</td>
                                        <td align="center" valign="top" class="ddClass">1 active milestone</td>
                                    </tr>
                                </table>                                
                            </td>
                            <td data-th="Hired Manufacturer">
                                <table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                        <td align="center" valign="top" class="ssClass">Lifetime</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">Lifetime</td>
                                    </tr>
                                </table>                                
                            </td>
                        </tr>
                    </table>
                </div> <!--manufacturert-ds-->
                <div role="tabpanel" class="tab-pane " id="employer-ds">
                    <table width="100%" border="0" class="table table-bordered rwd-table">
                        <tr>
                            <th align="center">Monthly / yearly  Revenue</th>
                            <th align="center">Work in Progress</th>
                            <th align="center">Hired Manufacturer</th>
                        </tr>
                        <tr>
                            <td data-th="Monthly / yearly  Revenue">
                                <table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>300</strong></td>
                                        <td align="center" valign="top" class="ssClass">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                        <td align="center" valign="top" class="ssClass">Yearly</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">Past 30 Days</td>
                                        <td align="center" valign="top" class="ddClass">&nbsp;</td>
                                        <td align="center" valign="top" class="ddClass">Yearly</td>
                                    </tr>
                                </table>                                
                            </td>
                            <td data-th="Work in Progress"><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top" class="ssClass">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$5000.00</strong></td>
                                        <td align="center" valign="top" class="ssClass">1 active milestone</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">1 active project</td>
                                        <td align="center" valign="top" class="ddClass">&nbsp;</td>
                                        <td align="center" valign="top" class="ddClass">1 active milestone</td>
                                    </tr>
                                </table></td>
                            <td data-th="Hired Manufacturer"><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                        <td align="center" valign="top" class="ssClass">Lifetime</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" class="ddClass">Lifetime</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </div><!--employer-ds-->
            </div><!-- tab-content-->
        </div>  <!--status-box-->
    </div><!--col-md-12-->
</div><!--row-->


<div id="confirm_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="text-align: center;">Are you a designer?</h3>
            </div>
            <div class="modal-footer" style="background-color: #f5f5f5;">
                <a href="javascript:void(0);" data-user_id="<?php echo $userData->id ?>"  data-action_type='no' class="bothDashboardAction btn btn-danger" style="margin-bottom: 0px !important;margin-top: 10px !important;">No</a>
                <a href="javascript:void(0);" data-user_id="<?php echo $userData->id ?>"  data-action_type='yes' class="bothDashboardAction btn btn-success" style="padding: 9px !important;margin-bottom: 0px !important;margin-top: 10px !important;">Yes</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
<?php
if ($userData->is_designer == 2) {
    ?>
            $('#confirm_modal').modal('show');
<?php } ?>

        $('.tab-pane').find('.offset').val("<?php echo $offset; ?>");
        $('.tab-pane').find('.limit').val("<?php echo $limit; ?>");


        if ($(window).height() == $(document).height()) {
            loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
        }
    });

    jQuery(document).on('click', '.bothDashboardAction', function() {
        var _this = $(this);
        var user_id = _this.data("user_id");
        var action_type = _this.data("action_type");

        jQuery.ajax({
            type: 'POST',
            cache: false,
            dataType: "json",
            data: {user_id: user_id, action_type: action_type},
            url: "<?php echo Yii::app()->createUrl('bothDashboard/isDesigner'); ?>",
            success: function(resp) {
                if (resp['type'] == 'success') {
                    $('#confirm_modal').modal('hide');
                    $('#action_result').html('<div role="alert" class="alert alert-' + resp['type'] + '">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + resp['msg'] +
                            '</div>');
                } else {

                }
            }
        });
        return false;
    });

    $(window).scroll(function() {
        var offset_val = $('.tab-pane').closest('.active').find('.offset').val();
        var limit_val = $('.tab-pane').closest('.active').find('.limit').val();
        if (limit_val == 0) {
            return;
        }

        if ($(window).height() + $(window).scrollTop() == $(document).height()) {
            loadMore(offset_val, limit_val);
        }
    });

    function loadMore(offset, limit) {

        var current_tab = $('.tab_section').closest('.active').data('active_section');
        $('.tab-pane').closest('.active').find(".loader").show('slow');
        $.ajax({
            async: false,
            url: "<?php echo Yii::app()->createAbsoluteUrl('user/loadMoreBothDashboard'); ?>?c_tab=" + current_tab,
            type: "GET",
            dataType: "json",
            data: {offset: parseInt(offset) + parseInt(limit), limit: limit},
            success: function(result) {
                if (result.status == 'error') {
                    $('.tab-pane').closest('.active').find('.centralErrorDiv').append('<div>' + result.msg + '</div>').css({color: red});
                    $('.tab-pane').closest('.active').find(".loader").hide('slow');
                } else if (result.status == 'noMore') {
                    $('.tab-pane').closest('.active').find(".loader").hide('slow', function() {
                        $('.tab-pane').closest('.active').find('.centralErrorDiv').append('<div style="margin-top:25px;">' + result.msg + '</div>').css('color', "red").css('font-weight', "bold").show('slow');
                    });
                } else {
                    $.each(result.msg, function(index, item) {
                        var price_area = '';
                        if (typeof (item.price) != 'undefined') {
                            price_area = '<div class="pro-des">'
                                    + '<div class="price-tag">' + '$' + item.price
                                    + '</div>'
                        } else {
                            price_area = '';
                        }
                        var html = '<div class="col-md-4">'
                                + '<div class="feture-grid" style="min-height:348px;">'
                                + '<a href="' + item.link + '">'
                                + '<img class="img-responsive" src="' + item.image + '">'
                                + '</a>'
                                + price_area
                                + '<p>&nbsp;&nbsp;'
                                + item.description
                                + '</p>'
                                + '&nbsp;&nbsp;  By &nbsp;&nbsp;<a href="#">' + item.by_whom + '</a>'
                                + '</div>'
                                + '</div>';

//                        html += '</div></div>';
                        $('.tab-pane').closest('.active').find('.append_area').append(html);
                    });
                    $('.tab-pane').closest('.active').find(".loader").hide('slow');
                    $('html, body').animate({
                        scrollTop: $(".status-box").offset().top
                    }, 1000);
                }
                $('.tab-pane').closest('.active').find('.offset').val(result.offset);
                $('.tab-pane').closest('.active').find('.limit').val(result.limit);
                $('.tab-pane').closest('.active').find(".loader").hide('slow');
//                $('#offset').val(result.offset);
//                $('#limit').val(result.limit);
            }
        });
    }
</script>
