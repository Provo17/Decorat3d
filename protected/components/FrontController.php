<?php

class FrontController extends Controller {

    public $page_meta_title = "";
    public $page_meta_description = '';
    public $page_meta_keywords = '';
    public $_assetsUrl = '';
    public $settings = [];
    public $selected_lang_flag = '';
    public $parent_slug = '';
    public $child_slug = '';
    public $store_id = '';
    public $store_slug = '';
    public $start = 0; //for price slider
    public $end = 600; //for price slider
    public $step_arr = array();
    public $body_class = 'inner';
    public $isHomePage = FALSE;
    public $oauth;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->layout = '//layouts/default';
        if (isset($_GET['debug'])) {
            echo Yii::app()->request->hostInfo . Yii::app()->request->url . "<br/>";
            // with ALL $_GET-parameters (as mensioned in other answers)
            echo Yii::app()->createUrl(Yii::app()->controller->action->id, $_GET);
            // echo Yii::app()->request->url;
            // exit;
        }
        //START multi lang
        // If there is a post-request, redirect the application to the provided url of the selected language
        if (isset($_GET['language']) && isset($_GET['set-lang'])) {
            $lang = $_GET['language'];
            $MultilangReturnUrl = $_POST[$lang];
            $this->redirect($MultilangReturnUrl);
        }
        // Set the application language if provided by GET, session or cookie
        if (isset($_GET['language'])) {
            Yii::app()->language = $_GET['language'];
            Yii::app()->user->setState('language', $_GET['language']);
            $cookie = new CHttpCookie('language', $_GET['language']);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie;
        } else if (Yii::app()->user->hasState('language'))
            Yii::app()->language = Yii::app()->user->getState('language');
        else if (isset(Yii::app()->request->cookies['language']))
            Yii::app()->language = Yii::app()->request->cookies['language']->value;
        //END multi

        Yii::app()->homeUrl = $this->createAbsoluteUrl('site/index');
        $this->fetchSiteSettings();
        $assets_url = $this->getAssetsUrl();
        Assets::init([
            'assets_url' => $assets_url,
            'theme' => 'frontend',
//            'package_path' => 'vendor',
            'js_path' => 'js',
            'css_path' => 'css',
        ]);
        // Assets::loadCssFile('css/bootstrap.css');
        //load common assets
        //Assets::loadJsFile('js/modernizr.custom.js');
//        Assets::loadPlugin(['bootstrap']);
//        Assets::loadCssFile('css/style.css');
//        Assets::loadCssFile('css/responsive.css');
        // Assets::loadJsFile('js/jquery.sticky.js');
        //Assets::loadPlugin(['toast-message', 'ladda-bootstrap', 'alertify-dialog']);
        //Assets::loadPlugin(['bootstrap-datepicker']);
        //Assets::loadJsFile('js/common.js');
        //set selected_lang_flag url

        $country = ['en' => 'GB', 'da' => 'DK', 'de' => 'DE'];
        $this->selected_lang_flag = Assets::themeUrl("images/en_GB.png");
        if (isset($country[Yii::app()->language])) {
            $img = Yii::app()->language . "_" . $country[Yii::app()->language] . ".png";
            $this->selected_lang_flag = Assets::themeUrl("images/$img");
        }
        require_once('src/OAuth_io/OAuth.php');
        require_once('src/OAuth_io/Injector.php');
        $this->oauth = new OAuth(null, false);
        $this->oauth->initialize('uTbLFyoOaAj7visOTl51Rr-jiWQ', 'suoIVNLrjVnnAr2x_f_jfRNMyD4');
    }

    public function getAssetsUrl() {
        Yii::app()->assetManager->forceCopy = true;

        if ($this->_assetsUrl == '') {
            $this->_assetsUrl = Yii::app()->request->baseUrl . '/themes/frontend/assets'; //Yii::app()->request->baseUrl . '/themes/frontend/assets/';
            //$this->_assetsUrl = Yii::app()->assetManager->publish(dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets');
        }
        //$this->_assetsUrl = Yii::app()->assetManager->publish(dirname(Yii::app()->request->baseUrl) . '/public/themes/frontend/assets/');
        return $this->_assetsUrl;
    }

    function set_page_seo($page_name) {
        $this->page_name = $page_name;
        $seo = Seo::model()->findByAttributes(array("page_name" => $this->page_name, "language_id" => $this->language_id));
        if ($seo != null) {
            $this->page_meta_title = $seo->title;
            $this->page_meta_keywords = $seo->keyword;
            $this->page_meta_description = $seo->description;
        }
    }

    public function fetchSiteSettings() {
        foreach (Settings::model()->findAll() as $setting) {
            $this->settings[strtolower(str_replace(" ", "_", $setting->module))][$setting->slug] = $setting->value;
        }
    }

    public function createMultilanguageReturnUrl($lang = 'en') {
        if (count($_GET) > 0) {
            $arr = $_GET;
            $arr['language'] = $lang;
        }
        else
            $arr = array('language' => $lang);
        return $this->createUrl('', $arr);
    }

    public function socialUrl($slug) {
        if (isset($slug) && $slug) {
            $settingsData = Settings::model()->findByAttributes(['slug' => $slug]);
            if ($settingsData->value != '') {
                return $settingsData->value;
            } else {
                return $settingsData->default;
            }
        }
    }

    public function getCmsContent($slug) {
        if (isset($slug) && $slug) {
            $cmsData = Cms::model()->findByAttributes(['slug' => $slug]);
            $data = [];
            if ($cmsData->slug == 'about_us') {
                $data['title'] = 'ABOUT US';
            } else if ($cmsData->slug == 'faq') {
                $data['title'] = 'FAQ';
            } else if ($cmsData->slug == 'contact_us') {
                $data['title'] = 'Contact Us';
            } else if ($cmsData->slug == 'privacy_policy') {
                $data['title'] = 'Privacy Policy';
            } else if ($cmsData->slug == 'tc') {
                $data['title'] = 'Terms & Conditions';
            } else if ($cmsData->slug == 'how_it_works') {
                $data['title'] = 'How It Works';
            } else if ($cmsData->slug == 'acceptable_use_policy') {
                $data['title'] = 'Acceptable Use Policy';
            }

            $data['content'] = $cmsData->content_en;
            return $data;
        }
    }

    public function getFileExtention($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return $ext;
    }

}
