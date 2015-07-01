<?php
return array(
    'global-settings' => array(
        'sections' => array(
            'location' => array(
                'label' => 'Location',
            ),            
            'units' => array(
                'label' => 'Units',
                'class' => 'wcp-openweather-settings-units',
            ),
            'options' => array(
                'label' => 'Display options',
                'class' => 'wcp-openweather-settings-options',
            ),
        ),
        'fields' => array(
            'uniqueId' => array(
                'label' => 'Unique ID',            
                'type' => 'hidden',                        
                'default' => '55780f7e18fca',
                'section' => 'location',
                'class' => 'widefat',
                'note' => '',
            ),                                    
            'city' => array(
                'label' => 'City Name',            
                'type' => 'city',                        
                'default' => '',
                'section' => 'location',
                'class' => 'widefat rpw-gm-city',
                'wrapper_class' => '',
                'note' => 'You can find you city name on <a href="http://www.openweathermap.com/" title="http://www.openweathermap.com/" target="_blank">www.openweathermap.com</a>.',
            ),                        
            'tempUnit' => array(
                'type' => 'select',
                'label' => 'Temperature',
                'fieldSet' => 'temp',
                'default' => 'c',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),
            'windSpeedUnit' => array(
                'type' => 'select',
                'label' => 'Wind Speed',
                'fieldSet' => 'windSpeed',
                'default' => 'ms',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),
            'pressureUnit' => array(
                'type' => 'select',
                'label' => 'Pressure',
                'fieldSet' => 'pressure',
                'default' => 'mmHg',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),      
            'showCurrentWeather' => array(
                'type' => 'checkbox',
                'label' => 'Show current weather',
                'default' => 1,
                'section' => 'options',
                'class' => '',
            ),              
            'showForecastWeather' => array(
                'type' => 'checkbox',
                'label' => 'Show 5 day forecast',
                'default' => '',
                'section' => 'options',
                'class' => '',
            ),                          
        ),
    ),
    'plugin-settings' => array(
        'sections' => array(
            'options' => array(
                'label' => 'Options',
            ),
        ),   
        'fields' => array(        
            'enableUserSettings' => array(
                'label' => 'Enable User Options',            
                'type' => 'checkbox',                        
                'default' => '',
                'section' => 'options',
                'class' => '',
            ),
            'expireUserSettings' => array(
                'label' => 'Expire User Options (days)',
                'type' => 'number',                        
                'default' => '30',
                'section' => 'options',
                'class' => 'widefat',
                'note' => '',       
                'atts' => array(
                    'min' => 0,
                ),                                
            ),
            'refreshPeriod' => array(
                'type' => 'select',
                'label' => 'Refresh time',
                'fieldSet' => 'refreshPeriod',
                'default' => '0',
                'section' => 'options',
                'class' => 'widefat regular-select',
            ),
            'theme' => array(
                'type' => 'select',
                'label' => 'Current Theme',
                'fieldSet' => 'theme',
                'default' => 'default',
                'section' => 'options',
                'class' => 'widefat regular-select',
                'note' => '',
            ),            
        ),
    ),
    'api-settings' => array(
        'fields' => array(        
            'appid' => array(
                'label' => 'API key',            
                'type' => 'text',                        
                'default' => '',
                'class' => 'widefat',
                'note' => 'How to get API key you can see <a href="http://openweathermap.org/appid" title="http://openweathermap.org/appid" target="_blank">here</a>.',
            ),
//            'lang' => array(
//                'label' => 'Language',            
//                'type' => 'text',                        
//                'default' => 'en',
//                'class' => 'widefat',
//                'note' => 'Languages that you can use with the corresponded lang values:<br/> English - en, Russian - ru, Italian - it, Spanish - es (or sp), Ukrainian - uk (or ua), German - de, Portuguese - pt, Romanian - ro, Polish - pl, Finnish - fi, Dutch - nl, French - fr, Bulgarian - bg, Swedish - sv (or se), Chinese Traditional - zh_tw, Chinese Simplified - zh (or zh_cn), Turkish - tr, Croatian - hr, Catalan - ca ',                
//            ),
        ),        
    ),
);