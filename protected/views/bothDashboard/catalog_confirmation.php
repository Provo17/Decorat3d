<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> <?php echo Yii::t('string', "Uploaded Catalog Preview"); ?></h2>
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
    <?php
    if ($model->uploaded_file != '')
        {
        if ($this->getFileExtention($model->uploaded_file) == 'stl')
            {
            ?>
            <div id="div" class="containersrr">
                <div class="row">
                    <div class="col-md-12">
                        <div id="view3d" style="text-align: center;">
                            <!-- HTML5 Canvas -->
                            <a id="image_save_url" href="<?php echo Yii::app()->createUrl('site/CanvasToImage'); ?>"></a>
                            <canvas data-uploadDir="catalog" data-href="<?php echo Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $model->uploaded_file; ?>"  data-rawImageName="<?php echo $model->uploaded_file; ?>"  id="cv" width="555" height="308"></canvas>
                            <script>
                                $(document).ready(function() {
                                    viewer3d('cv');
                                });
                            </script>
                        </div>
                        <style>
                            .table {
                                /*width: 155%;*/
                                max-width: 400% !important;
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
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            }
        else
            {
            ?>
            <img src="<?php echo Yii::app()->request->getBaseUrl(true) . "/upload/catalog/" . $model->uploaded_file; ?>">
            <?php
            }
        }
    ?>

    <div class="clearfix"></div>
    <h2><?php echo Yii::t('string', "Description"); ?></h2>
    <div class="postDetailsP">        
        <p><b>Title: </b> <?php echo isset($model->title) ? $model->title : ''; ?></p>
        <p><b>Price: </b> <?php echo isset($model->price) ? $model->price : ''; ?></p>
    </div>
    <br/>
    <div>       
        <a  href="<?php echo Yii::app()->createUrl('bothDashboard/catalog',['id'=>$model->id]);?>" class="btn btn-default btn-xs pull-left" >
            <span class="glyphicon glyphicon-confirm"></span> <?php echo Yii::t('string', "Edit"); ?> 
        </a>
        <a href="<?php echo Yii::app()->createUrl('bothDashboard/catalogConfirmationActions',['id'=>$model->id]);?>?type=confirm" class="btn btn-success btn-xs pull-left" >
            <span class="glyphicon glyphicon-confirm"></span> <?php echo Yii::t('string', "Confirm"); ?> 
        </a>
        <a href="<?php echo Yii::app()->createUrl('bothDashboard/catalogConfirmationActions',['id'=>$model->id]);?>?type=cancel" class="btn btn-danger btn-xs pull-left" >
            <span class="glyphicon glyphicon-confirm"></span> <?php echo Yii::t('string', "Cancel"); ?> 
        </a>
    </div>
    <div class="clearfix"></div>
</div>
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