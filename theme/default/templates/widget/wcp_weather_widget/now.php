<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $data = $params;
    $item = $data->getFirst();
?>
<div class="wcp-openweather-now-wrapper wp-open-weather-now wp-open-weather-block">
    <div class="wcp-openweather-now">
        <div class="wcp-openweather-now-temperature">
            <span class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </span>
            <div class="wcp-openweather-now-icon">
                <?php echo RPw_Theme::instance()->renderIcon( $item ); ?> 
            </div>
        </div>
        <span class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></span>
    </div>
    <div class="wcp-openweather-now-details">
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-wind"></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getWindSpeed();?>, <?php echo $item->getWindDeg();?></span>
        </div>
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-raindrop"></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getHumidity();?></span>
        </div>
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-arrow-down"><span class="wcp-ow-icon-arrow-down"></span></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getPressure();?></span>
        </div>           
    </div>
</div>
