<?php
use Webcodin\WCPOpenWeather\Core\Agp_AjaxAbstract;

class RPw_Ajax extends Agp_AjaxAbstract {
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
     * Refresh Weather Action
     */
    public function weatherRefresh($data) {
        $userOptions = RPw()->getSettings()->getUserOptions()->get($data['id']);        
        if (!empty($userOptions)) {
            echo RPw()->getCurrentTheme()->doShortcode($userOptions, '', $data['tag']);    
        } else {
            echo RPw()->getCurrentTheme()->doShortcode(array('id' => $data['id']), '', $data['tag']);    
        }
    }
    
    /**
     * Refresh Weather Widget Action
     */
    public function weatherWidgetRefresh($data) {
        $userOptions = RPw()->getSettings()->getUserOptions()->get($data['id']);        
        if (!empty($userOptions)) {
            echo RPw()->getCurrentTheme()->doWidget($userOptions, $data['tag']);    
        } else {
            echo RPw()->getCurrentTheme()->doWidget(array('id' => $data['id']), $data['tag']);    
        }
    }    
    
    public function getWCPShortcode($data) {
        $result = array();
        
        $atts = !empty($data['global-settings']) ? $data['global-settings'] : array();
        
        if (!empty($atts)) {
            $keys = RPw()->getSettings()->getSettingsKeys();
            unset($keys['enableusersettings']);
            unset($keys['hideweatherconditions']);
            $atts['id'] = 'wcp_openweather_' . uniqid();
            
            foreach ($keys as $k) {
                if (!array_key_exists($k, $atts)) {
                    $atts[$k] = '';
                }
            }
            
            unset($atts['uniqueId']);

            $s = '';
            foreach ($atts as $key => $value) {
                if (is_string($value)) {
                    $s .= ' ' . $key . '="' . $value . '"';    
                } else {
                    $s .= ' ' . $key . '=' . $value;    
                }
            }

            $result['shortcode'] = '[wcp_weather ' . $s . ']';               
        }
        
        return $result;                    
    }            
}
