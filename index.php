<?php

//echo gethostname();exit;
//include_once '';
// change the following paths if necessary
$env = require_once(dirname(__FILE__) . '/protected/config/env.php');
$yii = dirname(__FILE__) . '/../framework/yii.php';
$configMain = require_once(dirname(__FILE__) . '/protected/config/main.php');
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
require_once($yii);
if (isset($env[gethostname()]))
{
    $configServer = require_once(dirname(__FILE__) . '/protected/config/' . $env[gethostname()] . '/main.php');
}
if (isset($configServer) && is_array($configServer))
{
    $configMain = CMap::mergeArray($configMain, $configServer);
}
require_once './vendor/autoload.php';
Yii::createWebApplication($configMain)->run();