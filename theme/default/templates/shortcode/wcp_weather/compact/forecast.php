<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;
    
    $data = $params;
    $template = RPw()->getSettings()->getCurrentTemplatePath();
?>
<div class="wcp-openweather-forecast-wrapper">
    <div class="wcp-openweather-forecast-header wp-open-weather-forecast-header">
        <div class="wcp-openweather-container">
            <?php 
                foreach ($data->getAll() as $key => $item) :
                    echo RPw_Theme::instance()->getTemplate("shortcode/{$template}/forecast-header-item", $item);  
                endforeach;
            ?>
        </div>
    </div>

    <div class="wcp-openweather-forecast-content wp-open-weather-forecast">
        <div class="wcp-openweather-container">
            <?php 
                foreach ($data->getAll() as $key => $item) :
                    $item->hideWeatherConditions = $data->hideWeatherConditions;
                    echo RPw_Theme::instance()->getTemplate("shortcode/{$template}/forecast-item", $item);  
                endforeach;
            ?>
        </div>
    </div>
</div>
