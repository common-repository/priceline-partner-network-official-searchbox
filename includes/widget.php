<?php

namespace PPN;

// disable file editing
defined('ABSPATH') or die('Please do not edit!');

/**
 * Widget class Searchbox. Creates a PPN Searchbox widget.
 *
 * @package PPN
 * @since 4.3.1
 */
class Searchbox extends \WP_Widget{

    /**
     * An array of themes and their resources. Is propagated on construct.
     *
     * @access protected
     * @var array
     */
    protected $theme_files = array();

    /**
     * The current instance of the widget.
     *
     * @access protected
     * @var array
     */
    protected $current_instance = array();

    /**
     * An array of all the options for the widget along with their default value.
     *
     * @access protected
     * @var array
     */
    protected $all_options = array(
        // general options
        'title' => 'New title',
        'theme' => 'default',
        'enable_hotel' => true,
        'enable_car' => true,
        'enable_air' => true,
        'enable_vp' => true,
        'enable_pet' => false,
        'new_window' => false,
        'auto_today' => false,
        'auto_checkout' => true,
        // hotel options
        'hotel_months' => 1,
        'hotel_input' => 'Enter a City or Airport',
        'hotel_options' => true,
        'hotel_airports_first' => false,
        'hotel_autocomplete' => false,
        'hotel_cities' => true,
        'hotel_cities_num' => 4,
        'hotel_airports' => true,
        'hotel_airports_num' => 4,
        'hotel_regions' => true,
        'hotel_regions_num' => 3,
        'hotel_pois' => false,
        'hotel_pois_num' => 0,
        'hotel_hotels' => false,
        'hotel_hotels_num' => 0,
        // car options
        'car_months' => 1,
        'car_input_origin' => 'Enter a City or Airport',
        'car_input_destination' => 'Enter a City or Airport',
        'car_options' => true,
        'car_airports_first' => false,
        'car_autocomplete' => false,
        'car_cities' => true,
        'car_cities_num' => 4,
        'car_airports' => true,
        'car_airports_num' => 4,
        // air options
        'air_months' => 1,
        'air_input_origin' => 'Enter a City or Airport',
        'air_input_destination'  => 'Enter a City or Airport',
        'air_options' => true,
        'air_airports_first' => false,
        'air_autocomplete' => false,
        'air_cities' => true,
        'air_cities_num' => 4,
        'air_airports' => true,
        'air_airports_num' => 4,
        // vp options
        'vp_months' => 1,
        'vp_input_origin' => 'Enter a City or Airport',
        'vp_input_destination' => 'Enter a City or Airport',
        'vp_options' => true,
        'vp_airports_first' => false,
        'vp_autocomplete' => false,
        'vp_cities' => true,
        'vp_cities_num' => 4,
        'vp_airports' => true,
        'vp_airports_num' => 4
    );

    /**
     * Class constructor. Perform initial setup of the widget.
     *
     * @see WP_Widget::__construct()
     */
    public function __construct(){
        // register widget with parent class
        parent::__construct(
            'rs_searchbox',
            __('Priceline Partner Network Searchbox', RS_TEXT_DOMAIN),
            array('description' => __('Display your PPN searchbox.', RS_TEXT_DOMAIN))
        );

        // register the styles and scripts of all themes
        $this->register_themes();

        // register the searchbox javascript
        wp_register_script('rs_searchbox_js', '//secure.rezserver.com/public/js/searchbox/searchbox.min.js', array('jquery'), null, true);
    }

    /**
     * Registers each themes css and scripts to WordPress.
     *
     * @param \DirectoryIterator $file The current file
     * @param string $path             The file's path
     * @param string $theme            The file's theme
     *
     * @throws \Exception if the themes style.css file is missing
     */
    private function register($file, $path, $theme){
        // create a name for the file that will be used to register
        $file_name = 'rs_' . $theme . '_' . $path . '_' . $file->getBasename('.' . $file->getExtension());

        // get the url to the file that will be used to register
        $file_url = RS_TEMPLATE_URL . '/' . $theme . '/' . $path . '/' . $file->getBasename();

        // register the file
        if($path == 'css'){
            add_action('init',
                create_function('', 'return wp_register_style("' . $file_name . '", "' . $file_url . '");')
            );
        }elseif($path == 'js'){
            add_action('init',
                create_function('', 'return wp_register_script("' . $file_name . '", "' . $file_url . '", array("jquery"), null, true);')
            );
        }

        // add the file name to the themes files array
        $this->theme_files[$theme][$path][] = $file_name;
    }

    /**
     * Recursive function to find all stylesheets and scripts for all themes
     *
     * @param \DirectoryIterator $path The current item in the iterator
     * @param string $theme            The theme of the current item
     */
    private function register_themes($path = false, $theme = false){
        // loop through each item of the template's dir
        foreach(new \DirectoryIterator($path ? $path->getPathname() : RS_TEMPLATE_PATH) as $dir){
            // check if current item is a directory in the template root or if item is the css or js directory in the theme
            if($dir->isDir() && ! $dir->isDot() && $path == false || ($dir->getBasename() == 'css' || $dir->getBasename() == 'js')){
                // if we are not in a themes directory, add the theme to the themes files array
                if(! $theme){
                    $this->theme_files[$dir->getBasename()] = array('css' => array(), 'js' => array());
                }
                // recursively call the function on the themes directory and pass the themes name
                $this->register_themes($dir, ($theme ?: $dir->getBasename()));
            // check if current item in a themes js or css directory
            }elseif($path && ! $dir->isDot() && (($path->getBasename() == 'css' && $dir->getExtension() == 'css') || ($path->getBasename() == 'js' && $dir->getExtension() == 'js'))){
                // register the file
                $this->register($dir, $path->getBasename(), $theme);
            }
        }
    }

    /**
     * Outputs the widget. Overwrites the parent widget function.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget
     * @param array $instance The settings for the particular instance of the widget
     *
     * @return bool true      Always return true
     */
    public function widget($args, $instance){
        // get all DB options
        $options = Core::get_all_options();

        // check to see if API settings are valid before displaying widget
        if(! $options || !$options['valid_api']){
            // else throw exception
            return $this->throw_exception('Your API settings are not valid.');
        }

        // get the title from the current instance
        if(isset($instance['title'])){
            $title = apply_filters('PPN', ($instance['title']));
        }

        // echo before_widget
        echo $args['before_widget'];

        // if title is not empty, echo before_title, title and after_title
        if(! empty($title)){
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // render the widget and pass the current instance
        $this->render($instance['theme'], $args, $instance);

        // echo after_widget
        echo $args['after_widget'];

        return true;
    }

    /**
     * Renders the widget given a theme and instance.
     *
     * @param string $theme The name of the theme to render
     *
     * @throws \Exception if the theme does not exist
     */
    private function render($theme, $args, $instance){
        $options = Core::get_all_options();

        // check if the theme has a template file
        if(file_exists(RS_TEMPLATE_PATH . '/' . $theme . '/template.php')){
            // enqueue jquery
            wp_enqueue_script('jquery');

            // enqueue the searchbox javascript
            wp_enqueue_script('rs_searchbox_js');

            // enqueue all stylesheets for the theme
            foreach($this->theme_files[$theme]['css'] as $item){
                wp_enqueue_style($item);
            }

            // enqueue all scripts for the theme
            foreach($this->theme_files[$theme]['js'] as $item){
                wp_enqueue_script($item);
            }

            // set some variables to be used in the template
            $instance_id = $args['widget_id'];
            $instance_num = preg_replace('/rs_searchbox-/', '', $instance_id);
            $refid = $options && $options['refid'] ? $options['refid'] : 2050;
            $hotel_enabled = $options && $options['products']['hotel'] && $instance['products']['hotel'];
            $car_enabled = $options && $options['products']['car'] && $instance['products']['car'];
            $air_enabled = $options && $options['products']['air'] && $instance['products']['air'];
            $vp_enabled = $options && $options['products']['vp'] && $instance['products']['vp'];
            $num_products = $hotel_enabled + $car_enabled + $air_enabled + $vp_enabled;
            $default_product = $hotel_enabled ? 'hotel' : ($car_enabled ? 'car' : ($air_enabled ? 'air' : ($vp_enabled ? 'vp' : false)));

            // check to see that we do in fact have a product enabled
            if($default_product){
                // include the template for the theme
                include(RS_TEMPLATE_PATH . '/' . $theme . '/template.php');

                // track widget load
                TRK::track(array(
                    'ec' => 'wordpress widget load',
                    'ea' => $_SERVER && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : get_site_url(),
                    'el' => $refid . ' - ' . $instance_id
                ));
            }else{
                // throw exception that no product was enabled
                try{
                    throw new \Exception('There are no products enabled.');
                }catch(\Exception $e){
                    $this->throw_exception($e->getMessage());
                }
            }
        }else{
            // if the theme is missing a template file, throw exception
            try{
                throw new \Exception('The theme "' . $theme . '" does not exist.');
            }catch(\Exception $e){
                $this->throw_exception($e->getMessage());
            }
        }
    }

    /**
     * Render an exception message.
     *
     * @param string $message The message to display
     */
    private function throw_exception($message){
        echo '<span style="font-weight: bold;">Error:</span> ' . $message;

        // track exception
        TRK::track(array(
            'ec' => 'wordpress widget error',
            'ea' => $_SERVER && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : get_site_url(),
            'el' => $message
        ));
    }

    /**
     * Render the widget's option pane.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance The instance of the widget
     */
    public function form($instance){
        // get all the options
        $options = Core::get_all_options();

        // check to see if API settings are valid before displaying widget
        if(! $options || !$options['valid_api']){
            return $this->throw_exception('Your API settings are not valid.');
        }

        // enqueue the css for the widget option box
        wp_enqueue_style('rs_widgets_css');

        // set the current_instance
        $this->current_instance = $instance;

        // get the current theme
        $current_theme = isset($instance['theme']) ? $instance['theme'] : 'default';

        // create an array of all the themes
        $themes = array();
        foreach(array_keys($this->theme_files) as $theme_name){
            $themes[] = array('id' => $theme_name, 'name' => ucfirst($theme_name), 'selected' => ($theme_name == $current_theme));
        }

        // start the widget options box
        echo '<div class="rs_widget_settings">';
        echo $this->add_field_input('title', 'Title:');
        echo $this->add_field_select('theme', 'Theme:', $themes);
        // product activations
        echo '<p>';
        if($options && $options['products']['hotel']){
            echo $this->add_field_checkbox('enable_hotel', 'Enable Hotel');
        }
        if($options && $options['products']['car']){
            echo $this->add_field_checkbox('enable_car', 'Enable Car');
        }
        if($options && $options['products']['air']){
            echo $this->add_field_checkbox('enable_air', 'Enable Air');
        }
        if($options && $options['products']['vp']){
            echo $this->add_field_checkbox('enable_vp', 'Enable Vacation Packages');
        }
        echo '</p>';
        // general settings
        echo $this->add_field_radio('enable_pet', 'Enable pet friendly:');
        echo $this->add_field_radio('new_window', 'Open searches in a new window:');
        echo $this->add_field_radio('auto_today', 'Auto-set to today\'s date:');
        echo $this->add_field_radio('auto_checkout', 'Auto-set check out to next day when check in is set:');
        // hotel settings
        if($options && $options['products']['hotel']){
            echo '<p>';
            echo '<h4 onclick="jQuery(this).next().slideToggle();">Hotel Settings <div class="arrow_down"></div></h4>';
            echo '<div class="rs_hotel_settings" style="display: none;">';
            echo $this->add_field_input('hotel_months', 'Number of months to show on the calendar:', array('input_class' => 'rs_input--small'));
            echo $this->add_field_input('hotel_input', 'Placeholder text for autosuggest input:');
            echo $this->add_field_radio('hotel_options', 'Show more options link:');
            echo $this->add_field_radio('hotel_airports_first', 'Show airports first:');
            echo $this->add_field_radio('hotel_autocomplete', 'Enable autocomplete:');
            // allowed hotel search types
            echo '<h5>Include</h5>';
            echo $this->add_field_radio('hotel_cities', 'Cities:', array('after' => $this->add_field_input('hotel_cities_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('hotel_airports', 'Airports:', array('after' => $this->add_field_input('hotel_airports_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('hotel_regions', 'Regions:', array('after' => $this->add_field_input('hotel_regions_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('hotel_pois', 'POIs:', array('after' => $this->add_field_input('hotel_pois_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('hotel_hotels', 'Hotels:', array('after' => $this->add_field_input('hotel_hotels_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo '</div>';
            echo '</p>';
        }
        // car settings
        if($options && $options['products']['car']){
            echo '<p>';
            echo '<h4 onclick="jQuery(this).next().slideToggle();">Car Settings</h4>';
            echo '<div class="rs_car_settings" style="display: none;">';
            echo $this->add_field_input('car_months', 'Number of months to show on the calendar:', array('input_class' => 'rs_input--small'));
            echo $this->add_field_input('car_input_origin', 'Placeholder text for origin:');
            echo $this->add_field_input('car_input_destination', 'Placeholder text for destination:');
            echo $this->add_field_radio('car_options', 'Show more options link:');
            echo $this->add_field_radio('car_airports_first', 'Show airports first:');
            echo $this->add_field_radio('car_autocomplete', 'Enable autocomplete:');
            // allowed car search types
            echo '<h5>Include</h5>';
            echo $this->add_field_radio('car_cities', 'Cities:', array('after' => $this->add_field_input('car_cities_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('car_airports', 'Airports:', array('after' => $this->add_field_input('car_airports_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo '</div>';
            echo '</p>';
        }
        // air settings
        if($options && $options['products']['air']){
            echo '<p>';
            echo '<h4 onclick="jQuery(this).next().slideToggle();">Air Settings</h4>';
            echo '<div class="rs_air_settings" style="display: none;">';
            echo $this->add_field_input('air_months', 'Number of months to show on the calendar:', array('input_class' => 'rs_input--small'));
            echo $this->add_field_input('air_input_origin', 'Placeholder text for origin:');
            echo $this->add_field_input('air_input_destination', 'Placeholder text for destination:');
            echo $this->add_field_radio('air_options', 'Show more options link:');
            echo $this->add_field_radio('air_airports_first', 'Show airports first:');
            echo $this->add_field_radio('air_autocomplete', 'Enable autocomplete:');
            // allowed air search types
            echo '<h5>Include</h5>';
            echo $this->add_field_radio('air_cities', 'Cities:', array('after' => $this->add_field_input('air_cities_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('air_airports', 'Airports:', array('after' => $this->add_field_input('air_airports_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo '</div>';
            echo '</p>';
        }
        // vp settings
        if($options && $options['products']['vp']){
            echo '<p>';
            echo '<h4 onclick="jQuery(this).next().slideToggle();">Vacation Packages Settings</h4>';
            echo '<div class="rs_vp_settings" style="display: none;">';
            echo $this->add_field_input('vp_months', 'Number of months to show on the calendar:', array('input_class' => 'rs_input--small'));
            echo $this->add_field_input('vp_input_origin', 'Placeholder text for origin:');
            echo $this->add_field_input('vp_input_destination', 'Placeholder text for destination:');
            echo $this->add_field_radio('vp_options', 'Show more options link:');
            echo $this->add_field_radio('vp_airports_first', 'Show airports first:');
            echo $this->add_field_radio('vp_autocomplete', 'Enable autocomplete:');
            // allowed vp search types
            echo '<h5>Include</h5>';
            echo $this->add_field_radio('vp_cities', 'Cities:', array('after' => $this->add_field_input('vp_cities_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo $this->add_field_radio('vp_airports', 'Airports:', array('after' => $this->add_field_input('vp_airports_num', 'Number to show:', array('input_class' => 'rs_input--small', 'no_p' => true, 'no_br' => true))));
            echo '</div>';
            echo '</p>';
        }
        echo '</div>';
    }

    /**
     * Generate an input field from parameters.
     *
     * @param string $id    The ID and name of the input
     * @param string $label The label for the input
     * @param array $args   Arguments array containing settings for the input
     *
     * @return string       A label and input
     */
    private function add_field_input($id, $label, $args = array()){
        $output = '';

        // get current value for the input from the current instance
        if(isset($this->current_instance[$id])){
            $value = $this->current_instance[$id];
        }else{
            // else get the default value
            $value = $this->all_options[$id];
        }

        if(! isset($args['no_p'])){
            $output .= '<p>';
        }

        $output .= '<label for="' . $this->get_field_id($id) . '">' . __($label, RS_TEXT_DOMAIN) . '</label>' . (! isset($args['no_br']) ? '<br />' : '');
        $output .= '<input class="' . (isset($args['input_class']) ? $args['input_class'] : 'widefat') . '" id="' . $this->get_field_id($id) . '" name="' . $this->get_field_name($id) . '" type="text" value="' . $value . '">';

        if(! isset($args['no_p'])){
            $output .= '</p>';
        }

        return $output;
    }

    /**
     * Generate a radio field from parameters.
     *
     * @param string $id    The ID and name of the radio field
     * @param string $label The label for the radio field
     * @param array $args   Arguments array containing settings for the radio field
     *
     * @return string       A yes and no radio group and label
     */
    private function add_field_radio($id, $label, $args = array()){
        $output = '';

        // get current instance value
        if(isset($this->current_instance[$id])){
            $checked = $this->current_instance[$id];
        }else{
            // else get the default value
            $checked = $this->all_options[$id];
        }

        $output .= '<p>';
        $output .= __($label, RS_TEXT_DOMAIN) . '<br />';
        $output .= '<span class="rs_option_box">';
            $output .= '<input class="checkbox" id="' . $this->get_field_id($id . '_yes') . '" name="' . $this->get_field_name($id) . '" type="radio" value="1"' . ($checked ? ' checked' : '') . '>';
            $output .= '<label for="' . $this->get_field_id($id . '_yes') . '">' . __('Yes', RS_TEXT_DOMAIN) . '</label>';
        $output .= '</span><span class="rs_option_box">';
            $output .= '<input class="checkbox" id="' . $this->get_field_id($id . '_no') . '" name="' . $this->get_field_name($id) . '" type="radio" value="0"' . (!$checked ? ' checked' : '') . '>';
            $output .= '<label for="' . $this->get_field_id($id . '_no') . '">' . __('No', RS_TEXT_DOMAIN) . '</label>';
        $output .= '</span>';

        if(isset($args['after'])){
            $output .= '<span class="rs_option_box--med">' . $args['after'] . '</span>';
        }

        $output .= '</p>';

        return $output;
    }

    /**
     * Generate a checkbox field from parameters.
     *
     * @param string $id    The ID and name of the checkbox
     * @param string $label The label for the checkbox
     * @param array $args   Arguments array containing settings for the checkbox
     *
     * @return string       A checkbox and label
     */
    private function add_field_checkbox($id, $label, $args = array()){
        $output = '';

        // get current instance value
        if(isset($this->current_instance[$id])){
            $checked = $this->current_instance[$id];
        }else{
            // else get the default value
            $checked = $this->all_options[$id];
        }

        $output .= '<div>';
        $output .= '<input class="checkbox" id="' . $this->get_field_id($id) . '" name="' . $this->get_field_name($id) . '" type="checkbox" value="1"' . ($checked ? ' checked' : '') . '>';
        $output .= '<label for="' . $this->get_field_id($id) . '">' . __($label, RS_TEXT_DOMAIN) . '</label>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Generate a select field from parameters.
     *
     * @param string $id    The ID and name of the select box
     * @param string $label The label for the select box
     * @param array $data   Array of options for the select box
     * @param array $args   Arguments array containing settings for the select box
     *
     * @return string       A select box and label
     */
    private function add_field_select($id, $label, $data = array(), $args = array()){
        $output = '';

        $output .= '<p>';
        $output .= '<label for="' . $this->get_field_id($id) . '">' . __($label, RS_TEXT_DOMAIN) . '</label>';
        $output .= '<select id="' . $this->get_field_id($id) . '" name="' . $this->get_field_name($id) . '" class="widefat">';
        foreach($data as $theme){
            $output .= '<option value="' . $theme['id'] . '"' . ($theme['selected'] ? ' selected' : '') . '>' . __($theme['name'], RS_TEXT_DOMAIN) . '</option>';
        }
        $output .= '</select>';
        $output .= '</p>';

        return $output;
    }

    /**
     * Updates the instance with new values from the widget options form.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance The new instance and it's values
     * @param array $old_instance The old instance and it's values
     *
     * @return array              Updated instance
     */
    public function update($new_instance, $old_instance){
        $instance = array();

        // create array of enabled products
        $products = array('hotel' => strip_tags($new_instance['enable_hotel']), 'car' => strip_tags($new_instance['enable_car']), 'air' => strip_tags($new_instance['enable_air']), 'vp' => strip_tags($new_instance['enable_vp']));

        // set product array
        $instance['products'] = $products;

        // loop through all options
        foreach($this->all_options as $option => $default){
            // check if we have a new value for an option, or use the default value
            $instance[$option] = isset($new_instance[$option]) ? strip_tags($new_instance[$option]) : $default;
        }

        // return the updated instance
        return $instance;
    }
}