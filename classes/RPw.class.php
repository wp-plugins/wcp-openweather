<?php
use Webcodin\WCPOpenWeather\Core\Agp_Module;
use Webcodin\WCPOpenWeather\Core\Agp_Autoloader;

class RPw extends Agp_Module {
    
    /**
     * Api Object
     * 
     * @var RPw_OpenWeather
     */
    private $api;

    /**
     * Ajax Object
     * 
     * @var RPw_Ajax
     */
    private $ajax;    
    
    /**
     * Settings
     * 
     * @var RPw_Settings
     */
    private $settings;
    
    
    /**
     * Themes collection
     * 
     * @var RPw_ThemeRepository
     */
    private $themeRepository;
        
    
    /**
     * Current theme entity
     * 
     * @var RPw_ThemeEntity
     */
    private $currentTheme;
    
    private $defaultThemeName = 'default';
    
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
    
    public function __construct() {
        parent::__construct(dirname(dirname(__FILE__)));
        
        $this->ajax = RPw_Ajax::instance();   
        $this->settings = RPw_Settings::instance( $this );
        $this->api = new RPw_OpenWeather();
        $this->themeRepository = RPw_ThemeRepository::instance();
        
        add_action( 'init', array($this, 'init' ), 999 );        
        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ) );    
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts' ));                    
        $this->registerThemes();
    }
    
    public function init () {
        $pluginSettings = RPw()->getSettings()->getPluginSettings();
        if (isset($pluginSettings['expireUserSettings'])) {
            $this->settings->getUserOptions()->setExpire($pluginSettings['expireUserSettings'] * 86400);
        }
        $this->processRequest();
    }
    
    public function registerThemes () {
        //include inline themes
        $inline_theme = $this->settings->getConfig()->inline_theme;
        foreach ($inline_theme as $namespace => $file) {
            if (file_exists($this->getBaseDir() . $file) && is_file($this->getBaseDir() . $file)) {
                require_once ($this->getBaseDir() . $file);                    
            }
        }


        $pluginSettings = $this->getSettings()->getPluginSettings();        
        $currentThemeId = (!empty($pluginSettings['theme'])) ? $pluginSettings['theme'] : $this->defaultThemeName;                
        
        //register all themes
        $classMap = Agp_Autoloader::instance()->getClassMap();
        if (!empty($classMap['namespaces']) && is_array($classMap['namespaces'])) {
            foreach ($classMap['namespaces'] as $key => $value) {
                $themeClass = $key . '\RPw_Theme';
                if (class_exists($themeClass)) {
                    $obj = $themeClass::instance();
                    if ($obj->getId() == $currentThemeId) {
                        $obj->setActive(TRUE);    
                        $this->currentTheme = $obj;
                    }
                    $obj->init();
                    $this->themeRepository->add($obj);
                }
            }
            $this->themeRepository->moveDefaultToFirst();
        }

        if (empty($this->currentTheme)) {
            $this->currentTheme = $this->themeRepository->findById( $this->defaultThemeName );    
            $this->currentTheme->setActive(TRUE);
            $this->currentTheme->init();
        }
        
        if (!empty($pluginSettings['theme'])) {
            if ($pluginSettings['theme'] != $currentThemeId) {
                $options = get_option( 'plugin-settings' );                
                $options['theme'] = $currentThemeId;
                update_option('plugin-settings', $options);
                $this->settings->refreshConfig();
            }
        }
    }
    
    public function processRequest() {
        if (!is_admin()) {
            
            if ( !empty($_REQUEST['reset-settings'])) {
                $id = trim($_REQUEST['reset-settings']);
                $this->settings->getUserOptions()->reset($id);    
                $this->api->getSession()->reset($id);
                wp_redirect(remove_query_arg('reset-settings'));
                exit();
            }

            if ( !empty($_POST['action']) && $_POST['action'] = 'setUserOptions' 
                && !empty($_POST['id']) && !empty($_POST['global-settings']) ) {
                $data = $_POST['global-settings'];
                $data['id'] = $_POST['id'];
                
                $data = $this->settings->sanitizeSettings($data, FALSE);
                $this->settings->getUserOptions()->set($data['id'], $data);
                $this->api->getSession()->reset($data['id']);
            }            
        }
    }
    
    public function enqueueScripts () {
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );            
        wp_enqueue_script('colorbox-js', $this->getAssetUrl() . '/libs/colorbox/jquery.colorbox-min.js',array('jquery'));
        wp_enqueue_style('colorbox-css', $this->getAssetUrl() . '/libs/colorbox/colorbox.css');        
        
        wp_enqueue_script( 'iris', $this->getAssetUrl('libs/iris/iris.min.js'), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
        
        wp_enqueue_script( 'rpw-gm', 'https://maps.googleapis.com/maps/api/js?libraries=places&v=3.20&language=en' );            
        
        wp_enqueue_script( 'rpw', $this->getAssetUrl('js/main.js'), array('jquery', 'rpw-gm', 'iris') );  
        wp_localize_script( 'rpw', 'ajax_rpw', array( 
            'base_url' => site_url(),         
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'ajax_nonce' => wp_create_nonce('ajax_atf_nonce'),        
        ));  
        
        wp_enqueue_style( 'rpw-css', $this->getAssetUrl('css/style.css') ); 
    }        
    
    public function enqueueAdminScripts () {
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );            
        
        wp_enqueue_script( 'rpw-gm', 'https://maps.googleapis.com/maps/api/js?libraries=places&v=3.20&language=en' );            
        
        wp_enqueue_script( 'rpw', $this->getAssetUrl('js/admin.js'), array('jquery', 'rpw-gm') );                                                         
        wp_enqueue_style( 'rpw-css', $this->getAssetUrl('css/admin.css'));  
        
        
    }    
    
    
    public function getSettingsById ($id = 'default-weather-id', $atts = NULL ) {
        $userOptions = $this->settings->getUserOptions()->get($id);        
        
        if (!isset($atts) && !empty($userOptions)) {
            return $userOptions;
        }
        
        $plugin = $this->settings->getPluginSettings();
        
        $defaults = $this->settings->getWeatherSettings() ;
        $defaults = $this->settings->lowerSettings($defaults);
        $defaults['id'] = $id;
        
        if (isset($atts) && is_array($atts)) {
            $atts = $this->settings->lowerSettings($atts);
            if (!empty($atts['uniqueid'])) {
                $defaults['uniqueid'] = $atts['uniqueid'];        
            }
        }
        
        $enableUserSettings = 0;
        if (isset($atts['enableusersettings'])) {
            $enableUserSettings = $atts['enableusersettings'];
        } else {
            if (!empty($plugin['enableUserSettings'])) : 
                $enableUserSettings = 1;
            endif;                            
        }
                
        if (empty($userOptions['uniqueId']) 
            || $userOptions['uniqueId'] != $defaults['uniqueid']
            || empty($enableUserSettings) && isset($atts)
        ) {
            $this->settings->getUserOptions()->reset($id);
            $this->api->getSession()->reset($id);
            $userOptions = NULL;
        }
        
        if (!empty($userOptions)) {
            $atts = $userOptions;
        } else {
            if (!empty($atts) && is_array($atts)) {
                $atts = array_merge( $defaults, $atts );    
            } else {
                $atts = $defaults;
            }
            
            $atts = $this->settings->upperSettings($atts);
        
            $this->settings->getUserOptions()->set($id, $atts);            
        }        

        $atts['enableUserSettings'] = $enableUserSettings;
        
        return $atts;
    }
    
    public function getWeatherById($id) {
        $result = array();
        $api = $this->settings->getAPISettings();
        $settings = $this->getSettingsById($id);
        if (!empty($settings['city'])) {
            //RPw::debug($settings['city']);
            $city = stripslashes(str_replace('  ',' ', str_replace(', ', ',', $settings['city'])));
            $city = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($city));
            //RPw::debug($city);
            $this->api->addRequestParam('q', $city);        
            
            if (!empty($api['appid'])) {
                $this->api->addRequestParam('APPID', $api['appid']);
            }
            if (!empty($api['lang'])) {
                $this->api->addRequestParam('lang', $api['lang']);
            }    

            $this->api->setCurrentSessionId($id);
            
            if (!empty($settings['showCurrentWeather'])) {
                $weather = $this->api->getWeather();
                if (!empty($weather) && $weather->getCount() > 0) {
                    $weather->applySettings($settings);
                    $weather->applyThemeUrl($this->getCurrentTheme()->getAssetUrl());
                    $result['weather'] = $weather;
                }          
            }        

            if (!empty($settings['showForecastWeather'])) {
                $forecast = $this->api->getDailyForecast(5);
                if (!empty($forecast) && $forecast->getCount() > 0) {
                    $forecast->applySettings($settings);
                    $result['forecast'] = $forecast;
                }          
            } 
        }        
        
        return $result;
    }
    
    public function getApi() {
        return $this->api;
    }

    public function getAjax() {
        return $this->ajax;
    }

    public function getSettings() {
        return $this->settings;
    }

    public function getThemeRepository() {
        return $this->themeRepository;
    }

    public function getCurrentTheme() {
        return $this->currentTheme;
    }

    public function getDefaultThemeName() {
        return $this->defaultThemeName;
    }
}