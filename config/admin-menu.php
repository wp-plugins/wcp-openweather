<?php

return array(
    'wcp-weather-main' => array (
        'page_title' => 'WCP Weather', 
        'menu_title' => 'WCP Weather', 
        'capability' => 'manage_options',
        'function' => array('RPw_Settings', 'renderSettingsPage'),
        'icon_url' => '', 
        'position' => '99', 
        'hideInSubMenu' => TRUE,
        'submenu' => array(
            'wcp-weather' => array(
                'page_title' => 'Settings', 
                'menu_title' => 'Settings', 
                'capability' => 'manage_options',
                'function' => array('RPw_Settings', 'renderSettingsPage'),                         
            ),
        ),        
    ),
);
    