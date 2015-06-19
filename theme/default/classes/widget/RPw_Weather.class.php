<?php
namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

use Webcodin\WCPOpenWeather\Theme\DefaultTheme\RPw_Theme;

class RPw_Weather extends \WP_Widget {
    
    public $widgetTag = 'wcp_weather_widget';
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'description' => __( "Adds weather to sidebar") );
		parent::__construct( $this->widgetTag, __('WCP Weather'), $widget_ops);
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
        $city = !empty($instance['city']) ? $instance['city'] : '';
        $showCurrentWeather = !empty($instance['showCurrentWeather']) ? 1 : 0;
        $showForecastWeather = !empty($instance['showForecastWeather']) ? 1 : 0;
        $tempUnit = !empty($instance['tempUnit']) ? $instance['tempUnit'] : '';        
        $windSpeedUnit = !empty($instance['windSpeedUnit']) ? $instance['windSpeedUnit'] : '';  
        $pressureUnit = !empty($instance['pressureUnit']) ? $instance['pressureUnit'] : '';  
        $enableUserSettings = !empty($instance['enableUserSettings']) ? 1 : 0;        
        $uniqueId = !empty($instance['uniqueId']) ? $instance['uniqueId'] : $defaults['uniqueId'];        
        
    ?>
        <p><?php $this->renderTitleField($title); ?></p>
        <p><?php $this->renderCityField($city); ?></p>
        <p><?php $this->renderTempUnitField($tempUnit); ?></p>        
        <p><?php $this->renderWindSpeedUnitField($windSpeedUnit); ?></p>   
        <p><?php $this->renderPressureUnitField($pressureUnit); ?></p>           
        <p><?php $this->renderShowCurrentWeatherField($showCurrentWeather); ?></p>
        <p><?php $this->renderShowForecastWeatherField($showForecastWeather); ?></p>
        <p><?php $this->renderEnableUserSettingsField($enableUserSettings); ?></p>        
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
        $instance['showCurrentWeather'] = (!empty($new_instance['showCurrentWeather'])) ? 1 : 0;        
        $instance['showForecastWeather'] = (!empty($new_instance['showForecastWeather'])) ? 1 : 0;        
        $instance['tempUnit'] = (!empty($new_instance['tempUnit'])) ? strip_tags( $new_instance['tempUnit'] ) : '';
        $instance['windSpeedUnit'] = (!empty($new_instance['windSpeedUnit'])) ? strip_tags( $new_instance['windSpeedUnit'] ) : '';
        $instance['pressureUnit'] = (!empty($new_instance['pressureUnit'])) ? strip_tags( $new_instance['pressureUnit'] ) : '';
        $instance['enableUserSettings'] = (!empty($new_instance['enableUserSettings'])) ? 1 : 0;                
        $instance['uniqueId'] = uniqid();
        
		return $instance;
	}    
    
    public function renderTitleField ($title) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">    
    <?php    
    }    
    
    public function renderShowCurrentWeatherField ($showCurrentWeather) {
        $showCurrentWeather = !empty($showCurrentWeather) ? $showCurrentWeather : 1;        
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showCurrentWeather' ); ?>" name="<?php echo $this->get_field_name( 'showCurrentWeather' ); ?>" <?php checked( $showCurrentWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showCurrentWeather' ) ); ?>"><?php _e( 'Show current weather' ); ?></label>         
    <?php    
    }    
    
    public function renderShowForecastWeatherField ($showForecastWeather) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showForecastWeather' ); ?>" name="<?php echo $this->get_field_name( 'showForecastWeather' ); ?>" <?php checked( $showForecastWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showForecastWeather' ) ); ?>"><?php _e( 'Show 5 day forecast' ); ?></label>         
    <?php    
    }        
    
    public function renderCityField ($city) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>"><?php _e( 'City:' ); ?></label> 
		<input class="widefat rpw-gm-city" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>">    
        <p class="description">You can find you city name on <a href="http://www.openweathermap.com/" title="http://www.openweathermap.com/" target="_blank">www.openweathermap.com</a>.</p>
    <?php    
    }        
    
    public function renderTempUnitField ($tempUnit) {
        $tempList = RPw()->getSettings()->getFieldSet('temp');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['tempUnit'];
        $tempUnit = !empty($tempUnit) ? $tempUnit : $default;
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>"><?php _e( 'Temperature:' ); ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>" class="temperature-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'tempUnit' ) ); ?>">
        <?php foreach ( $tempList as $key => $item ) : ?>
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
        <label for="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>"><?php _e( 'Wind Speed:' ); ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>" class="windspeed-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'windSpeedUnit' ) ); ?>">
        <?php foreach ( $windSpeedUnitList as $key => $item ) : ?>
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
        <label for="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>"><?php _e( 'Pressure:' ); ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>" class="pressure-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'pressureUnit' ) ); ?>">
        <?php foreach ( $pressureUnitList as $key => $item ) : ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $pressureUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }                    
    
    public function renderEnableUserSettingsField ($enableUserSettings) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'enableUserSettings' ); ?>" name="<?php echo $this->get_field_name( 'enableUserSettings' ); ?>" <?php checked( $enableUserSettings ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'enableUserSettings' ) ); ?>"><?php _e( 'Enable user settings' ); ?></label>         
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
                var autocomplete = new google.maps.places.Autocomplete($(this).get(0), options);           
                autocomplete.rpwOwner = this;
                this.rpwOwner = autocomplete;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    if (place.address_components) {
                        city = '';
                        country = '';
                        for (var i = 0; i < place.address_components.length; i++) {
                            var component = place.address_components[i];
                            if ($.inArray('locality', component.types) != -1) {
                                city = component.long_name;    
                            }
                            if ($.inArray('country', component.types) != -1) {
                                country = component.short_name;    
                            }
                        }
                        if (city) {
                            if (country) {
                                city = city + ', ' + country;
                            }
                            $(autocomplete.rpwOwner).val(city);
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

    