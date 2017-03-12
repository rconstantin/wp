<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class weather_master_admin_addons_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
	$plugin_master_name = constant('WEATHER_MASTER_NAME');
	$path = ABSPATH . 'wp-content/plugins/weather-master-addons/';
	if ( is_plugin_active( 'weather-master-addons/weather-master-addons.php' ) && file_exists($path) ) {
		$weather_master_addon = "yes";
		$weather_master_addon_get = '<b>All add-ons Installed</b>';
	}
	else{
		$weather_master_addon = "no";
		$weather_master_addon_get = '<a class="button-primary" href="https://wordpress.techgasp.com/weather-master/" target="_blank" title="Get Add-ons" style="float:left;">Get Add-ons</a>';
	}
?>
<table class="widefat" cellspacing="0">
	<thead>
		<tr>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Screenshot', 'weather_master'); ?></h2></th>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Description', 'weather_master'); ?></h2></th>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Installed', 'weather_master'); ?></h2></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><?php echo $weather_master_addon_get; ?></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-basic.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Basic Widget</h3><p>Fast Loading and easy to deploy Widget specially designed in html5 for extremely fast page load times and small system trace. Weather Master Basic Widget uses the latest weather forecast information at a city level detail and provides excellent Google SEO.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-yes.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-advanced.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Advanced Widget</h3><p>This is the "top of the line" business news type of weather for Wordpress. <b>Fully Mobile Responsive</b>, this widget was specially designed to grant you full control over all weather options, easily customizable.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-geo.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Advanced Geo-Location Widget</h3><p>Provide weather info automatically to each user according to user location. This feature depends of the user browser capability of parsing it’s location. <b>Fully Mobile Responsive</b></p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-current.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Current Weather Widget</h3><p>Displays weather for any location on Earth including over 200,000 cities. Easy to use, fast loading and packed with gorgeous Android HTC Weather Icons.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-forecast.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Forecast Widget</h3><p>Provides 7 days of weather forecast from over 200,000 cities. Packed with gorgeous Android HTC Weather Icons.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-uv.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master UV Levels Widget</h3><p>Must have widget to display UV "ultraviolet levels and Warning levels for a specific location. All outdoors activities will love it. Beautiful Map display of your city, beach, valley or state with UV color overlay.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-ozone.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Ozone Levels Widget</h3><p>Ozone Index Widget displays the current Ozone level for a specific Map location. Careful with Ozone holes!!!</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-pollution.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Pollution Levels Widget</h3><p>Pollution Index Widget displays the current Carbon Monoxide level for a specific Map location. Do I need a face mask today!!!</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-widget-dashboard.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Administrator Dashboard Widget</h3><p>Cool Administrator Widget to keep track of the weather outside while you work on your wordpress. Small system trace.</p><p>Navigate to your wordpress dashboard and start using it.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-shortcode-in.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Individual Shortcode</h3><p>Weather Master uses TechGasp Wordpress Framework. The <b>Individual Shortcode</b> allows you to have a different customized shortcode in each page or post. Easy to use it can be found when you edit a page or a post under the wordpress text editor. Once you have created your shortcode, Just insert the shortcode <b>[weather-master]</b> anywhere inside that text.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-shortcode-un.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Universal Shortcode</h3><p>Weather Master uses TechGasp Wordpress Framework. The <b>Universal Shortcode</b> allows you to have the same shortcode across different pages or posts. Easy to use it can be found right here under the Shortcodes menu. Once you have created your shortcode, Just insert the shortcode <b>[weather-master-un]</b> anywhere inside the text of your pages or posts.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-updater.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Advanced Updater</h3><p>The Advanced Updater allows you to easily Update / Upgrade your Advanced Plugin. You can instantly update your plugin after we release a new version with more goodies without having to wait for the nightly native wordpress updater that runs every 24/48 hours. Get it fresh, get it fast.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-addons-support.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="139px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Award Winning Professional Support</h3><p>Need professional help deploying this plugin? TechGasp provides 24/7 award winning professional wordpress support for all advanced version costumers and replies to support tickets usually within minutes of being received. Support Us and we will Support You.</p></td>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-check-'.$weather_master_addon.'.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="200px" height="121px" style="padding:5px;"/></td>
		</tr>
	</tbody>
</table>
<?php
		}
}
