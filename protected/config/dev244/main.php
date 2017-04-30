<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=itsldevs_decorate3d',
            'emulatePrepare' => true,
            'username' => 'itsldevs_dbusr',
            'password' => 'Bips7*42K+RaaZS#.uK563',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix' => '',
        )
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);