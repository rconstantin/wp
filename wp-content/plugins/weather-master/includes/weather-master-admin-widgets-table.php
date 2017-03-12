<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class weather_master_admin_widgets_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
	$plugin_master_name = constant('WEATHER_MASTER_NAME');
?>
<table class="widefat" cellspacing="0">
	<thead>
		<tr>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Screenshot', 'weather_master'); ?></h2></th>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Description', 'weather_master'); ?></h2></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><a class="button-primary" href="<?php echo get_site_url(); ?>/wp-admin/widgets.php" title="To Widgets Page" style="float:left;">To Widgets Page</a></p></th>
			<th><a class="button-primary" href="<?php echo get_site_url(); ?>/wp-admin/widgets.php" title="To Widgets Page" style="float:right;">To Widgets Page</a></p></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-basic.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Basic Widget</h3><p>Fast Loading and easy to deploy Widget specially designed in html5 for extremely fast page load times and small system trace. Weather Master Basic Widget uses the latest weather forecast information at a city level detail and provides excellent Google SEO.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-advanced.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Advanced Widget</h3><p>This is the "top of the line" business news type of weather for Wordpress. <b>Fully Mobile Responsive</b>, this widget was specially designed to grant you full control over all weather options, easily customizable.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-geo.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Advanced Geo-Location Widget</h3><p>Provide weather info automatically to each user according to user location. This feature depends of the user browser capability of parsing it’s location. <b>Fully Mobile Responsive</b></p><p>Check Add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-current.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Current Weather Widget</h3><p>Displays weather for any location on Earth including over 200,000 cities. Easy to use, fast loading and packed with gorgeous Android HTC Weather Icons.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-forecast.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Forecast Widget</h3><p>Provides 7 days of weather forecast from over 200,000 cities. Packed with gorgeous Android HTC Weather Icons.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-uv.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master UV Levels Widget</h3><p>UV Index Widget displays UV ultraviolet levels and danger levels for a specific Map location.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-ozone.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Ozone Levels Widget</h3><p>Ozone Index Widget displays the current Ozone level for a specific Map location.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-pollution.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Pollution Levels Widget</h3><p>Pollution Index Widget displays the current Carbon Monoxide level for a specific Map location.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-weathermaster-admin-widget-dashboard.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Weather Master Administrator Dashboard Widget</h3><p>Cool Administrator Widget to keep track of the weather outside while you work on your wordpress. Small system trace.</p><p>Check Add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-admin-widget-blank.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Suggest a Widget</h3><p>Would you like to see your widget idea added to this plugin? Just drop us a line and we will make sure it gets included in the next release.</p><p>Get in touch with TechGasp.</p></td>
		</tr>
	</tbody>
</table>
<?php
		}
}
