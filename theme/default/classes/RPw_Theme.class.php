<?php
namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

class RPw_Theme extends \RPw_ThemeEntity {

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
	public static function instance($active = FALSE) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self($active);
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
    
    public function __construct($active = FALSE) {
        parent::__construct($active, dirname(dirname(__FILE__)));
        $this->setId('default');
        $this->setName('Default');
        $this->setIsDefaultTheme(TRUE);
        $this->setSettingsKey('rpw-theme-default-settings');
    }
    
    public function init() {
        parent::init();

        if ($this->getActive()) {
            add_action( 'admin_menu', array( $this, 'adminMenu' ), 999 );             
            add_shortcode( 'wcp_weather', array($this, 'doShortcode') ); 
            add_action( 'widgets_init', array($this, 'initWidgets' ) );                    
        }        
    }
    
    public static function getThemeName () {
        return self::$_instance->getName() . ' Theme Settings';
    }
    
    public function initWidgets() {
        register_widget(__NAMESPACE__ . '\RPw_Weather');
        register_widget(__NAMESPACE__ . '\RPw_WeatherMini');
    }        

}