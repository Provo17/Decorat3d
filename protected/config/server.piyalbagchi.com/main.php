<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=thexeta_profileringsportalen',
            'emulatePrepare' => true,
            'username' => 'thexeta_newusrw',
            'password' => '?e9z,QX4?Om-',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix' => 'proj_',
        ),
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);