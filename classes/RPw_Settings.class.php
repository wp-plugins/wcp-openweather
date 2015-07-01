<?php
use Webcodin\WCPOpenWeather\Core\Agp_SettingsAbstract;

class RPw_Settings extends Agp_SettingsAbstract {
    
    private $currentId;
    
    private $currentTag;
    
    /**
     * User Options
     * 
     * @var RPw_UserOptions
     */
    private $userOptions;
    
    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    

    /**
     * Parent Module
     * 
     * @var RPw
     */
    protected static $_parentModule;
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance($parentModule = NULL) {
		if ( is_null( self::$_instance ) ) {
            self::$_parentModule = $parentModule;            
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
     * Constructor 
     * 
     * @param Agp_Module $parentModule
     */
    public function __construct() {
        
        $this->userOptions = RPw_UserOptions::instance();
        
        $config = include ($this->getParentModule()->getBaseDir() . '/config/config.php');        
        
        parent::__construct($config);
    }
    
    public static function renderSettingsPage() {
        
        echo self::getParentModule()->getTemplate('admin/options/layout', self::instance());
    }
    
    public static function renderThemeSettingsPage() {
        
        if (!isset($_REQUEST['tab'])) {
            $theme = self::getParentModule()->getThemeRepository()->getActive();
            if (!empty($theme)) {
                $key = $theme->getSettingsKey();
                if (empty($key)) {
                    $key = 'rpw-theme-default-settings';
                }
                wp_redirect(add_query_arg(array('tab' => $key)));
            }
        }
        
        echo self::getParentModule()->getCurrentTheme()->getTemplate('admin/options/layout', self::getParentModule()->getCurrentTheme()->getSettings());
    }    
    
    public static function getThemesFieldSet() {
        $data = self::$_parentModule->getThemeRepository()->getAll();
        if (!empty($data) and is_array($data)) {
            foreach ($data as $item) {
                $result[$item->getId()] = $item->getName();
            }
        }
        
        return $result;        
    }        
    
    public static function getParentModule() {
       
        return self::$_parentModule;
    }
    
    /**
     * Gets saved or default options
     * 
     * @return array
     */
    public function getOptions() {
        $fields = $this->getFields();        
        
        $result = array();
        if ($this->getTabs()) {        
            foreach ($this->getTabs() as $k => $v) {
                if (!empty($fields[$k])) {
                    $options = get_option( $k );                    
                    foreach ($fields[$k]['fields'] as $dk => $dv) {
                        if (!empty($options)) {
                            if ( isset( $options[$dk] ) ) {
                                $result[$k][$dk] = $options[$dk];                                
                            } elseif ($dv['type'] !== 'checkbox' && isset ( $dv['default'])) {
                                $result[$k][$dk] = $dv['default'];
                            }
                        } else {
                            if ( isset ( $dv['default'] ) ) {
                                $result[$k][$dk] = $dv['default'];
                            }                               
                        }
                    }                    
                }
            }    
        } 
        return $this->getRecursiveCallable( $result );
    }    
    
    /**
     * Sanitize settings
     * 
     * @param array $input
     * @return array
     */
    public function sanitizeSettings($input, $refreshUniqueId = TRUE) {
        $input = parent::sanitizeSettings($input);
        if ($refreshUniqueId) {
            $input['uniqueId'] = uniqid();    
        }
        return $input;
    }
    
    public function getSettingsKeys() {
        $result = array();
        $fields = $this->getFields('global-settings');
        
        if (!empty($fields) && is_array($fields)) {
            foreach ($fields['fields'] as $key => $value) {
                $result[trim(strtolower($key))] = $key;
            }            
            
            $result['enableusersettings'] = 'enableUserSettings';
        }

        return $result;
    }
    
    public function lowerSettings( $data ) {
        $result = array();

        if (isset($data) && is_array($data)) {
            $keys = $this->getSettingsKeys();
            
            foreach ($data as $key => $value) {
                $lowerKey = trim(strtolower($key));
                if (array_key_exists($lowerKey, $keys)) {
                    $result[$lowerKey] = $value;
                } else {
                    $result[$key] = $value;
                }
            }        
        } else {
            $result = $data;
        }
        
        return $result;
    }
    
    public function upperSettings( $data ) {
        $result = array();

        if (isset($data) && is_array($data)) {
            $keys = $this->getSettingsKeys();
            
            foreach ($data as $key => $value) {
                $lowerKey = trim(strtolower($key));
                if (array_key_exists($lowerKey, $keys)) {
                    $result[$keys[$lowerKey]] = $value;
                } else {
                    $result[$key] = $value;
                }
            }        
        } else {
            $result = $data;
        }
        
        return $result;        
    }
    

    public function getUserOptions() {
        return $this->userOptions;
    }
    
    public function getWeatherSettings () {
        return $this->getSettings('global-settings');
    }
    
    public function getPluginSettings () {
        return $this->getSettings('plugin-settings');                
    }

    public function getAPISettings () {
        return $this->getSettings('api-settings');                
    }  
    
    public function getCurrentId() {
        return $this->currentId;
    }

    public function setCurrentId($currentId) {
        $this->currentId = $currentId;
        return $this;
    }
    
    public function getCurrentTag() {
        return $this->currentTag;
    }

    public function setCurrentTag($currentTag) {
        $this->currentTag = $currentTag;
        return $this;
    }


}

