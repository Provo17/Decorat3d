<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>STL 3D Viewer</title>
    </head>
    <body>
        <!-- Main div -->
        <div id="div" class="container">
            <div class="row">
                <div class="col-md-4">
                    <div id="view3d">
                        <!-- HTML5 Canvas -->
                        <canvas id="cv" width="300" height="300"></canvas>

                        <!-- Rotate and Zoom Tip -->

                        <div class="panel panel-info" id="tip">
                            <table class="table">
                                <tr><td>
                                        Zoom </td> <td><kbd>Wheel</kbd>
                                    </td></tr>
                                <tr><td>
                                        Rotate </td> <td><kbd>Drag</kbd> 
                                    </td></tr>
                                <tr><td>
                                        Pan </td> <td><kbd>Ctrl</kbd> + <kbd>Drag</kbd>
                                    </td></tr>
                            </table>
                        </div>
                    </div>
                    <!-- Render type selection menu -->
                    <table class="table">
                        <tr><td>
                                <button class="btn btn-default btn-xs pull-left" id="info">
                                    <span class="glyphicon glyphicon-info-sign"></span> Interact
                                </button>
                            </td>
                            <td>
                                <div class="btn-group dropup pull-right">
                                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-eye-open"></span> View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#wireframe" class="rendermode">Wireframe</a></li>
                                        <li><a href="#point" class="rendermode">Points</a></li>
                                        <li><a href="#flat" class="rendermode">Filled</a></li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="list-group container-fluid">
                        <a href="#" class="list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading" id="objtitle"></h4>
                            <small><p class="list-group-item-text" id="description"></p></small>
                        </a>
                        <div class="list-group-item list-group-item-warning">
                            <h4 class="list-group-item-heading">Material</h4>
                            <div class="btn-group btn-group" id="materials"></div>
                        </div>
                        <a href="#" class="list-group-item list-group-item-success">
                            <h3 class="list-group-item-heading"><span class="glyphicon glyphicon-usd"></span><span id="price"></span></h3>
                            <small><p class="list-group-item-text"><span id="price_subtext"></span></p></small>
                        </a>
                        <div class="list-group-item">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Quantity">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="addToCart">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Main div -->


        <a id="dataJson" href="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/data.json"); ?>"></a>
        <!-- 
CSS and Javascript library definitions.
        -->
        <link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap.min.css"); ?>">
        <link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/bootstrap-theme.min.css"); ?>">
        <link rel="stylesheet" src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/css/style.css"); ?>">

        <script src="<?php // echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jquery-1.11.1.min.js");    ?>"></script>
        <script src="<?php // echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/bootstrap.min.js");    ?>"></script>
        <script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.js"); ?>"></script>
        <script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/jsc3d.console.js"); ?>"></script>

        <script src="<?php echo Assets::themeUrl("vendor/codecanyon-3222913-stl3d-viewer/dist/js/object_viewer.js"); ?>"></script>


    </body>
</html>