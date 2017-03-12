<?php
//Hook Widget
add_action( 'widgets_init', 'weather_master_widget_basic' );
//Register Widget
function weather_master_widget_basic() {
register_widget( 'weather_master_widget_basic' );
}

class weather_master_widget_basic extends WP_Widget {
	function __construct(){
	$widget_ops = array( 'classname' => 'Weather Master Basic', 'description' => __('Weather Master Basic Fast Loading Widget is easy to deploy and uses the latest weather forecast information.', 'weather_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'weather_master_widget_basic' );
	parent::__construct( 'weather_master_widget_basic', __('Weather Master Basic', 'weather_master'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	global $wpdb, $blog_id;
		extract( $args );
		//Save WPOptions
		$weather_master_load_advanced_city = "6";
		$weather_master_load_advanced_state = "6";
		$weather_master_load_basic_country = "6";
		if(is_multisite()){
			add_blog_option($blog_id, 'weather_master_view_advanced_detail_choice', "6");
			add_blog_option($blog_id, 'weather_master_load_advanced_city', $weather_master_load_advanced_city);
			add_blog_option($blog_id, 'weather_master_load_advanced_state', $weather_master_load_advanced_state); 
			add_blog_option($blog_id, 'weather_master_load_basic_country', $weather_master_load_basic_country);
		}
		else{
			add_option('weather_master_view_advanced_detail_choice', "6");
			add_option('weather_master_load_advanced_city', $weather_master_load_advanced_city);
			add_option('weather_master_load_advanced_state', $weather_master_load_advanced_state); 
			add_option('weather_master_load_basic_country', $weather_master_load_basic_country);
		}
		//Set Tittle
		$weather_title = isset( $instance['weather_title'] ) ? $instance['weather_title'] :false;
		$weather_title_new = isset( $instance['weather_title_new'] ) ? $instance['weather_title_new'] :false;
		//Set Wide Map Options
		$weathermapsspacer ="'";
		$show_weather_master = isset( $instance['show_weather_master'] ) ? $instance['show_weather_master'] :false;
		$weather_master_weather_temp = isset( $instance['weather_master_weather_temp'] ) ? $instance['weather_master_weather_temp'] :false;
		$weather_zoom = isset( $instance['weather_zoom'] ) ? $instance['weather_zoom'] :false;
		$weather_height = isset( $instance['weather_height'] ) ? $instance['weather_height'] :false;
		$weather_latitude = isset( $instance['weather_latitude'] ) ? $instance['weather_latitude'] :false;
		$weather_longitude = isset( $instance['weather_longitude'] ) ? $instance['weather_longitude'] :false;
		$weather_google_maps_key = isset( $instance['weather_google_maps_key'] ) ? $instance['weather_google_maps_key'] :false;
		$weather_master_basic_OW_api = isset( $instance['weather_master_basic_OW_api'] ) ? $instance['weather_master_basic_OW_api'] :false;
		echo $before_widget;
		
		// Display the widget title
	if ( $weather_title ){
		if (empty ($weather_title_new)){
			$weather_title_new = constant('WEATHER_MASTER_NAME');
			echo $before_title . $weather_title_new . $after_title;
		}
		else{
			echo $before_title . $weather_title_new . $after_title;
		}
	}
	else{
	}

	//Display Google Maps
	if ( $show_weather_master ){
		if (empty($weather_master_view_basic_detail_choice)){
		$weather_master_view_basic_detail_choice = '6';
		}
		if (empty($weather_height)){
		$weather_height = '400';
		}
		if (empty($weather_latitude)){
		$weather_latitude = '32.720392';
		}
		if (empty($weather_longitude)){
		$weather_longitude = '-117.228778';
		}
		//PREPARE TEMP
		if ($weather_master_weather_temp){
			$weather_master_weather_temp_choice = "metric";
			$weather_master_weather_temp_letter = "C";
			$weather_master_weather_speed_letter = "km/h";
		}
		else{
			$weather_master_weather_temp_choice = "imperial";
			$weather_master_weather_temp_letter = "F";
			$weather_master_weather_speed_letter = "mph";
		}
		//Prepare API Keys
		if (empty($weather_master_basic_OW_api)){
			$weather_master_api_key = "";
			$weather_master_api_key_link = "";
		}
		else{
			$weather_master_api_key = 'var openWeatherMapKey = "'.$weather_master_basic_OW_api.'"';
			$weather_master_api_key_link = '+ "&APPID=" + openWeatherMapKey;';
		}
		if (empty($weather_google_maps_key)){
			$weather_google_maps_key_create = '';
		}
		else{
			$weather_google_maps_key_create = '?key='.$weather_google_maps_key.'';
		}
		echo '<div id="map-weather-master-wbas" style="width:auto;height:'.$weather_height.'px"></div>' .
		'<script src="https://maps.googleapis.com/maps/api/js'.$weather_google_maps_key_create.'"></script>' .
		'<script>' .
		'var map;
  var geoJSON;
  var request;
  var gettingData = false;
  '.$weather_master_api_key.'
  function initialize() {
    var mapOptions = {
      zoom: 6,
      center: new google.maps.LatLng('.$weather_latitude.','.$weather_longitude.')
    };
    map = new google.maps.Map(document.getElementById('.$weathermapsspacer.'map-weather-master-wbas'.$weathermapsspacer.'),
        mapOptions);
    // Add interaction listeners to make weather requests
    google.maps.event.addListener(map, '.$weathermapsspacer.'idle'.$weathermapsspacer.', checkIfDataRequested);
    // Sets up and populates the info window with details
    map.data.addListener('.$weathermapsspacer.'click'.$weathermapsspacer.', function(event) {
      infowindow.setContent(
       "<img src=" + event.feature.getProperty("icon") + ">"
       + "<br /><strong>" + event.feature.getProperty("city") + "</strong>"
	   + "<br />" + event.feature.getProperty("weather")
       + "<br /><strong>" + event.feature.getProperty("temperature") + "&deg;'.$weather_master_weather_temp_letter.'" + "</strong>" + " (" + event.feature.getProperty("max") + "&deg;'.$weather_master_weather_temp_letter.'" + "/" + event.feature.getProperty("min") + "&deg;'.$weather_master_weather_temp_letter.'" +")"
	   + "<br />Wind: " + event.feature.getProperty("windSpeed") + "'.$weather_master_weather_speed_letter.'" + " Direction: " + event.feature.getProperty("windDegrees") + "&deg;"
	   + "<br />Humidity: " + event.feature.getProperty("humidity") + "%"
	   + "<br />Pressure: " + event.feature.getProperty("pressure") + " hpa"
       );
      infowindow.setOptions({
          position:{
            lat: event.latLng.lat(),
            lng: event.latLng.lng()
          },
          pixelOffset: {
            width: 0,
            height: -15
          }
        });
      infowindow.open(map);
    });
  }
  var checkIfDataRequested = function() {
    // Stop extra requests being sent
    while (gettingData === true) {
      request.abort();
      gettingData = false;
    }
    getCoords();
  };
  // Get the coordinates from the Map bounds
  var getCoords = function() {
    var bounds = map.getBounds();
    var NE = bounds.getNorthEast();
    var SW = bounds.getSouthWest();
    getWeather(NE.lat(), NE.lng(), SW.lat(), SW.lng());
  };
  // Make the weather request
  var getWeather = function(northLat, eastLng, southLat, westLng) {
    gettingData = true;
    var requestString = "http://api.openweathermap.org/data/2.5/box/city?bbox="
                        + westLng + "," + northLat + "," //left top
                        + eastLng + "," + southLat + "," //right bottom
                        + map.getZoom()
                        + "&cluster=yes&format=json"
						+ "&units='.$weather_master_weather_temp_choice.'"
						'.$weather_master_api_key_link.'
    request = new XMLHttpRequest();
    request.onload = proccessResults;
    request.open("get", requestString, true);
    request.send();
  };
  // Take the JSON results and proccess them
  var proccessResults = function() {
    console.log(this);
    var results = JSON.parse(this.responseText);
    if (results.list.length > 0) {
        resetData();
        for (var i = 0; i < results.list.length; i++) {
          geoJSON.features.push(jsonToGeoJson(results.list[i]));
        }
        drawIcons(geoJSON);
    }
  };
  var infowindow = new google.maps.InfoWindow();
  // For each result that comes back, convert the data to geoJSON
  var jsonToGeoJson = function (weatherItem) {
    var feature = {
      type: "Feature",
      properties: {
        city: weatherItem.name,
        weather: weatherItem.weather[0].description,
        temperature: weatherItem.main.temp,
        min: weatherItem.main.temp_min,
        max: weatherItem.main.temp_max,
        humidity: weatherItem.main.humidity,
        pressure: weatherItem.main.pressure,
        windSpeed: weatherItem.wind.speed,
        windDegrees: weatherItem.wind.deg,
		icon: "http://openweathermap.org/img/w/"
		+ weatherItem.weather[0].icon  + ".png",
        coordinates: [weatherItem.coord.lon, weatherItem.coord.lat]
      },
      geometry: {
        type: "Point",
        coordinates: [weatherItem.coord.lon, weatherItem.coord.lat]
      }
    };
    // Set the custom marker icon
    map.data.setStyle(function(feature) {
      return {
        icon: {
          url: feature.getProperty('.$weathermapsspacer.'icon'.$weathermapsspacer.'),
          anchor: new google.maps.Point(25, 8)
        }
      };
    });
    // returns object
    return feature;
  };
  // Add the markers to the map
  var drawIcons = function (weather) {
     map.data.addGeoJson(geoJSON);
     // Set the flag to finished
     gettingData = false;
  };
  // Clear data layer and geoJSON
  var resetData = function () {
    geoJSON = {
      type: "FeatureCollection",
      features: []
    };
    map.data.forEach(function(feature) {
      map.data.remove(feature);
    });
  };
  google.maps.event.addDomListener(window, '.$weathermapsspacer.'load'.$weathermapsspacer.', initialize);' .
		'</script>';

	}
	else{
	}
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
	global $wpdb, $blog_id;
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['weather_title'] = strip_tags( $new_instance['weather_title'] );
		$instance['weather_title_new'] = $new_instance['weather_title_new'];
		//Store Wide Map Options
		$instance['show_weather_master'] = $new_instance['show_weather_master'];
		$instance['weather_master_weather_temp'] = $new_instance['weather_master_weather_temp'];
		$instance['weather_master_view_basic_detail_choice'] = $new_instance['weather_master_view_basic_detail_choice'];
		$instance['weather_width'] = $new_instance['weather_width'];
		$instance['weather_height'] = $new_instance['weather_height'];
		$instance['weather_latitude'] = $new_instance['weather_latitude'];
		$instance['weather_longitude'] = $new_instance['weather_longitude'];
		$instance['weather_google_maps_key'] = $new_instance['weather_google_maps_key'];
		$instance['weather_master_basic_OW_api'] = $new_instance['weather_master_basic_OW_api'];
		if(is_multisite()){
			update_blog_option($blog_id, 'weather_master_view_basic_detail_choice', $new_instance['weather_master_view_basic_detail_choice']);
		}
		else{
			update_option('weather_master_view_basic_detail_choice', $new_instance['weather_master_view_basic_detail_choice']);
		}
		return $instance;
	}
	function form( $instance ) {
	global $wpdb, $blog_id;
	$plugin_master_name = constant('WEATHER_MASTER_NAME');
	//Set up some default widget settings.
	$defaults = array( 'weather_title_new' => __('Google Ads Master', 'weather_master'), 'weather_title' => true, 'weather_title_new' => false, 'show_weather_master' => false, 'weather_master_view_basic_detail_choice' => false, 'weather_master_weather_temp' => false, 'weather_height' => false, 'weather_latitude' => false, 'weather_longitude' => false, 'weather_google_maps_key' => false, 'weather_master_basic_OW_api' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	//Lets get data from single and multi to populate the form
	if(is_multisite()){
		$weather_master_view_basic_detail_choice = get_blog_option($blog_id, 'weather_master_view_basic_detail_choice');
		$weather_master_load_basic_state = get_blog_option($blog_id, 'weather_master_load_basic_state');
	}
	else{
		$weather_master_view_basic_detail_choice = get_option('weather_master_view_basic_detail_choice');
		$weather_master_load_basic_state = get_option('weather_master_load_basic_state');
	}
	?>
		<p>
		<b>Check the buttons to be displayed:</b>
		</p>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['weather_title'], true ); ?> id="<?php echo $this->get_field_id( 'weather_title' ); ?>" name="<?php echo $this->get_field_name( 'weather_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_title' ); ?>"><b><?php _e('Display Widget Title', 'weather_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_title_new' ); ?>"><?php _e('Change Title:', 'weather_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'weather_title_new' ); ?>" name="<?php echo $this->get_field_name( 'weather_title_new' ); ?>" value="<?php echo $instance['weather_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
	<h2>Weather Options</h2>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_weather_master'], true ); ?> id="<?php echo $this->get_field_id( 'show_weather_master' ); ?>" name="<?php echo $this->get_field_name( 'show_weather_master' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_weather_master' ); ?>"><b><?php _e('Activate Weather Display', 'weather_master'); ?></b></label>
	</p>
	<p>
	<select id="<?php echo $this->get_field_id( 'weather_master_view_basic_detail_choice' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_view_basic_detail_choice' ); ?>" style="width:190px">
	<option value="<?php echo $weather_master_load_basic_state; ?>" <?php echo $weather_master_view_basic_detail_choice == '6' ? 'selected="selected"':''; ?>>State Weather Level</option>
	</select>
	<label for="<?php echo $this->get_field_id( 'weather_master_view_basic_detail_choice' ); ?>"></label>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['weather_master_weather_temp'], true ); ?> id="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_weather_temp' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>"><b><?php _e('Activate Weather in Celsius', 'weather_master'); ?></b></label>
	<div class="description">Default <b>Off</b> temperature displayed in Fahrenheit.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_height' ); ?>"><?php _e('Plugin Height:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_height' ); ?>" name="<?php echo $this->get_field_name( 'weather_height' ); ?>" value="<?php echo $instance['weather_height']; ?>" style="width:auto;" />
	<div class="description">Default <b>400</b> or <b>empty field</b>. This value, does not affect responsiveness.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_latitude' ); ?>"><?php _e('Weather Latitude:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_latitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_latitude' ); ?>" value="<?php echo $instance['weather_latitude']; ?>" style="width:auto;" />
	<div class="description">Example <b>32.720392</b>. Check below instructions.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_longitude' ); ?>"><?php _e('Weather Longitude:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_longitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_longitude' ); ?>" value="<?php echo $instance['weather_longitude']; ?>" style="width:auto;" />
	<div class="description">Example <b>-117.228778</b>. Check below instructions.</div>
	</p>
	<p>
	<div class="description"><a href="http://maps.google.com" target="_blank">Get Weather Coordinates</a>. Right-click on the desired spot on the map to bring up a menu with options. Click What's here to get the latitude and longitude coordinates. Try to get coordinates roughly from the center of your city, state or country.</div>
	<div class="description"><a href="http://wordpress.techgasp.com/weather-master-documentation/" target="_blank">More about these settings</a>.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_google_maps_key' ); ?>"><?php _e('Google Maps API Key (optional):', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_google_maps_key' ); ?>" name="<?php echo $this->get_field_name( 'weather_google_maps_key' ); ?>" value="<?php echo $instance['weather_google_maps_key']; ?>" style="width:auto;" />
	<div class="description">According to the new google API all map requests may need a free API key. The plugin is ready for this new feature. Before getting a key test to see if map displays correctly, otherwise <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#key" target="_blank">Get free Google Maps Javascript Api Key</a>.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_master_basic_OW_api' ); ?>"><?php _e('OpenWeather API Key (optional):', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_master_basic_OW_api' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_basic_OW_api' ); ?>" value="<?php echo $instance['weather_master_basic_OW_api']; ?>" style="width:auto;" />
	<div class="description">If you have a lot of page requests OpenWeather may require a free API key. Test the widget to see if weather icons are displaying, if not <a href="http://openweathermap.org/" target="_blank">Get free OpenWeather Api Key</a>.</div>
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; width:18px; vertical-align:middle;" />
	&nbsp;
	<b><?php echo $plugin_master_name; ?> Website</b>
	</p>
	<p><a class="button-secondary" href="https://wordpress.techgasp.com/weather-master/" target="_blank" title="<?php echo $plugin_master_name; ?> Info Page">Info Page</a> <a class="button-secondary" href="https://wordpress.techgasp.com/weather-master-documentation/" target="_blank" title="<?php echo $plugin_master_name; ?> Documentation">Documentation</a> <a class="button-primary" href="https://wordpress.org/plugins/weather-master/" target="_blank" title="<?php echo $plugin_master_name; ?> Wordpress">RATE US *****</a></p>
	<?php
	}
 }
?>
