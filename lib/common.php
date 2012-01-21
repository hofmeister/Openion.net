<?php

/** Config Wrapper **/

global $config;

function conf($name,$default = null) {
    global $config;
    if (!$config)
        $config = parse_ini_file(BASEDIR."config/config.ini",true);
    $parts = preg_split('/\./',$name);
    
    if (count($parts) == 1)
        $out = $config[$parts[0]];
    else
        $out = $config[$parts[0]][$parts[1]];
    
    
    if (!$out)
        return $default;
    return $out;
}

/** CouchDB Wrapper **/

class DbManager {
    private static $instance;
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DbManager();
        }
        return self::$instance;
    }
    
    private $_users;
    private $_votes;
    private $_bills;
    
    private function init($name) {
        $dbName = "_$name";
        if (!$this->$dbName) {
            $db = new Sag(conf("couchdb.host","localhost"),conf("couchdb.host",5984));
            $username = conf("couchdb.username");
            if ($username)
                $db->login(conf("couchdb.username"),conf("couchdb.password"));
            $db->setDatabase(conf("couchdb.{$name}_name","openion_{$name}"),true);
            $this->$dbName = $db;
        }
    }
    
    /**
     *
     * @return Sag
     */
    public function users() {
        $this->init('users');
        return $this->_users;
    }

    /**
     *
     * @return Sag
     */
    public function votes() {
        $this->init('votes');
        return $this->_votes;
    }

    /**
     *
     * @return Sag
     */
    public function bills() {
        $this->init('bills');
        return $this->_bills;
    }
}

/**
 *
 * @return DbManager
 */
function db() {
    return DbManager::getInstance();
}


/** Localization wrapper **/

class Locale {
    public static $instance;
    
    private $messages = array();
    private $ids = array();
    public function __construct() {
        $this->ids = func_get_args();
    }
    
    public function add($message,$translation) {
        $this->messages[$message] = $translation;
    }
    
    public function get($message) {
        $args = func_get_args();
        array_shift($args);
        if ($this->messages[$message])
            $message = $this->messages[$message];
        return vsprintf($message,$args);
    }
}


if (!function_exists("_")) {
    function _($msg) {
        if (Locale::$instance)
            return Locale::$instance->get($msg);
        return $msg;
    }
}

/** Simple view methods **/
function render($viewName,$data) {
    include BASEDIR.'views/'.preg_replace('/[^A-Z0-9_\-]/i','',$viewName).".php";
}
/** simple routing **/

function url($url) {
    return "//".$_SERVER['HTTP_HOST'].'/'.Slim_Http_Uri::getBaseUri().$url;
}
function redirect($url) {
    header("Location: ".url($url));
}
/** facebook wrapper **/
global $FBAPI;
/**
 *
 * @global Facebook $FBAPI
 * @return Facebook 
 */
function fb() {
    global $FBAPI;
    if (!$FBAPI) {
        $FBAPI = new Facebook(array(
          'appId'  => conf('facebook.appId'),
          'secret' => conf('facebook.secret'),
        ));
    }
    
    return $FBAPI;
}

/** Session handling functions **/

function user() {
    return fb()->getUser();
}
function is_loggedin() {
    $userId = user();
    return $userId != null;
}

function is_admin() {
    return false;
}