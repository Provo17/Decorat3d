<div id="div" class="containersrr">
    <div class="row">
        <div class="col-md-12">
            <div id="view3d" style="text-align: center;">
                <!-- HTML5 Canvas -->
                <a id="image_save_url" href="<?php echo Yii::app()->createUrl('site/CanvasToImage'); ?>"></a>
                <canvas data-uploadDir="jobs" data-href="<?php echo Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $rawImage; ?>"  data-rawImageName="<?php echo $rawImage; ?>"  id="cv" width="555" height="308"></canvas>
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
                                <li><a href="#wireframe" class="rendermode">Wireframe</a></li>
                                <li><a href="#point" class="rendermode">Points</a></li>
                                <li><a href="#flat" class="rendermode">Filled</a></li>
                            </ul>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>