<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<script src="<?php // echo Assets::themeUrl("js/jquery-1.11.3.min.js"); ?>"></script>
<title>Home | Decorat3d</title>
<link href="<?php echo Assets::themeUrl("css/bootstrap.min.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/main.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/responsive.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/font-awesome.min.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/prettyPhoto.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/animate.css"); ?>" rel="stylesheet">
<link href="<?php echo Assets::themeUrl("css/bootstrap-select.css"); ?>" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<?php
        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => Yii::app()->request->baseUrl . '/themes/frontend/assets/js/jquery-1.11.3.min.js'
        );
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        ?>
<!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
            <![endif]-->
<link rel="shortcut icon" href="<?php echo Assets::themeUrl("images/ico/favicon.ico") ?>">
</head>
<body>
<?php echo $content; ?>
<!--        <script src="<?php echo Assets::themeUrl("js/jquery.js"); ?>"></script>-->
<script src="<?php echo Assets::themeUrl("js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("js/jquery.prettyPhoto.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("js/main.js"); ?>"></script>
<!--        <script src="<?php echo Assets::themeUrl("js/bootstrap-select.js"); ?>"></script>-->
</body>
</html>
