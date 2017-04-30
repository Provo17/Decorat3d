<?php
require_once('src/OAuth_io/HttpWrapper.php');
require_once('src/OAuth_io/NotAuthenticatedException.php');
require_once('src/OAuth_io/NotInitializedException.php');
require_once('src/OAuth_io/RequestObject.php');

// use \Requests\Request;

class Injector {
    
    public $session;
    public $config = array(
        'oauthd_url' => 'https://oauth.io',
        'oauthd_base' => '/auth',
        'app_key' => '',
        'app_secret' => ''
    );
    public $ssl_verification;
    private static $instance = null;

    public static function getInstance() {
        if (!is_object(self::$instance)) {
            self::$instance = new Injector();
        }
        return self::$instance;
    }

    public static function setInstance($instance) {
        self::$instance = $instance;
    }


    public function __construct() {
        if (isset($_SESSION)) $this->session = &$_SESSION;
    }
    
    public function getRequest() {
        return new HttpWrapper();
    }
    
    public function getSession() {
        return $this->session;
    }

    public function setSession(&$session) {
    	$this->session = &$session;
    }

}
