<?php
if (count($acc_catalogs) > 0)
    {
    $design_img = $last_acc_catalog = '';
    $count = 0;
    $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
    foreach ($acc_catalogs as $c_key => $clg)
        {
        $description = '';
        $count = $count + 1;
        if ($count > 4)
            {
            continue;
            }
            ?>
<!--<input type="text" value="<?php // echo $clg->bid_id;?>">-->
<?php
        if ($clg->catalog->uploaded_file != '')
            {
            $design_img = Yii::app()->baseUrl . '/upload/catalog/' . $clg->catalog->uploaded_file;
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
                                    <canvas data-uploadDir="catalog" data-href="<?php echo $design_img; ?>" data-catalogPrice="Price: $<?php echo sprintf("%.2f", $clg->catalog->uploaded_file); ?>" data-rawImageName="<?php echo $clg->catalog->uploaded_file; ?>" data-description="<?php echo $description; ?>" id="cv_<?php echo $clg->catalog->id; ?>" width="260" height="202"></canvas>
                                    <script>
                                        $(document).ready(function() {
                                            viewer3d('cv_' + "<?php echo $clg->catalog->id; ?>");
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
                                                <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('manufacturerDashboard/purchasedCatalog') ?>?search_type=<?php isset($_GET['search_type']) ? $_GET['search_type'] : ''; ?>&key=<?php isset($_GET['key']) ? $_GET['key'] : ''; ?>" class="btn btn-default btn-xs pull-right">Bid Now</a>
                                                <?php
                                                }
                                            else
                                                {
                                                if ($userData->user_type_id == '3')
                                                    {
                                                    ?>
                                                    <a href="<?php echo Yii::app()->createUrl('manufacturerDashboard/jobDetails', ['id' => $clg->id]); ?>?track_id=<?php echo $clg->bid_id; ?>&type=catalog_design" class="btn btn-default btn-xs pull-right"><?php echo Yii::t('string', "Bid Now"); ?></a>
                                                    <?php
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
                            $title = $clg->catalog->title;
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
                        <span>Price: $<?php echo sprintf("%.2f", $clg->catalog->price); ?></span>
                        <a href="#inline_demo<?php echo $count; ?>" rel="prettyPhoto[inline]" title="<?php echo wordwrap($description, 8, "\n", true) . '..'; ?>">View</a>
                        <!--<a href="<?php // echo $design_img;                                                         ?>" rel="prettyPhoto" title="Tshirt Designs">View</a>-->
                    </div>
                </div>
                <div id="inline_demo<?php echo $count; ?>" style="display:none;">
                    <img src="<?php echo $design_img; ?>">
                    <?php
                    if (Yii::app()->user->isGuest)
                        {
                        ?>
                        <a href="<?php echo Yii::app()->createUrl('site/login') ?>?return_url=<?php echo Yii::app()->createUrl('/bid/' . $clg->catalog->id . '/add') ?>?src=designer_catalog" class="buy-bttn">Buy Now</a>
                        <?php
                        }
                    else
                        {
                        if ($clg->catalog->designer_id != Yii::app()->user->id)
                            {
                            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                            if ($userData->user_type_id == '3')
                                {
                                ?>
                                <a href="<?php echo Yii::app()->createUrl('/bid/' . $clg->catalog->id . '/add') ?>?src=designer_catalog" class="buy-bttn">Buy Now</a>
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
              
