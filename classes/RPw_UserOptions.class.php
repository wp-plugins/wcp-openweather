<?php

class RPw_UserOptions {
    
    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}    
    
	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
    }    
    
    /**
     * Name
     * 
     * @var string 
     */
    private $name;
    
    /**
     * Expire time
     * 
     * @var int 
     */
    private $expire;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->name = strtolower(get_class($this));
        $this->expire = 86400 * 7; //7 days
    }
    
    private function _normalizeKey ( $key ) {
        if (empty($key)) {
            return '';
        }
        return rawurlencode($key);    
    }
    
    private function _setCookie ($key, $value = array()) {
        $modKey = $this->name . '_' . $this->_normalizeKey($key);
        setcookie($modKey , base64_encode(serialize($value)), time()+$this->expire, '/');                    
        $_COOKIE[$modKey] = base64_encode(serialize($value));
    }

    private function _getCookie ($key) {
        $modKey = $this->name . '_' . $this->_normalizeKey($key);
        if (!empty($_COOKIE[$modKey])) {
            $res = base64_decode(stripslashes($_COOKIE[$modKey]));
            if (!$res) {
                $res = stripslashes($_COOKIE[$modKey]);
            }
            return unserialize($res);
        } else {
            return array();
        }
    }    
    
    public function add ($key, $id, $value) {
        $cookie = $this->_getCookie($key);
        $cookie[$id] = $value;
        $this->_setCookie($key, $cookie);
    }
    
    public function set ($key, $value) {
        $this->_setCookie($key, $value);
    }    
    
    public function get($key) {
        return $this->_getCookie($key);
    }
    
    public function reset($key) {
        $cookie = $this->_getCookie($key);                
        if (!empty($cookie)) {
            $this->_setCookie($key, array());    
        }
    }    
    
    public function exists($key) {
        $cookie = $this->_getCookie($key);                
        return (!empty($cookie[$key]));                    
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }    
    
    public function getExpire() {
        return $this->expire;
    }

    public function setExpire($expire) {
        $this->expire = $expire;
        return $this;
    }
}