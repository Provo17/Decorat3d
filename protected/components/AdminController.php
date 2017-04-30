<?php

class AdminController extends Controller {

    protected $js_plugins = [];
    public $bodyClass = '';
    public $layout = '//layouts/default';
    public $portlet_color = 'green';
    public $back_button = 'default';
    public $update_button = 'green';
    public $cancel_button = 'default';
    public $save_button = 'green';
    public $add_button = 'green';

    public function init() {
        parent::init();
        Yii::app()->theme = 'admin';
        Yii::app()->setComponents(array(
            "errorHandler" => array(
                "errorAction" => "admin/default/error",
        )));
    }

    public $data = [];

    /*
     * need to add theme css after page specific css
     */

    public function beforeRender($view) {
        //if (parent::beforeAction($action)) {
        $cs = Yii::app()->clientScript;
        /* @var $theme CTheme */
        $theme = Yii::app()->theme;
        $theme_css = [
            ['css' => 'assets/global/css/components.css'],
            ['css' => 'assets/global/css/plugins.css'],
            ['css' => 'assets/admin/layout/css/layout.css'],
            ['css' => 'assets/admin/layout/css/themes/grey.css'],
            ['css' => 'assets/admin/layout/css/custom.css'],
        ];
        foreach ($theme_css as $res) {
            $cs->registerCssFile($theme->getBaseUrl() . '/' . $res['css']);
        }
        return $view;
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $this->registerJsPlugin();
            $this->loadJsPlugin('bootstrap-wysihtml5');
            $this->loadJsPlugin('bootstrap-datepicker');
            $this->loadJsPlugin('bootstrap-colorpicker');
            /* @var $cs CClientScript */
            $cs = Yii::app()->clientScript;
            /* @var $theme CTheme */
            $theme = Yii::app()->theme;
            $cs->registerPackage('jquery');
            $cs->registerPackage('history');
            
            $common_css = [
//['css' => '', 'location'],
                ['css' => 'assets/global/plugins/font-awesome/css/font-awesome.min.css'],
                ['css' => 'assets/global/plugins/simple-line-icons/simple-line-icons.min.css'],
                ['css' => 'assets/global/plugins/bootstrap/css/bootstrap.min.css'],
                ['css' => 'assets/global/plugins/uniform/css/uniform.default.css'],
                ['css' => 'assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'],
                ['css' => 'assets/admin/pages/css/ekko-lightbox.css'],
                 ['css' => 'assets/admin/pages/css/chat.css'],
            ];
            //theme


            $cs->registerCssFile('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
            foreach ($common_css as $res) {
                $cs->registerCssFile($theme->getBaseUrl() . '/' . $res['css']);
            }
            $common_js = [
                //['js' => 'assets/global/plugins/jquery-1.11.0.min.js', 'location' => CClientScript::POS_END,],
                // ['js' => 'assets/global/plugins/jquery-migrate-1.2.1.min.js', 'location' => CClientScript::POS_END,],
                //['js' => 'assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js', 'location' => CClientScript::POS_END,],
                //['js' => 'assets/global/plugins/bootstrap/js/bootstrap.min.js', 'location' => CClientScript::POS_END,],
                //['js' => 'assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/global/plugins/jquery.blockui.min.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/global/plugins/jquery.cokie.min.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/global/plugins/uniform/jquery.uniform.min.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js', 'location' => CClientScript::POS_END,],
                //page plugin
                ['js' => 'assets/global/scripts/metronic.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/admin/layout/scripts/layout.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/admin/layout/scripts/quick-sidebar.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/admin/layout/scripts/demo.js', 'location' => CClientScript::POS_END,],
                ['js' => 'assets/admin/layout/scripts/all.js', 'location' => CClientScript::POS_END,],
                 ['js' => 'assets/admin/pages/scripts/components-pickers.js', 'location' => CClientScript::POS_END,],
                 ['js' => 'assets/admin/pages/scripts/ekko-lightbox.js', 'location' => CClientScript::POS_END,],
                 ['js' => 'assets/admin/pages/scripts/light_box.js', 'location' => CClientScript::POS_END,],
                 ['js' => 'assets/admin/pages/scripts/chat.js', 'location' => CClientScript::POS_END,],
            ];
            foreach ($common_js as $res) {
                $cs->registerScriptFile($theme->getBaseUrl() . '/' . $res['js'], $res['location']);
            }
            $login_js_module = Yii::app()->user->isGuest ? "Login.init();" : "";
            $js = "
                jQuery(document).ready(function() {
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
                ComponentsPickers.init(); // init pickers
                $('.wysihtml5').wysihtml5();//alert();
                $login_js_module
            });";
//            $js = "
//                jQuery(document).ready(function() {
//                Metronic.init(); // init metronic core components
//                Layout.init(); // init current layout
//                QuickSidebar.init(); // init quick sidebar
//                Demo.init(); // init demo features
//                ComponentsPickers.init(); // init pickers
//                $('.wysihtml5').wysihtml5();//alert();
//                $login_js_module
//            });";

            Yii::app()->clientScript->registerScript('init', $js);
            return true;
        }
        return false;
    }

    /*
     * to loading a js plugin
     */

    public function loadJsPlugin($files) {
        $cs = Yii::app()->clientScript;
        /* @var $theme CTheme */
        $theme = Yii::app()->theme;
        if (is_array($files)) {
            $res = $this->js_plugins[$files];
            foreach ($res as $resources) {
                if (isset($resources['js'])) {
                    if (is_array($resources['js'])) {
                        foreach ($resources['js'] as $js) {
                            $cs->registerScriptFile($theme->getBaseUrl() . '/assets/global/plugins/' . $js, CClientScript::POS_END);
                        }
                    } else {
                        $cs->registerScriptFile($theme->getBaseUrl() . '/assets/global/plugins/' . $resources['js'], CClientScript::POS_END);
                    }
                }
                if (isset($resources['css'])) {
                    if (is_array($resources['css'])) {
                        foreach ($resources['css'] as $css) {
                            $cs->registerCssFile($theme->getBaseUrl() . '/assets/global/plugins/' . $css);
                        }
                    } else {
                        $cs->registerCssFile($theme->getBaseUrl() . '/assets/global/plugins/' . $resources['css']);
                    }
                }
            }
        } elseif (isset($this->js_plugins[$files])) {
            $resources = $this->js_plugins[$files];
            if (isset($resources['js'])) {
                if (is_array($resources['js'])) {
                    foreach ($resources['js'] as $js) {
                        $cs->registerScriptFile($theme->getBaseUrl() . '/assets/global/plugins/' . $js, CClientScript::POS_END);
                    }
                } else {
                    $cs->registerScriptFile($theme->getBaseUrl() . '/assets/global/plugins/' . $resources['js'], CClientScript::POS_END);
                }
            }
            if (isset($resources['css'])) {
                if (is_array($resources['css'])) {
                    foreach ($resources['css'] as $css) {
                        $cs->registerCssFile($theme->getBaseUrl() . '/assets/global/plugins/' . $css);
                    }
                } else {
                    $cs->registerCssFile($theme->getBaseUrl() . '/assets/global/plugins/' . $resources['css']);
                }
            }
        }
        return $this;
    }

    public function registerJsPlugin() {
        $this->js_plugins['skg'] = ['js' => ['abv.js'], 'css' => ['ddd.css']]; //example
        $this->js_plugins['jquery-validation'] = ['js' => ['jquery-validation/js/jquery.validate.min.js']];

        $this->js_plugins['bootstrap-wysihtml5'] = ['js' => ['bootstrap-wysihtml5/wysihtml5-0.3.0.js', 'bootstrap-wysihtml5/bootstrap-wysihtml5.js'], 'css' => ['bootstrap-wysihtml5/bootstrap-wysihtml5.css', 'bootstrap-wysihtml5/wysiwyg-color.css']];
        $this->js_plugins['bootstrap-datepicker'] = ['js' => ['bootstrap-datepicker/js/bootstrap-datepicker.js'], 'css' => ['bootstrap-datepicker/css/datepicker.css']];
        $this->js_plugins['bootstrap-colorpicker'] = ['js' => ['bootstrap-colorpicker/js/bootstrap-colorpicker.js'], 'css' => ['bootstrap-colorpicker/css/colorpicker.css']];
        return $this;
    }

    public function loadPageJs($file, $pos = CClientScript::POS_END) {
        $cs = Yii::app()->clientScript;
        /* @var $theme CTheme */
        $theme = Yii::app()->theme;

        $cs->registerScriptFile($theme->getBaseUrl() . '/assets/admin/pages/scripts/' . $file, $pos);
        return $this;
    }

    public function loadPageCss($file) {
        $cs = Yii::app()->clientScript;
        /* @var $theme CTheme */
        $theme = Yii::app()->theme;
        $cs->registerCssFile($theme->getBaseUrl() . '/assets/admin/pages/css/' . $file);
        return $this;
    }

    public function actionError() {
        /* echo json_encode(array(
          'Status' => 500,
          'Message' => 'Unknown error'
          )); */
    }

    public function formateDate($date) {
        return date("j-M-Y", strtotime($date));
    }

    /*
     * due to child module url problem we create this
     */

    public function adminUrl($route, $params = [], $ampersand = '&') {
        $route = "/admin/" . ltrim($route);
        return $this->createUrl($route, $params, $ampersand);
    }

}