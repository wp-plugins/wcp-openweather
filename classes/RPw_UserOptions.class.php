<?php
use Webcodin\WCPOpenWeather\Core\Agp_MySqlDb;

class RPw_UserOptions {
    
    /**
     * Table Name
     * 
     * @var string
     */
    private $tableName;
    
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
     * Unique databse Id
     * 
     * @var string
     */
    private $id;
    
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
        global $wpdb;
        
        $this->tableName = $wpdb->prefix . "wcp_useroptions";
            
        $this->expire = 86400 * 7; //7 days by default
    }
    
    public function init() {
        $modKey = 'wcp_useroptions_id';
        if (!empty($_COOKIE[$modKey])) {
            $this->id = stripslashes($_COOKIE[$modKey]);
        }
        if (empty($this->id)) {
            $this->id = $this->_getUniqueID();
        }
        setcookie($modKey , $this->id, time() + $this->expire, '/');                    
        $_COOKIE[$modKey] = $this->id;   
        
        $this->_gcDbCookie();
    }
    
    private function _getUniqueID () {
        return uniqid(md5(rand()), true);
    }
    
    private function _setDbCookie ($key, $value = array()) {
        global $wpdb;
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        $data = base64_encode(serialize($value));
        $access = time();
        
        $sql = "REPLACE INTO {$this->tableName} VALUES ('$id', '$key', '$data', '$access')";
        
        $wpdb->query($sql);
    }
    
    private function _getDbCookie ($key) {
        global $wpdb;
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        
        $sql = "SELECT data FROM {$this->tableName} WHERE `id` = '{$id}' AND `key` = '$key'";
        $result = $wpdb->get_row($sql, ARRAY_A);
        
        if (!empty($result['data'])) {
            $data = $result['data'];
            $res = base64_decode(stripslashes($data));
            if (!$res) {
                $res = stripslashes($_COOKIE[$data]);
            }
            return unserialize($res);
        }
    }    
    
    private function _deleteDbCookie ($key) {
        global $wpdb;
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        
        $sql = "DELETE FROM {$this->tableName} WHERE `id` = '{$id}' AND `key` = '$key'";

        $wpdb->query($sql);     
    }        


    private function _gcDbCookie () {
        global $wpdb;
        $time = time() - $this->expire;
            
        $sql = "DELETE FROM {$this->tableName} WHERE `access` < '{$time}'";

        $wpdb->query($sql);        

    }            
    
    private function _normalizeKey ( $key ) {
        if (empty($key)) {
            return '';
        }
        return rawurlencode($key);    
    }
    
    public function add ($key, $id, $value) {
        $cookie = $this->_getDbCookie($key);
        $cookie[$id] = $value;
        $this->_setDbCookie($key, $cookie);
    }
    
    public function set ($key, $value) {
        $this->_setDbCookie($key, $value);
    }    
    
    public function get($key) {
        return $this->_getDbCookie($key);
    }
    
    public function reset($key) {
        $this->_deleteDbCookie($key);                
    }    
    
    public function exists($key) {
        $cookie = $this->_getDbCookie($key);                
        return (!empty($cookie[$key]));                    
    }
    
    public function getExpire() {
        return $this->expire;
    }

    public function setExpire($expire) {
        $this->expire = $expire;
        return $this;
    }
    
    public function getId() {
        return $this->id;
    }


}