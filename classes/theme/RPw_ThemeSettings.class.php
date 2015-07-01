<?php
use Webcodin\WCPOpenWeather\Core\Agp_SettingsAbstract;

class RPw_ThemeSettings extends Agp_SettingsAbstract {

    /**
     * Parent Module
     * 
     * @var Agp_Module
     */
    protected $parentModule;
    
    
    private $settingsKey = '';    
    
    /**
     * Constructor 
     * 
     * @param Agp_Module $parentModule
     */
    public function __construct($parentModule) {
        $this->parentModule = $parentModule;
        $config = include ($this->getParentModule()->getBaseDir() . '/config/config.php');        
        
        parent::__construct($config);
    }
    
    public function renderSettingsPage() {
        echo $this->getParentModule()->getTemplate('admin/options/layout', self::instance());
    }
    
    public function getParentModule() {
        return $this->parentModule;
    }
    
    public function getAllExcludeUserOptions () {
        $config = $this->getConfig();
        if (isset($config->excludeUserOptions)) {
            return $this->objectToArray($config->excludeUserOptions);
        } else {
            return array();
        }
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
     * Register settings
     * 
     * @global string $pagenow
     */
    public function registerSettings () {
        if ($this->getTabs()) {        
            foreach ($this->getTabs() as $key => $value) {
                $function = !empty($value['sanitize']) ? $value['sanitize'] : array($this, 'sanitizeSettings');
                register_setting( $key, $key, $function ); 
            }    
        }    
        
        global $pagenow;
        if($pagenow == 'admin.php' && !empty($_REQUEST['page']) && $_REQUEST['page'] == $this->getPage() && $_REQUEST['tab'] == $this->getSettingsKey() && !empty($_REQUEST['reset-settings'])) {
            $this->resetSettings ();
            wp_redirect(add_query_arg(array('is-reset' => 'true'), remove_query_arg('reset-settings')));
        }
    }    
    

    /**
     * Custom Notices
     * 
     * @global string $pagenow
     */
    public function customAdminNotices() {

        global $pagenow;

        if ( $pagenow == 'admin.php' && isset($_REQUEST['is-reset']) && !isset($_REQUEST['settings-updated']) && $_REQUEST['page'] == $this->getPage() && $_REQUEST['tab'] == $this->getSettingsKey()) {
            $message = 'Settings reset to default values';
            echo '<div class="updated settings-error" id="setting-error-settings_updated"><p><strong>'.$message.'</strong></p></div>';            
        }
    }            
    
    public function getSettingsKey() {
        return $this->settingsKey;
    }

    public function setSettingsKey($settingsKey) {
        $this->settingsKey = $settingsKey;
        return $this;
    }


}

