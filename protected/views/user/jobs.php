<!--dash box-->
<section class="dash-box">
    <div class="color-box4">
        <div class="heading">
            <h2>See All Projects</h2>
        </div>
        <div class="searchJob">
            <div class="container job1">
                <div class="design-list">
                    <?php
                    if (isset($all_jobs) && $all_jobs) {
                        $project_assigned = '';
                        foreach ($all_jobs as $key => $jobs) {
                            $project_assigned = '';
                            $allJobBid = JobBid::model()->findAllByAttributes(['jobs_id' => $jobs->id]);
                            if ($allJobBid != '') {
                                foreach ($allJobBid as $allJobBid_key => $bid) {
                                    $true_bid = TransactionReport::model()->findByAttributes(['bid_id' => $bid->id, 'status' => '23', 'bid_type' => '1']);
                                    if ($true_bid) {
                                        $project_assigned = 'yes';
                                        continue;
                                    }
                                }
                            }
                            ?>
                            <div class="row jobPart1">
                                <div class="col-md-1 col-sm-2 col-xs-3">
                                    <img src="<?php
                                    if ($jobs->uploaded_file != '') {
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
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-6">
                                    <div class="contentMiddlePart">
                                        <h2><a href="<?php echo Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $jobs->id]); ?>"><?php echo strlen($jobs->description) > 57 ? substr($jobs->description, 0, 57) : $jobs->description; ?>..</a></h2>
                                        <p>By <a href="#"><?php echo $jobs->job_owner->username; ?></a></p>
                                        <span><?php echo date_format(date_create($jobs->created_at), 'g:ia \o\n l jS F Y'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-3">
                                    <?php
                                    if (isset($project_assigned) && $project_assigned == 'yes') {
                                        ?>
                                        <a href="javascript:void(0);" class="applyNow pull-right" style="background:#0066CC !important;">Completed</a>
                                        <?php
                                    } else if (!Yii::app()->user->isGuest && $userModel->user_type_id == 2) {
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $jobs->id]); ?>" class="applyNow pull-right">Bid Now</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('site/login', ['return_url' => Yii::app()->getBaseUrl(true) . '/project-detail/' . $jobs->id . '.html']); ?>" class="applyNow pull-right">Bid Now</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>                
            </div>
            <div align="center" id="centralErrorDiv">
                <input type="hidden" name="key" id="key">
                <input type="hidden" name="offset" id="offset">
                <input type="hidden" name="limit" id="limit">
                <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
            </div>
        </div>
    </div>
</section>
<!--/dash box-->

<script>
    $(document).ready(function() {
        $('#key').val(<?php echo $key; ?>);
        $('#offset').val(<?php echo $offset; ?>);
        $('#limit').val(<?php echo $limit; ?>);

        if ($(window).height() == $(document).height()) {
            loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
        }
    });

    $(document).scroll(function() {
        if ($('#limit').val() == 0) {
            return;
        }
        if ($(window).height() + $(window).scrollTop() == $(document).height()) {
            loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
        }
    });

    function loadMore(key, offset, limit) {
        $(".loader").show('slow');
        $.ajax({
            async: false,
            url: "<?php echo Yii::app()->createAbsoluteUrl('user/loadMoreJobs'); ?>",
            type: "GET",
            dataType: "json",
            data: {key: key, offset: parseInt(offset) + parseInt(limit), limit: limit},
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
                        var html = '<div class="row jobPart1">'
                                + '<div class="col-md-1 col-sm-2 col-xs-3">'
                                + '<img src="' + item.image + '">'
                                + '</div>'
                                + '<div class="col-md-9 col-sm-8 col-xs-6">'
                                + '<div class="contentMiddlePart">'
                                + '<h2><a href="' + item.link + '">' + item.description + '..</a></h2>'
                                + '<p>By <a href="#">' + item.username + '</a></p>'
                                + '<span>' + item.created_at + '</span>'
                                + '</div>'
                                + '</div>'
                                + '<div class="col-md-2 col-sm-2 col-xs-3">';
                        if (item.project_assigned == 'yes') {
                            html += '<a href="javascript:void(0);" class="applyNow pull-right" style="background:#0066CC !important;">Completed</a>';
                        } else if (item.project_assigned == 'Bid Now1') {
                            html += '<a href="' + item.project_assigned_link + '" class="applyNow pull-right">Bid Now</a>';
                        } else {
                            html += '<a href="' + item.project_assigned_link + '" class="applyNow pull-right">Bid Now</a>';
                        }
                        html += '</div></div>';
                        $('.design-list').append(html);
                    });
                    $(".loader").hide('slow');
                }
                $('#offset').val(result.offset);
                $('#limit').val(result.limit);
            }
        });
    }
</script>