<?php

class Assets {

    private static $_theme_path = 'themes';
    private static $_theme = '';
    private static $_package_path = 'vendor';
    private static $_css_path = 'css';
    private static $_js_path = 'js';
    private static $_assets_url = '';
    public static $_package_list;

    public static function init($settings) {
        self::$_package_list = require_once 'assets.packages.php';
        if (isset($settings['assets_url'])) {
            self::$_assets_url = $settings['assets_url'];
        }
        if (isset($settings['package_path'])) {
            self::$_package_path = $settings['package_path'];
        }
        if (isset($settings['css_path'])) {
            self::$_css_path = $settings['css_path'];
        }
        if (isset($settings['js_path'])) {
            self::$_js_path = $settings['js_path'];
        }
    }

    /*
     * load a single package
     */

    public static function loadPlugin($name) {
        if (is_array($name)) {
            return self::loadPlugins($name);
        }
        //check package name is 
        if (isset(self::$_package_list[$name])) {
            $package = self::$_package_list[$name];
            $_path = self::$_package_path . "/" . $name . "/";
            //check js file and load it
            if (isset($package['js'])) {
                //check multiple js or single file                
                if (is_array($package['js'])) {
                    $pos = isset($package['pos']) ? $package['pos'] : CClientScript::POS_HEAD;
                    foreach ($package['js'] as $jsFile) {
                        if ($jsFile != '') {
                            self::loadJsFile($_path . $jsFile, $pos);
                        }
                    }
                } elseif ($package['js'] != '') {
                    self::loadJsFile($_path . $package['js']);
                }
            }
            //check css file and load it
            if (isset($package['css'])) {
                //check multiple js or single file
                if (is_array($package['css'])) {
                    foreach ($package['css'] as $cssFile) {
                        if ($cssFile != '') {
                            self::loadCssFile($_path . $cssFile);
                        }
                    }
                } elseif ($package['css'] != '') {
                    self::loadCssFile($_path . $package['css']);
                }
            }
        } else {
            //throw new ExceptionClass('ExceptionMessage');
        }
    }

    /*
     * load multiple package
     */

    public static function loadPlugins(Array $names) {
        foreach ($names as $item) {
            self::loadPlugin($item);
        }
    }

    /*
     * load CSS file
     */

    public static function loadCssFile($file) {
        Yii::app()->clientScript->registerCssFile(self::$_assets_url . '/' . $file);
    }

    /*
     * load multiple CSS file
     */

    public static function loadCssFiles($files) {
        if (is_array($files)) {
            foreach ($files as $file) {
                Yii::app()->clientScript->registerCssFile(self::$_assets_url . '/' . $file);
            }
        }
    }

    /*
     * load JS package
     */

    public static function loadJsFile($file, $LOCATION = CClientScript::POS_END) {
        //echo self::$_assets_url . '/' . $file;exit;
        Yii::app()->clientScript->registerScriptFile(self::$_assets_url . '/' . $file, $LOCATION);
    }

    /*
     * load JS package
     */

    public static function loadJsFiles($files, $LOCATION = CClientScript::POS_END) {
        foreach ($files as $file) {
            Yii::app()->clientScript->registerScriptFile(self::$_assets_url . '/' . $file, $LOCATION);
        }
    }

    public static function themeUrl($path = '') {
        return self::$_assets_url . "/$path";
    }

    public static function baseUrl($path = '') {
        return Yii::app()->baseUrl . "/$path";
    }

    public static function productImgSrc($img = '', $type = 'thumb') {
        return Yii::app()->baseUrl . "/upload/product_image/$img";
    }
    public static function storelogoSrc($img = '', $type = 'thumb') {
        return Yii::app()->baseUrl . "/upload/logo/$img";
    }

}