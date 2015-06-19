<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $data = $params;
    $item = $data->getFirst();
?>
<div class="wcp-openweather-now-wrapper wp-open-weather-now wp-open-weather-block">
    <div class="wcp-openweather-now">
        <div class="wcp-openweather-now-temperature">            
            <span class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </span>            
            <span class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></span>            
        </div>        
    </div>
</div>
