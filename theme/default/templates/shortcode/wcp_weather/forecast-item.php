<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $item = !empty($params['item']) ? $params['item'] : NULL;
    $index = !empty($params['index']) ? $params['index'] : NULL;
    $count = !empty($params['count']) ? $params['count'] : NULL;
    if (!empty($item)) :
?>  
<tr class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block wcp-openweather-primary-background <?php echo ($index % 2 != 0) ? ' wcp-openweather-forecast-item-light' : '';?>">
    <td class="wcp-openweather-forecast-item-align"><span class="wcp-openweather-forecast-item-day"><?php echo date('D', $item->getDay());?></span> <span class="wcp-openweather-forecast-item-date"><?php echo date('M j', $item->getDay());?></span></td>
    <td class="wcp-openweather-forecast-item-align wcp-openweather-forecast-item-icon"><div class="wcp-openweather-forecast-day-icon"><?php echo RPw_Theme::instance()->renderIcon( $item ); ?></div></td>
    <td class="wcp-openweather-forecast-item-align wcp-openweather-forecast-item-status"><span class="wcp-openweather-forecast-day-status"><?php echo $item->getWeatherMain();?></span></td>
    <td><?php echo $item->getTemperature()->day;?>/<?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></td>
    <td><?php echo $item->getWindSpeed();?>, <?php echo $item->getWindDeg();?></td>
    <td class="wcp-openweather-forecast-item-hidden-xs"><?php echo $item->getHumidity();?></td>
    <td class="wcp-openweather-forecast-item-last"><?php echo $item->getPressure();?></td>
</tr>                                   
<?php
    endif;