<?php
use Webcodin\WCPOpenWeather\Core\Agp_MySqlDb;

class RPw_UserOptions {
    
    /**
     * Database
     * 
     * @var Agp_MySqlDb
     */
    private $db;
    
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
        
        $this->db = new Agp_MySqlDb(DB_HOST, DB_NAME , DB_USER, DB_PASSWORD);
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
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        $data = base64_encode(serialize($value));
        $access = time();
        
        $sql = "REPLACE INTO {$this->tableName} VALUES ('$id', '$key', '$data', '$access')";
        
        $errNo = $this->db->connect();
        if ( $errNo == 0) {
            $this->db->getDb()->query($sql);
            $this->db->disconnect();
        } else {
            $this->db->disconnect();
            throw new Agp_DbConnectException('Cannot establish connection to database.', $errNo);
        }        
    }
    
    private function _getDbCookie ($key) {
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        
        $sql = "SELECT data FROM {$this->tableName} WHERE `id` = '{$id}' AND `key` = '$key'";
        $result = $this->db->execSql($sql);
        
        if (!empty($result[0]['data'])) {
            $data = $result[0]['data'];
            $res = base64_decode(stripslashes($data));
            if (!$res) {
                $res = stripslashes($_COOKIE[$data]);
            }
            return unserialize($res);
        }
    }    
    
    private function _deleteDbCookie ($key) {
        $id = $this->id;
        $key = $this->_normalizeKey($key);
        
        $sql = "DELETE FROM {$this->tableName} WHERE `id` = '{$id}' AND `key` = '$key'";

        $errNo = $this->db->connect();
        if ( $errNo == 0) {
            $this->db->getDb()->query($sql);
            $this->db->disconnect();
        } else {
            $this->db->disconnect();
            throw new Agp_DbConnectException('Cannot establish connection to database.', $errNo);
        }                
    }        


    private function _gcDbCookie () {
        $time = time() - $this->expire;
            
        $sql = "DELETE FROM {$this->tableName} WHERE `access` < '{$time}'";

        $errNo = $this->db->connect();
        if ( $errNo == 0) {
            $this->db->getDb()->query($sql);
            $this->db->disconnect();
        } else {
            $this->db->disconnect();
            throw new Agp_DbConnectException('Cannot establish connection to database.', $errNo);
        }                
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