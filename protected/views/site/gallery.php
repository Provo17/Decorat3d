<section class="page-section1 gallery">
    <div class="container">
        <h1><?php echo Yii::t('string', "Our Gallery"); ?></h1>
        <h3><?php echo Yii::t('string', "You can get anything done on Decorat3d. Which great idea will you launch today?"); ?></h3>
        <div class="row">
            <?php
            if (isset($catalog) && $catalog)
                {
                $design_img = '';
                foreach ($catalog as $c_key => $clg)
                    {
                    $description = '';
                    $count = $c_key + 1;
                    if ($clg->uploaded_file != '')
                        {
                        $design_img = Yii::app()->baseUrl . '/upload/catalog/' . $clg->uploaded_file;
                        $ext = pathinfo($design_img, PATHINFO_EXTENSION);
                        }
                    else
                        {
                        $design_img = Assets::themeUrl("layout/img/no_image_available.jpg");
                        }
                    if ($c_key <= 3)
                        {
                        $title = $clg->title;
                        if (strlen($title) > 28)
                            {
//                            $pos = strpos($title, ' ', 28);
                            $description = substr($title, 0, 28);
                            }
                        else
                            {
                            $description = $title;
                            }
                        if ($ext == 'stl')
                            {
                            ?>
                            <span class="catlog-title" data-title="<?php echo wordwrap($description, 8, "\n", true); ?>"></span>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="">
                                    <!-- Main div -->
                                    <div id="div" class="containers">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="view3d">
                                                    <!-- HTML5 Canvas -->
                                                    <a id="image_save_url" href="<?php echo Yii::app()->createUrl('site/CanvasToImage'); ?>"></a>
                                                    <canvas data-uploadDir="catalog" data-href="<?php echo $design_img; ?>" data-catalogPrice="Price: $<?php echo sprintf("%.2f", $clg->price); ?>" data-rawImageName="<?php echo $clg->uploaded_file; ?>" data-description="<?php echo $description; ?>" id="cv_<?php echo $clg->id; ?>" width="555" height="308"></canvas>
                                                    <script>
                                                        $(document).ready(function() {
                                                            viewer3d('cv_' + "<?php echo $clg->id; ?>");
                                                            //                                                            to_image();
                                                        });

                                                        //                                                        }
                                                    </script>
                                                    <!-- Rotate and Zoom Tip -->

                                                </div>
                                                <style>
                                                    .table {
                                                        width: 100%;
                                                        margin-bottom: 0px;
                                                        /*max-width: 400% !important;*/
                                                    }
                                                    .table tr td{
                                                        padding: 0px;
                                                    }
                                                </style>
                                                <!-- Render type selection menu -->
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group dropup">
                                                                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                                                    <span class="glyphicon glyphicon glyphicon-cog"></span> Options <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="#wireframe" class="rendermode"><?php echo Yii::t('string', "Wireframe"); ?></a></li>
                                                                    <li><a href="#point" class="rendermode"><?php echo Yii::t('string', "Points"); ?></a></li>
                                                                    <li><a href="#flat" class="rendermode"><?php echo Yii::t('string', "Filled"); ?></a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (Yii::app()->user->isGuest)
                                                                {
                                                                ?>
                                                                <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="btn btn-default btn-xs pull-right">Buy Now</a>
                                                                <?php
                                                                }
                                                            else
                                                                {
                                                                if ($clg->designer_id != Yii::app()->user->id)
                                                                    {
                                                                    $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                                                                    if ($userData->user_type_id == '2')
                                                                        {
                                                                        ?>
                                                                        <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="btn btn-default btn-xs pull-right">Buy Now</a>
                                                                        <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Main div -->
                                </div>
                            </div>
                            <?php
                            }
                        else
                            {
                            ?>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="glry-img">
                                    <img src="<?php echo $design_img; ?>" height="349">
                                    <div class="mask">
                                        <h4>
                                            <?php
                                            echo wordwrap($description, 8, "\n", true);
                                            ?>
                                        </h4>
                                        <span>Price: $<?php echo sprintf("%.2f", $clg->price); ?></span>
                                        <a href="#inline_demo<?php echo $count; ?>" rel="prettyPhoto[inline]" title="<?php echo wordwrap($description, 8, "\n", true) . '..'; ?>">View</a>
                                    </div>
                                </div>
                            </div>
                            <div id="inline_demo<?php echo $count; ?>" style="display:none;">
                                <img src="<?php echo $design_img; ?>">
                                <?php
                                if (Yii::app()->user->isGuest)
                                    {
                                    ?>
                                    <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="buy-bttn">Buy Now</a>
                                    <?php
                                    }
                                else
                                    {
                                    if ($clg->designer_id != Yii::app()->user->id)
                                        {
                                        $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                                        if ($userData->user_type_id == '2')
                                            {
                                            ?>
                                            <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="buy-bttn"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                            <?php
                                            }
                                        }
                                    }
                                ?>
                            </div>
                            <?php
                            }
                        }
                    else
                        {
                        if ($ext == 'stl')
                            {
                            ?>
                            <span class="catlog-title" data-title="<?php echo wordwrap($description, 8, "\n", true); ?>"></span>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="">
                                    <!-- Main div -->
                                    <div id="div" class="containers">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="view3d">
                                                    <!-- HTML5 Canvas -->
                                                    <a id="image_save_url" href="<?php echo Yii::app()->createUrl('site/CanvasToImage'); ?>"></a>
                                                    <canvas data-uploadDir="catalog" data-href="<?php echo $design_img; ?>" data-catalogPrice="Price: $<?php echo sprintf("%.2f", $clg->price); ?>" data-rawImageName="<?php echo $clg->uploaded_file; ?>" data-description="<?php echo $description; ?>" id="cv_<?php echo $clg->id; ?>" width="260" height="202"></canvas>
                                                    <script>
                                                        $(document).ready(function() {
                                                            viewer3d('cv_' + "<?php echo $clg->id; ?>");
                                                            //                                                            to_image();
                                                        });

                                                        //                                                        }
                                                    </script>
                                                    <!-- Rotate and Zoom Tip -->

                                                </div>
                                                <style>
                                                    .table {
                                                        width: 100%;
                                                        margin-bottom: 0px;
                                                        /*max-width: 400% !important;*/
                                                    }
                                                    .table tr td{
                                                        padding: 0px;
                                                    }
                                                </style>
                                                <!-- Render type selection menu -->
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group dropup">
                                                                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                                                    <span class="glyphicon glyphicon glyphicon-cog"></span> Options <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="#wireframe" class="rendermode">Wireframe</a></li>
                                                                    <li><a href="#point" class="rendermode">Points</a></li>
                                                                    <li><a href="#flat" class="rendermode">Filled</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (Yii::app()->user->isGuest)
                                                                {
                                                                ?>
                                                                <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="btn btn-default btn-xs pull-right"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                                                <?php
                                                                }
                                                            else
                                                                {
                                                                if ($clg->designer_id != Yii::app()->user->id)
                                                                    {
                                                                    $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                                                                    if ($userData->user_type_id == '2')
                                                                        {
                                                                        ?>
                                                                        <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="btn btn-default btn-xs pull-right"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                                                        <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Main div -->
                                </div>
                            </div>
                            <?php
                            }
                        else
                            {
                            ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="glry-img imgPart123">
                                    <img src="<?php echo $design_img; ?>">
                                    <div class="mask">
                                        <h4><?php
                                            $title = $clg->title;
                                            if (strlen($title) > 28)
                                                {
                                                $pos = strpos($title, ' ', 28);
                                                $description = substr($title, 0, $pos) . '..';
                                                }
                                            else
                                                {
                                                $description = $title;
                                                }
                                            echo wordwrap($description, 8, "\n", true);
                                            ?></h4>
                                        <span>Price: $<?php echo sprintf("%.2f", $clg->price); ?></span>
                                        <a href="#inline_demo<?php echo $count; ?>" rel="prettyPhoto[inline]" title="<?php echo wordwrap($description, 8, "\n", true) . '..'; ?>"><?php echo Yii::t('string', "View"); ?></a>
                                    </div>
                                </div>
                                <div id="inline_demo<?php echo $count; ?>" style="display:none;">
                                    <img src="<?php echo $design_img; ?>">
                                    <?php
                                    if (Yii::app()->user->isGuest)
                                        {
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="buy-bttn"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                        <?php
                                        }
                                    else
                                        {
                                        if ($clg->designer_id != Yii::app()->user->id)
                                            {
                                            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                                            if ($userData->user_type_id == '2')
                                                {
                                                ?>
                                                <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=designer_catalog" class="buy-bttn"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                                <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                            }
                        }
                    }
                }
            ?>
            <div id="appendArea"></div>

        </div>
        <div align="center" id="centralErrorDiv">
            <input type="hidden" name="key" id="key">
            <input type="hidden" name="offset" id="offset">
            <input type="hidden" name="limit" id="limit">
            <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
        </div>
        <div id="no_more_data" style="text-align:center;"></div>
    </div>
</section>

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
                                            $('#offset').val(<?php echo $offset; ?>);
                                            $('#limit').val(<?php echo $limit; ?>);
                                            $('#key').val(<?php echo $key; ?>);

                                            if ($(window).height() == $(document).height()) {
                                                loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
                                            }
                                            $("a[rel^='prettyPhoto']").prettyPhoto({
                                                slideshow: '5000',
                                                animation_speed: 'fast',
                                                social_tools: false,
                                                overlay_gallery: true,
                                                deeplinking: false
                                            });
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
                                            $('canvas').find(".canvs").removeClass("canvs");
                                            $(".loader").show('slow');
                                            $.ajax({
                                                async: false,
                                                url: "<?php echo Yii::app()->createAbsoluteUrl('site/galleryLoadMore'); ?>",
                                                type: "GET",
                                                dataType: "json",
                                                data: {key: $('#key').val(), offset: parseInt(offset) + parseInt(limit), limit: limit},
                                                success: function(resp) {
                                                    if (resp.type == 'error') {
                                                        $("#centralErrorDiv").append('<div>' + result.msg + '</div>').css({color: red});
                                                        $(".loader").hide('slow');
                                                    }
                                                    if (resp.type == 'success') {
                                                        $('#appendArea').append(resp.html);
                                                        $.each($(".canvs"), function(index, item) {
                                                            viewer3d($(item).attr('id'));
                                                        });
                                                        $(".loader").hide('slow');
                                                        $("a[rel^='prettyPhoto']").prettyPhoto({
                                                            animation_speed: 'fast',
                                                            social_tools: false,
                                                            deeplinking: false,
                                                            overlay_gallery: true,
                                                            slideshow: '5000'
                                                        });
                                                    } else if (resp.type == 'nomore') {
                                                        $(".loader").hide('slow');
                                                        $("#no_more_data").html('<div style="margin-top:25px;">' + resp.msg + '</div>').css('color', "red").css('font-weight', "bold").show('slow');
                                                    }
                                                    $('#offset').val(resp.offset);
                                                    $('#limit').val(resp.limit);
                                                }
                                            });
                                        }
</script>