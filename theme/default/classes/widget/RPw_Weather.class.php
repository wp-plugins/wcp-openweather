<?php
namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;

class RPw_Weather extends \WP_Widget {
    
    public $widgetTag = 'wcp_weather_widget';
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'description' => __( "Adds weather to sidebar", 'wcp-openweather-theme') );
		parent::__construct( $this->widgetTag, __('WCP Weather', 'wcp-openweather-theme'), $widget_ops);
	}
    
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if (!empty( $instance['title'])) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        $atts = $instance;
        $atts['id'] = 'wcp-' . $this->id;
        $atts['enableUserSettings'] = !empty($instance['enableUserSettings']) ? 1 : 0;
        $atts['hideWeatherConditions'] = !empty($instance['hideWeatherConditions']) ? 1 : 0;
        if (empty($atts['city_data'])) {
            $atts['city_data'] = '';
        }
        
        echo RPw_Theme::instance()->doWidget($atts, $this->widgetTag);
        
        echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
        $defaults = RPw()->getSettings()->getWeatherSettings();
        
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $city = !empty($instance['city']) ? $instance['city'] : $defaults['city'];
        $city_data = !empty($instance['city_data']) ? $instance['city_data'] : $defaults['city_data'];
        $showCurrentWeather = !empty($instance['showCurrentWeather']) ? 1 : 0;
        $showForecastWeather = !empty($instance['showForecastWeather']) ? 1 : 0;
        $tempUnit = !empty($instance['tempUnit']) ? $instance['tempUnit'] : '';        
        $windSpeedUnit = !empty($instance['windSpeedUnit']) ? $instance['windSpeedUnit'] : '';  
        $pressureUnit = !empty($instance['pressureUnit']) ? $instance['pressureUnit'] : '';  
        $enableUserSettings = !empty($instance['enableUserSettings']) ? 1 : 0;        
        $hideWeatherConditions = !empty($instance['hideWeatherConditions']) ? 1 : 0;        
        $uniqueId = !empty($instance['uniqueId']) ? $instance['uniqueId'] : $defaults['uniqueId'];        
        
    ?>
        <p><?php $this->renderTitleField($title); ?></p>
        <p><?php $this->renderCityField($city); ?></p>
        <p><?php $this->renderCityDataField($city_data); ?></p>
        <p><?php $this->renderTempUnitField($tempUnit); ?></p>        
        <p><?php $this->renderWindSpeedUnitField($windSpeedUnit); ?></p>   
        <p><?php $this->renderPressureUnitField($pressureUnit); ?></p>           
        <p><?php $this->renderShowCurrentWeatherField($showCurrentWeather); ?></p>
        <p><?php $this->renderShowForecastWeatherField($showForecastWeather); ?></p>
        <p><?php $this->renderEnableUserSettingsField($enableUserSettings); ?></p>        
        <p><?php $this->renderHideWeatherConditionsField($hideWeatherConditions); ?></p>                
        <?php $this->renderUniqueIdField($uniqueId); ?>
        <?php $this->initJS();?>
    <?php    
	}
    
    
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags( $new_instance['title'] ) : '';
        $instance['city'] = (!empty($new_instance['city'])) ? strip_tags( $new_instance['city'] ) : '';
        $instance['city_data'] = (!empty($new_instance['city_data'])) ? strip_tags( $new_instance['city_data'] ) : '';
        $instance['showCurrentWeather'] = (!empty($new_instance['showCurrentWeather'])) ? 1 : 0;        
        $instance['showForecastWeather'] = (!empty($new_instance['showForecastWeather'])) ? 1 : 0;        
        $instance['tempUnit'] = (!empty($new_instance['tempUnit'])) ? strip_tags( $new_instance['tempUnit'] ) : '';
        $instance['windSpeedUnit'] = (!empty($new_instance['windSpeedUnit'])) ? strip_tags( $new_instance['windSpeedUnit'] ) : '';
        $instance['pressureUnit'] = (!empty($new_instance['pressureUnit'])) ? strip_tags( $new_instance['pressureUnit'] ) : '';
        $instance['enableUserSettings'] = (!empty($new_instance['enableUserSettings'])) ? 1 : 0;                
        $instance['hideWeatherConditions'] = (!empty($new_instance['hideWeatherConditions'])) ? 1 : 0;                        
        $instance['uniqueId'] = uniqid();
        
		return $instance;
	}    
    
    public function renderTitleField ($title) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title', 'wcp-openweather-theme' ) . ':'; ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">    
    <?php    
    }    
    
    public function renderShowCurrentWeatherField ($showCurrentWeather) {
        $showCurrentWeather = !empty($showCurrentWeather) ? $showCurrentWeather : 1;        
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showCurrentWeather' ); ?>" name="<?php echo $this->get_field_name( 'showCurrentWeather' ); ?>" <?php checked( $showCurrentWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showCurrentWeather' ) ); ?>"><?php _e( 'Show current weather', 'wcp-openweather-theme' ); ?></label>         
    <?php    
    }    
    
    public function renderShowForecastWeatherField ($showForecastWeather) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showForecastWeather' ); ?>" name="<?php echo $this->get_field_name( 'showForecastWeather' ); ?>" <?php checked( $showForecastWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showForecastWeather' ) ); ?>"><?php _e( 'Show 5 day forecast', 'wcp-openweather-theme' ); ?></label>         
    <?php    
    }        
    
    public function renderCityField ($city) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>"><?php echo __( 'City', 'wcp-openweather-theme' ) . ':'; ?></label> 
		<input class="widefat rpw-gm-city" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>">    
        <p class="description"><?php _e('You can find you city name on <a href="http://www.openweathermap.com/" title="http://www.openweathermap.com/" target="_blank">www.openweathermap.com</a>.', 'wcp-openweather-theme'); ?></p>
    <?php    
    }        
    
    public function renderCityDataField ($city_data) {
    ?>
        <input class="widefat rpw-gm-city-data" id="<?php echo $this->get_field_id( 'city_data' ); ?>" name="<?php echo $this->get_field_name( 'city_data' ); ?>" type="hidden" value="<?php echo esc_attr( $city_data ); ?>">    
    <?php    
    }            
    
    public function renderTempUnitField ($tempUnit) {
        $tempList = RPw()->getSettings()->getFieldSet('temp');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['tempUnit'];
        $tempUnit = !empty($tempUnit) ? $tempUnit : $default;
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>"><?php echo __( 'Temperature', 'wcp-openweather-theme' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>" class="temperature-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'tempUnit' ) ); ?>">
        <?php 
            foreach ( $tempList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $tempUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }            
    
    public function renderWindSpeedUnitField ($windSpeedUnit) {
        $windSpeedUnitList = RPw()->getSettings()->getFieldSet('windSpeed');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['windSpeedUnit'];
        $windSpeedUnit = !empty($windSpeedUnit) ? $windSpeedUnit : $default;        
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>"><?php echo __( 'Wind Speed', 'wcp-openweather-theme' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>" class="windspeed-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'windSpeedUnit' ) ); ?>">
        <?php 
            foreach ( $windSpeedUnitList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $windSpeedUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }                
    
    public function renderPressureUnitField ($pressureUnit) {
        $pressureUnitList = RPw()->getSettings()->getFieldSet('pressure');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['pressureUnit'];
        $pressureUnit = !empty($pressureUnit) ? $pressureUnit : $default;                
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>"><?php echo __( 'Pressure', 'wcp-openweather-theme' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>" class="pressure-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'pressureUnit' ) ); ?>">
        <?php 
            foreach ( $pressureUnitList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );    
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $pressureUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }                    
    
    public function renderEnableUserSettingsField ($enableUserSettings) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'enableUserSettings' ); ?>" name="<?php echo $this->get_field_name( 'enableUserSettings' ); ?>" <?php checked( $enableUserSettings ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'enableUserSettings' ) ); ?>"><?php _e( 'Enable user settings', 'wcp-openweather-theme' ); ?></label>         
    <?php    
    }     

    public function renderHideWeatherConditionsField ($hideWeatherConditions) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'hideWeatherConditions' ); ?>" name="<?php echo $this->get_field_name( 'hideWeatherConditions' ); ?>" <?php checked( $hideWeatherConditions ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'hideWeatherConditions' ) ); ?>"><?php _e( 'Hide description of the weather conditions', 'wcp-openweather-theme' ); ?></label>         
    <?php    
    }         
    
    public function renderUniqueIdField ($uniqueId) {
    ?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'uniqueId' ); ?>" name="<?php echo $this->get_field_name( 'uniqueId' ); ?>" type="hidden" value="<?php echo esc_attr( $uniqueId ); ?>">    
    <?php    
    }    
    
    public function initJS() {
    ?>
    <script>
        (function($) {  
            $('.rpw-gm-city').focus(function() {
                $('.pac-container').css('z-index', '10000');    
            });

            var options = {
              types: ['(cities)']
            };            
            
            $('.rpw-gm-city').each(function() {
            if (typeof this.rpwOwner == 'undefined') {
                $(this).on('change', function() {
                    $(this).closest('form').find('.rpw-gm-city-data').val('');
                });
                var autocomplete = new google.maps.places.Autocomplete($(this).get(0), options);           
                autocomplete.rpwOwner = this;
                this.rpwOwner = autocomplete;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    if (place.address_components) {
                        city = ''; city_short = '';
                        country = ''; country_short = '';
                        state = ''; state_short = '';
                        
                        for (var i = 0; i < place.address_components.length; i++) {
                            var component = place.address_components[i];
                            if (!city && ($.inArray('locality', component.types) != -1 || $.inArray('administrative_area_level_3', component.types) != -1)) {
                                city = component.long_name;    
                                city_short = component.short_name;    
                            }
                            if ($.inArray('administrative_area_level_1', component.types) != -1) {
                                state = component.long_name;    
                                state_short = component.short_name;    
                            }                            
                            if ($.inArray('country', component.types) != -1) {
                                country = component.long_name;    
                                country_short = component.short_name;    
                            }
                        }
                        
                        $(autocomplete.rpwOwner).closest('form').find('.rpw-gm-city-data').val('');                        
                        
                        if (city) {
                            full_name = city;
                            short_name = city;
                            
                            city_data = 'city=' + city + '&city_short='+city_short;
                            
                            if (state) {
                                full_name = full_name + ', ' + state;
                                city_data = city_data + '&state=' + state + '&state_short='+state_short;
                            }                                                        
                            
                            if (country) {
                                full_name = full_name + ', ' + country;
                                short_name = short_name + ', ' + country_short;
                                city_data = city_data + '&country=' + country + '&country_short='+country_short;
                            }

                            city_data = city_data + '&full_name=' + full_name;
                            city_data = city_data + '&short_name=' + short_name;
                            city_data = city_data + '&lat=' + place.geometry.location.lat();
                            city_data = city_data + '&lng=' + place.geometry.location.lng();
                            
                            $(autocomplete.rpwOwner).val(full_name);
                            $(autocomplete.rpwOwner).closest('form').find('.rpw-gm-city-data').val(city_data);
                        }                                   
                    }
                });                
            }

        });  

        })(jQuery);
    </script>     
    <?php
    }
    
}

    