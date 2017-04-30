<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'Assets.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'Common.php';
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Decorat3d.com',
    'theme' => 'frontend',
    //'homeUrl' => 'site/index',
// preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'ext.easyimage.EasyImage',
        'application.helpers.*',
        'ext.EDataTables.*',
        'application.models.*',
        //'application.modules.admin.models.*',
//'application.modules.admin.modules.language.models.*', //lang module's model
'application.modules.admin.modules.settings.models.*', //lang module's model
// 'application.modules.admin.models.ContactUs',
        'application.components.*',
        'application.components.widgets.*',
        'application.vendor.social_login.*',
        'ext.YiiMailer.YiiMailer',
        'ext.bringApi.BringPackage',
        'ext.betalingsterminal.*',
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
    //'application.modules.yiiseo.models.*',//seo
    ),
    'modules' => array(
        'translate',
        'admin',
        'supplier',
        'webshop',
        'company',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => [],
        ),
    ),
    // application components
    'components' => array(
        // Easy Image extention
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage'),
        'Paypal' => array(
			'class'=>'application.components.Paypal',
			//'apiUsername' => 'YOUR_API_USERNAME',
			//'apiPassword' => 'YOUR_API_PASSWORD',
			//'apiSignature' => 'YOUR_API_SIGNATURE',
			//'apiLive' => false,
			
			'returnUrl' => 'payment-confirm/', //regardless of url management component
			'cancelUrl' => 'payment-cancel/', //regardless of url management component
		),
        'AdminPaypal' => array(
                    'class' => 'application.modules.admin.components.Paypal',
                    //'username' => 'sanjeet.kumar-facilitator_api1.infoway.us', //APP User Name required
                    //'password' => '1372408458', //APP Password required
                    //'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AJQA0AvlloT7TAxU2vQ52h9XvlBv', //APP Signature required
                    //'appid' => 'APP-80W284485P519543T', //APP Id required
                    //'sandbox' => true, // live or sandbox mode
                    //'returnUrl' => 'WithdrawRequest/success', //regardless of url management component
                    //'cancelUrl' => 'WithdrawRequest/cancel', //regardless of url management component
                    // Default currency to use, if not set USD is the default
                    'currencyCode' => 'USD', // currencyCode Required
                ),
        'widgetFactory' => array(
            'widgets' => array(
                'CLinkPager' => array(
                    'htmlOptions' => array(
                        'class' => 'pagination'
                    ),
                    'header' => false,
                    'maxButtonCount' => 5,
                    'cssFile' => false,
                ),
                'CGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive'
                    ),
                    'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                    'itemsCssClass' => 'table table-striped table-hover',
                    'cssFile' => false,
                    'summaryCssClass' => 'dataTables_info',
                    'summaryText' => 'Showing {start} to {end} of {count} entries',
                    'template' => '{items}<div class="row"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
                ),
            ),
        ),
        'user' => array(// Webuser for the frontend
            'class' => 'WebUser',
            'loginUrl' => array('user/Signin'),
            'returnUrl' => array('site/index'),
            'stateKeyPrefix' => 'frontend_',
        ),
        'adminUser' => array(// Webuser for the supplier area (supplier)
            'class' => 'AdminWebUser',
            'loginUrl' => array('/admin/auth/login'),
            'stateKeyPrefix' => 'admin_',
        ),
        'loid' => array(
                    'class' => 'ext.lightopenid.loid',
        ),
         'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache'.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'services' => array(// You can change the providers and their classes.
                'google_oauth' => array(
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'GoogleOAuthService',
                    'client_id' => '266911035803-vbefmchg11teacfcb3j887tdlpn3h64q.apps.googleusercontent.com',//local server : 150725309219-rrjptq5mjqejgagtvqot5o76ol0jegoh.apps.googleusercontent.com  live server : 242044970395-pqjpi6hi48a10kk034vtn94hhup2r7s0.apps.googleusercontent.com
                    'client_secret' => 'ZzbkbFAkSjIlf4TiONiCOnnk', // local server : 0BNl_bt_Ah5NULiacIcyp9I8    live server : yX1TnBiJxsWBZ-aAyTqtFcMS
                    'title' => 'Google (OAuth)',
                ),
                'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'FacebookOAuthService', //FacebookOAuthService
                    'client_id' => '1497306407237664', // Local server :  1594801320798403    live server :   863252047043976
                    'client_secret' => '00d511bfc5aa8db3cc930d0217ea26b8', // Local server :  e9fe1ff018b15b58fc8f8f7af4326b5f    live server :  2a7e8bd106970c835db8999c0134a8b0
                ),
                'twitter' => array(
                // register your app here: https://dev.twitter.com/apps/new
                'class' => 'CustomTwitterService',//TwitterOAuthService
                'key' => '59N2MQImSKYhSJxsj5Yyk1H53',
                'secret' => 'j9eyZSALcQlbViMuWK9UlQ7eCSoYvknt7wJOHCwOqG8oH2066B',
                ),
                'linkedin' => array(
                    // register your app here: https://www.linkedin.com/secure/developer
                    'class' => 'LinkedinOAuthService',
                    'key' => '75gene9oa48yq6',// local server :  756ql9iq1bgmah  live server :  75e440na6wfe2x
                    'secret' => 'lGjReUxx0Eye0kRv', //local server : 7pCkmB7JH9PJuMlU  live server :  1Phi5UeoehqDIZop
                ),
            ),
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
//'class' => 'application.components.UrlManager',
            'showScriptName' => false,
            //'useStrictParsing' => true,
            'urlFormat' => 'path',
            'urlSuffix' => '.html',
            'rules' => include_once 'routes.php',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=app3_yii_callfire',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix' => 'proj_',
        ),
        'errorHandler' => array(
// use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'cache' => array(
            'class' => 'system.caching.CDbCache'
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        /* 'clientScript'=>array(
          'packages'=>array(
          'jquery'=>array(
          'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1/',
          'js'=>array('jquery.min.js'),
          )
          ),
          ), */
        'clientScript' => array(
            'packages' => array(
                'jquery' => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/',
                    'js' => array('jquery.min.js'),
                ),
            ),
        ),
    ),
    // 'sourceLanguage' => 'dev',
    'language' => 'en',
    'params' => array(
        'adminEmail' => 'webmaster@example.com',
        'currency' => 'kr',
    ),
);

