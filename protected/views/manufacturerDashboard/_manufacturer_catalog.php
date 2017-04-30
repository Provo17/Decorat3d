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
            $design_img = Yii::app()->baseUrl . '/upload/manufacturer_catalog/' . $clg->uploaded_file;
            $ext = pathinfo($design_img, PATHINFO_EXTENSION);
            }
        else
            {
            $design_img = Assets::themeUrl("layout/img/no_image_available.jpg");
            }

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
                                    <canvas data-uploadDir="catalog" data-href="<?php echo $design_img; ?>" data-catalogPrice="Price: $<?php echo sprintf("%.2f", $clg->price); ?>" data-rawImageName="<?php echo $clg->uploaded_file; ?>" data-description="<?php echo $description; ?>" id="cv_<?php echo $count; ?>" width="260" height="202"></canvas>
                                    <script>
                                        $(document).ready(function() {
                                            viewer3d('cv_' + "<?php echo $count; ?>");
                                        });

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
                                                <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('manufacturerDashboard/ManufacturerCatalog') ?>?search_type=<?php isset($_GET['search_type']) ? $_GET['search_type'] : ''; ?>&key=<?php isset($_GET['key']) ? $_GET['key'] : ''; ?>" class="btn btn-default btn-xs pull-right">Buy Now</a>
                                                <?php
                                                }
                                            else
                                                {
                                                if ($clg->manufacturer_id != Yii::app()->user->id)
                                                    {
                                                    $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                                                    if ($userData->user_type_id == '2')
                                                        {
                                                        ?>
                                                        <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=manufacturer_catalog" class="btn btn-default btn-xs pull-right"><?php echo Yii::t('string', "Buy Now"); ?></a>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            ?>
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
                        <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('manufacturerDashboard/ManufacturerCatalog') ?>?search_type=<?php isset($_GET['search_type']) ? $_GET['search_type'] : ''; ?>&key=<?php isset($_GET['key']) ? $_GET['key'] : ''; ?>" class="btn btn-default btn-xs pull-right">Buy Now</a>
                        <?php
                        }
                    else
                        {
                        if ($clg->manufacturer_id != Yii::app()->user->id)
                            {
                            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                            if ($userData->user_type_id == '2')
                                {
                                ?>
                                <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->id . '/add') ?>?src=manufacturer_catalog" class="buy-bttn"><?php echo Yii::t('string', "Buy Now"); ?></a>
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
?>