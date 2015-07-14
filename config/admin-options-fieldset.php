<?php
return array(
    'temp' => array(
        'c' => __('&deg;C', 'wcp-openweather'),
        'f' => __('&deg;F', 'wcp-openweather'),
    ),
    'windSpeed' => array(
        'mph' => __('mph', 'wcp-openweather'),
        'kmh' => __('km/h', 'wcp-openweather'),
        'ms' => __('m/s', 'wcp-openweather'),
        'Knots' => __('Knots', 'wcp-openweather'),
    ),
    'pressure' => array(
        'atm' => __('atm', 'wcp-openweather'),
        'bar' => __('bar', 'wcp-openweather'),
        'hPa' => __('hPa', 'wcp-openweather'),
        'kgfcm2' => __('kgf/cm²', 'wcp-openweather'),
        'kgfm2' => __('kgf/m²', 'wcp-openweather'),
        'kPa' => __('kPa', 'wcp-openweather'),
        'mbar' => __('mbar', 'wcp-openweather'),
        'mmHg' => __('mmHg', 'wcp-openweather'),
        'inHg' => __('inHg', 'wcp-openweather'),
        'Pa' => __('Pa', 'wcp-openweather'),
        'psf' => __('psf', 'wcp-openweather'),
        'psi' => __('psi', 'wcp-openweather'),
        'torr' => __('torr', 'wcp-openweather'),
    ),
    'refreshPeriod' => array (
        '0' => __('Always', 'wcp-openweather'),
        '1800' => __('0.5h - Not Recommended', 'wcp-openweather'),
        '3600' => __('1h - Recommended', 'wcp-openweather'),
        '7200' => __('2h', 'wcp-openweather'),        
        '10800' => __('3h', 'wcp-openweather'),
        '21600' => __('6h', 'wcp-openweather'),
        '32400' => __('9h', 'wcp-openweather'),
        '43200' => __('12h', 'wcp-openweather'),
        '86400' => __('24h', 'wcp-openweather')
    ),
    'theme' => array('RPw_Settings', 'getThemesFieldSet'),
    'lang' => array('RPw_Settings', 'getLanguages'),
    'languages' => array(
        'en_US' => __('English (United States)', 'wcp-openweather'),
        'ru_RU' => __('Russian (Russia)', 'wcp-openweather'),
        'uk_UA' => __('Ukrainian (Ukraine)', 'wcp-openweather'),
//        'fr_FR' => __('French (France)', 'wcp-openweather'),
//        'de_DE' => __('German (Germany)', 'wcp-openweather'),
    ),
    'dayofweeks' => array (
        __('mon', 'wcp-openweather'),
        __('tue', 'wcp-openweather'),
        __('wed', 'wcp-openweather'),
        __('thu', 'wcp-openweather'),
        __('fri', 'wcp-openweather'),
        __('sat', 'wcp-openweather'),
        __('sun', 'wcp-openweather'),
    ),
    'months' => array (
        __('jan', 'wcp-openweather'),
        __('feb', 'wcp-openweather'),
        __('mar', 'wcp-openweather'),
        __('apr', 'wcp-openweather'),
        __('may', 'wcp-openweather'),
        __('jun', 'wcp-openweather'),
        __('jul', 'wcp-openweather'),
        __('aug', 'wcp-openweather'),
        __('sep', 'wcp-openweather'),
        __('oct', 'wcp-openweather'),
        __('nov', 'wcp-openweather'),
        __('dec', 'wcp-openweather'),
    ),    
);