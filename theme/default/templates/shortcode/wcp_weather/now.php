<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $data = $params;
    $item = $data->getFirst();
?>
 
<!--<div class="wcp-openweather-now-wrapper">-->
    <td class="wcp-openweather-now-icon-wrapper">
        <div class="wcp-openweather-now-icon">
            <?php echo RPw_Theme::instance()->renderIcon( $item ); ?>
        </div>
    </td>
    <td class="wcp-openweather-now-temperature-wrapper">
        <span class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </span>
        <span class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></span>                
    </td>
</tr>
<!--</div>-->
<tr>
    <td colspan="3">
        <div class="wcp-openweather-now-details">
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title">Wind</span>            
                    <span class="wcp-openweather-now-details-value"><?php echo $item->getWindSpeed();?>, <?php echo $item->getWindDeg();?></span>
                </div>
            </div>
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title">Humidity</span>
                    <span class="wcp-openweather-now-details-value"><?php echo $item->getHumidity();?></span>
                </div>
            </div>
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title">Pressure</span>
                    <span class="wcp-openweather-now-details-value"><?php echo $item->getPressure();?></span>
                </div>
            </div>
        </div>
    </td>

        

