<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $data = $params;
?>
<div class="wcp-openweather-forecast-wrapper wp-open-weather-forecast">
    <table class="wcp-openweather-forecast-content" cellspacing="0" cellpadding="0">
        <thead>
            <tr class="wcp-openweather-forecast-header">
                <th class="wcp-openweather-forecast-item-align wcp-openweather-primary-color">Day</th>
                <th class="wcp-openweather-forecast-item-align wcp-openweather-forecast-item-col wcp-openweather-primary-color" colspan="2"><span class="wcp-openweather-hidden-xs">Conditions</span><span class="wcp-openweather-visible-xs">Cond.</span></th>
                <th class="wcp-openweather-primary-color">Temp.</th>
                <th class="wcp-openweather-primary-color">Wind</th>
                <th class="wcp-openweather-primary-color wcp-openweather-forecast-item-hidden-xs">Humidity</th>
                <th class="wcp-openweather-primary-color"><span class="wcp-openweather-hidden-xs">Pressure</span><span class="wcp-openweather-visible-xs">Pres.</span></th> 
            </tr>
        </thead>
        <tbody>
            <?php 
                $atts = array(
                    'count' => $data->getCount(),
                    'index' => 0,
                );
                
                foreach ($data->getAll() as $key => $item) :
                    $atts['item'] = $item;
                    echo RPw_Theme::instance()->getTemplate('shortcode/wcp_weather/forecast-item', $atts);  
                    $atts['index']++;
                endforeach;
            ?>
        </tbody>
    </table>  
</div>
