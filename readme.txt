=== WCP OpenWeather ===
Contributors: webcodin
Tags:  forecast, forecast widget, local weather, OpenWeatherMap, shortcode, sidebar, weather, weather forecasts, weather widget, widgets, options, user options, plugin skin, plugin theme, Weather API
Requires at least: 3.5.0
Tested up to: 4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

The weather forecast plugin based on OpenWeatherMap API that includes various sidebar widgets and shortcodes

== Description ==

We represent you the newest weather forecast plugin based on [OpenWeatherMap API](http://openweathermap.org/). Our plugin allows to add weather forecasts with using widgets and shortcodes on your site.

= Plugin Features =

* You can add weather forecast with using widgets in sidebar or stortcode for a page;
* Weather forecast provided by OpenWeatherMap API;
* Conversion measurements and settings for temperature, wind and pressure;
* Default plugin options and personal widgets/shortcodes options for site administrator;
* Optional possibility to allow user options for weather forecast on the site frontend;
* Plugin themes support;
* Possibility to use OpenWeatherMap API key for [paid planes](http://openweathermap.org/price/);
* City name with Google Map Place Autocomplete.

= Default Theme Features =

* 2 widgets with options (normal and mini) for various sidebar sizes;
* Shortcode with parameters for pages;
* Customization of background and text colors;

[Live Demo](http://wpdemo.webcodin.com/weather-forecast/)

= Quick weather forecast setup as widget =

1. Check plugin "Settings" and plugin "Theme Settings" pages and customize weather forecast options for your purposes;
2. Go to the "Appearance" --> "Widgets" sections;
3. Add "WCP Weather" or "WCP Weather Mini" widget to necessary sidebar;
4. Choose city name in the widget options, customize other options for your purposes and press "Save" button. 

That is all. Widget with weather forecast will be displayed at the choosed sidebar.

= Quick weather forecast setup as shortcode =

1. Check plugin "Settings" and plugin "Theme Settings" pages and customize weather forecast options for your purposes;
3. Create new page or use existed;
2. Add shordcode - **[wcp_weather]** - to the TinyMCE editor and save the page for city from default plugin settings.

That is all. Weather forecast will be displayed on your site page.

**NB!** If you need to add several shortcodes on a page, you will need to use following shortcode parameters, as sample **[wcp_weather id="my-weather-1" city="London,GB"]** and **[wcp_weather id="my-weather-2" city="San Francisco,US"]**

More information and documentation can be found in the section [screenshots](https://wordpress.org/plugins/wcp-openweather/screenshots/) and [FAQ](https://wordpress.org/plugins/wcp-openweather/faq/).

= Notes =

* **NB!** We use cookies to storage user options; 
* **NB!** Free OpenWeatherMap has [limitation to API request](http://openweathermap.org/price/) per hour.

== Installation ==

1. Download a copy of the plugin
2. Unzip and Upload 'wcp-openweather' to a sub directory in '/wp-content/plugins/'.
3. Activate the plugins through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How can I add weather forecast to a page =

To create a new page for the weather forecast, go to the menu "Pages" > "Add New". 
After filling all needed fields, please add to the TinyMCE of the page next shortcode and save the page: 

`[wcp_weather]`

As a result, weather forecast will appear on page based on default settings.

The weather forecast can be also added to an existing page. To do this, go to the menu "Pages" > "All Pages". Open for editing the necessary page and insert shortcode in the right place in TinyMCE and save the page. 

If you need to add multiple weather forecasts please use shordcode **[wcp_weather]** with unique ID and city name parameters

**Shortcode examples**

`[wcp_weather]`

`[wcp_weather id="my weather-1" city="London,GB"]`

Full list of parameters that avialable for shortcode:
* **id** - unique name;
* **city** - city name, as sample "London,GB"
* **tempUnit** - temperature unit (c --> °C, f --> °F,) 
* **windSpeedUnit** - wind speed unit (mphc --> mph, kmh --> km/h, msc --> m/s, Knots --> Knots)
* **pressureUnit** - pressure unit (atm --> atm, bar --> bar, hPa --> hPa, kgfcm2 --> kgf/cm2, kgfm2 --> kgf/m2', kPa --> kPa, mbar --> mbar, mmHg --> mmHg, inHg --> inHg, Pa --> Pa, psf --> psf, psi --> psi, torr --> torr)
* **showCurrentWeather** - show current weather (1/0)
* **showForecastWeather** - show 5 day forecast (1/0)

**Shortcode examples**

`[wcp_weather id="my weather-1" city="London,GB" tempUnit="f" windSpeedUnit="mph" pressureUnit="mmHg" showCurrentWeather="1" showForecastWeather="1"]`

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-openweather/screenshots/).

= How can I add weather forecast to a sidebar =

Go to the "Appearance" --> "Widgets" sections.
Add "WCP Weather" or "WCP Weather Mini" widget to necessary sidebar, change sidebar title and other options if you need and press "Save" button.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-openweather/screenshots/).

= How can I configure weather forecast default settings =

To change default weather forecast configuration go to the menu "WCP Weather" > "Settings".

= How can I change weather forecast background and font colors =

To change weather forecast background and font colors go to the menu "WCP Weather" > "Theme Settings".

**More extended documentation will be added soon**

== Screenshots ==
1. Current Weather and Forecast Samples
2. Current Weather and Forecast Samples
3. Current Weather and Forecast Samples :: Mobile Version
4. Current Weather and Forecast Samples :: Mobile Version
5. User Options
6. Shordcode
7. Widget
8. Admin Panel :: Settings :: Weather Tab
9. Admin Panel :: Settings :: Plugin Tab
10. Admin Panel :: Settings :: API Tab
11. Admin Panel :: Theme Settings

== Changelog ==

= 1.0.0 =
* Initial release.
