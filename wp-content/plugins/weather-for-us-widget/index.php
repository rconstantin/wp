<?php
/**
 * Plugin Name: Weather for us widget
 * Plugin URI: http://www.weatherfor.us/
 * Description: The simplest to install and clean looking weather widget for your website, comes with weather forecast, temparture units, automatically detecting location
 * Version: 1.8.7
 * Author: Weatherfor.us
 * Author URI: http://www.weatherfor.us/
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'weather_for_us_v1_0_load' );

/**
 * Register our widgets
 * 
 *
 * @since 0.1
 */
function weather_for_us_v1_0_load() {
    register_widget( 'ExplicitWeather4UsWidget' );
    register_widget( 'MiniWeather4UsWidget' );
    add_shortcode('weatherforus', 'weatherforus_shortcode');
}

class MiniTl8 {
    public static function render($content, $data = array()) {
        $ret = $content;
        foreach ($data as $name => $val) {
            $ret = str_replace('{{'.$name.'}}', $val, $ret);
        }
        return $ret;
    }
}

class Weather4UsWidget extends WP_Widget {

    public $SiteUrl = 'https://www.weatherfor.us';
    
    public $widget_name = 'weather';
    public $widget_title = "Weather for us widget";

    /**
     * Widget setup.
     */
    function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'w4us_widget', 'description' => 'Weather for us widget');

        /* Widget control settings. */
        $control_ops = array( 'width' => 720, 'height' => 250, 'id_base' => 'weatherforus-wp-'.strtolower($this->widget_name));

        /* Create the widget. */
        parent::__construct( 'weatherforus-wp-'.$this->widget_name, $this->widget_title, $widget_ops, $control_ops );
    }

    /**
     * Display the widget on the screen.
     */
    function widget( $args, $instance ) {
        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $code = '';
        $params = array();
        if (isset($instance['location'])) {
            $params['location'] = $instance['location'];
        }

        if (isset($instance['unit']) && $instance['unit'] == 'c') {
            $params['unit'] = 'metric';
        } else {
            $params['unit'] = 'f';
        }

        if (isset($instance['id'])) {
            $params['id'] = $instance['id'];
        }

        $code = '<iframe id="explicit" src="{{base_url}}/widget?{{params}}" allowtransparency="true" style="background: transparent; width: 720px; height: 250px; overflow: hidden;" frameborder="0" scrolling="no"></iframe>';
        echo MiniTl8::render($code, array('base_url' => $this->SiteUrl, 'params' => http_build_query($params)));
    }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        foreach(array('id', 'location', 'bg_color', 'txt_color', 'unit') as $i){
            /* Strip tags for title and name to remove HTML (important for text inputs). */
            if(isset($new_instance[$i])){
                $instance[$i] = strip_tags( $new_instance[$i] );
            }
        }

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'location' => __('', $this->widget_name));
        $instance = wp_parse_args( (array) $instance, $defaults ); 
    ?>

        <!-- Your Name: Text Input -->
        <div class="weather-for-us-form">
            <h2>Configuration</h2>
            <p><strong>Note!</strong> This widget is optimized for wider spaces. For widget with tighter space please use <strong>Weatherfor.us Mobile widget</strong> instead. You can use shortcode <pre>[weatherforus]</pre> to embed it anywhere in your site. Checkout <a href="https://wordpress.org/plugins/weather-for-us-widget/">documentation</a> for more details. P.S. we have an awesome support on our <a href="http://www.weatherfor.us/">website</a>.</p>
            <div>
                    <label for="<?php echo $this->get_field_id( 'location' ); ?>">
                        <?php _e('Enter location, city name followed by country (optional leave empty to autodetect):', $this->widget_name); ?>
                    </label>
                    <br/>
                    <input id="<?php echo $this->get_field_id( 'location' ); ?>" 
                           name="<?php echo $this->get_field_name( 'location' ); ?>" 
                           value="<?php echo $instance['location']; ?>" 
                           style="width:100%;" />
                    <br/>
                    <br/>
            </div>

            <div>
                    <label for="<?php echo $this->get_field_id( 'id' ); ?>">
                        <?php _e('Enter client ID (only required for premium users):', $this->widget_name); ?>
                    </label>
                    <br/>
                    <input id="<?php echo $this->get_field_id( 'id' ); ?>" 
                           name="<?php echo $this->get_field_name( 'id' ); ?>" 
                           value="<?php echo $instance['id']; ?>" 
                           style="width:100%;" />
                    <br/>
                    <br/>
            </div>

            <div>
                    <input id="<?php echo $this->get_field_id( 'unit' ); ?>" 
                           name="<?php echo $this->get_field_name( 'unit' ); ?>" 
                           value="c" 
                           <?php if(isset($instance['unit']) && $instance['unit'] == 'c') echo 'checked="checked"'; ?> 
                           type="checkbox" /> 
                    <label for="<?php echo $this->get_field_id( 'unit' ); ?>">
                        <?php _e('Use Centigrade as default unit', $this->widget_name); ?>
                    </label>
                    <br/>
                    <br/>
            </div>
        </div>
        
    <?php
    }
}

class ExplicitWeather4UsWidget extends Weather4UsWidget {   
    public $widget_name = 'weather-large';
    public $widget_title = "Signage widget- weatherfor.us";
}

class MiniWeather4UsWidget extends Weather4UsWidget {
    public $widget_name = 'weather-mini';
    public $widget_title = "Weather widget - weatherfor.us";

    /**
     *display the widget on the screen.
     */
    function widget( $args, $instance ) {
        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $code = '';
        $params = array();
        $widthCss = 'width: 100%; min-width: 150px; ';
        $heightCss = '';
        if (isset($instance['width'])) {
            $widthCss = 'width: '.$instance['width'].'; ';
        }

        if (isset($instance['height'])) {
            $height = 'height: '.$instance['height'].'; ';
        }

        foreach(array('id', 'location', 'bg_color', 'txt_color', 'unit') as $i){
            if(isset($instance[$i])){
                $params[$i] = $instance[$i];
            }
        }

        $code = '<div style="margin: 0 auto; '.$widthCss.$heightCss.'position: relative; ">'.
                '<script type="text/javascript" src="{{root_home}}/static/js/minion/minion.js"></script>'.
                '<script type="text/javascript">w4uminion.run({{config_json}});</script>'.
                '</div>';
        echo MiniTl8::render($code, array('config_json' => json_encode($params), 'root_home' => $this->SiteUrl));
    }

    function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array( 'location' => __('', $this->widget_name));
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <div class="weather-for-us-form">
            <h2>Configuration</h2>
            <p>You can use shortcode <pre>[weatherforus type="mini"]</pre> to embed it anywhere in your site. Checkout <a href="https://wordpress.org/plugins/weather-for-us-widget/">documentation</a> for more details. P.S. we have an awesome support on our <a href="http://www.weatherfor.us/">website</a>.</p>
            <div>
                    <label for="<?php echo $this->get_field_id( 'location' ); ?>">
                        <?php _e('Enter comma seperated location in following format city, county/state, country (Leave empty to autodetect users\'s location):', 
                                 $this->widget_name); ?>
                    </label>
                    <br/>
                    <input id="<?php echo $this->get_field_id( 'location' ); ?>" 
                           name="<?php echo $this->get_field_name( 'location' ); ?>" 
                           value="<?php echo $instance['location']; ?>" style="width:100%;" />
                    <br/>
                    <br/>
            </div>

            <div>
                    <input id="<?php echo $this->get_field_id( 'unit' ); ?>" 
                           name="<?php echo $this->get_field_name( 'unit' ); ?>" 
                           value="c" 
                           <?php if(isset($instance['unit']) && $instance['unit'] == 'c') echo 'checked="checked"'; ?> 
                           type="checkbox" /> 
                    <label for="<?php echo $this->get_field_id( 'unit' ); ?>">
                        <?php _e('Use <strong>Centigrade</strong> as default unit', $this->widget_name); ?>
                    </label>
                    <br/>
                    <br/>
            </div>

            <div>
                    <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>">
                        <?php _e('Select background color of the panel where widget is placed (leave empty for transparent color).', $this->widget_name); ?>
                    </label>
                    <br/>
                    <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" 
                           name="<?php echo $this->get_field_name( 'bg_color' ); ?>" 
                           value="<?php echo $instance['bg_color']; ?>" class="color-picker"/>
                    <br/>
                    <br/>
           </div>

           <div>
                    <label for="<?php echo $this->get_field_id( 'txt_color' ); ?>">
                        <?php _e('Select text color for the temprature shown in widget', $this->widget_name); ?>
                    </label>
                    <br/>
                    <input id="<?php echo $this->get_field_id( 'txt_color' ); ?>" 
                           name="<?php echo $this->get_field_name( 'txt_color' ); ?>" 
                           value="<?php echo $instance['txt_color']; ?>" 
                           class="color-picker"/> 
                    <br/>
                    <br/>
           </div>

           <div>
                   <label for="<?php echo $this->get_field_id( 'id' ); ?>">
                       <?php _e('Enter client ID (optional):', $this->widget_name); ?>
                   </label>
                    <br/>
                   <input id="<?php echo $this->get_field_id( 'id' ); ?>" 
                          name="<?php echo $this->get_field_name( 'id' ); ?>" 
                          value="<?php echo $instance['id']; ?>" 
                          style="width:100%;" />
                    <br/>
                    <br/>
           </div>
        </div>
    <?php
    }
}


function weatherforus_prepare_widget_size($subject) {
    $size_regex_pattern = '/^([\d\.]+)(%|px|em)?$/';
    $matches = null;
    if (preg_match($size_regex_pattern, $subject, $matches) == 1) {
        $ret = $matches[1];

        if (isset($matches[2])) {
            $ret = ''.$ret.$matches[2];
        }

        return $ret;
    }
    
    return $subject;
}

function weatherforus_clean_empty($atts) {
    foreach ($atts as $key => $value) {
        if ($value === null || empty($value)) {
            unset($atts[$key]);
        }
    }

    return $atts;
}


/**
 * Shortcode callback for reference https://codex.wordpress.org/Shortcode_API
 */
function weatherforus_shortcode($w_atts, $content = null) {
    $atts = shortcode_atts( array(
        'type' => 'mini',
        'id' => null,
        'location' => null, 
        'bg_color' => null, 
        'txt_color' => null, 
        'width' => null,
        'height' => null,
        'unit' => null
    ), $w_atts);

    $widget = new ExplicitWeather4UsWidget();
    if ($atts['type'] == 'mini') {
        $widget = new MiniWeather4UsWidget();
    }

    $atts = weatherforus_clean_empty($atts);

    if (!empty($atts['width'])) {
        $atts['width'] = weatherforus_prepare_widget_size($atts['width']);
    }

    if (!empty($atts['height'])) {
        $atts['height'] = weatherforus_prepare_widget_size($atts['height']);
    }

    return $widget->widget(array(), $atts);
}
