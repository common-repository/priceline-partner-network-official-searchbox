<?php

namespace PPN;

// disable file editing
defined('ABSPATH') or die('Please do not edit!');

/**
 * Core class for the PPN plugin. Performs initial setup and creates settings page.
 *
 * @package PPN
 * @since 4.3.1
 */
class Core{

    /**
     * Class constructor. Perform initial setup.
     */
    public function __construct(){
        // add settings link on plugin page
        if(is_admin()){
            add_filter(('plugin_action_links_' . RS_PLUGIN_BASENAME), array(&$this, 'settings_link'));
        }

        // register all resources
        $this->register_resources();
    }

    /**
     * Adds a settings link on the plugin list page.
     *
     * @param array $links Array of current links on the plugins page
     *
     * @return array Array of final links for the plugin
     */
    public function settings_link($links){
        // add link to link array
        $links[] = '<a href="options-general.php?page=rs_searchbox">' . __('Settings', RS_TEXT_DOMAIN) . '</a>';

        return $links;
    }

    /**
     * Register all resources to be used later on.
     */
    public function register_resources(){
        // set hook to install
        register_activation_hook(RS_PLUGIN_BASENAME, array(&$this, 'install'));

        // settings page CSS
        wp_register_style('rs_settings_css', (RS_PLUGIN_CSS_DIR . '/rs_settings.css'));

        // widgets page CSS
        wp_register_style('rs_widgets_css', (RS_PLUGIN_CSS_DIR . '/rs_widgets.css'));

        // add menu options page
        add_action('admin_menu', array(&$this, 'add_options'));

        // add localization and internationalization
        add_action('plugins_loaded', array(&$this, 'localization'));

        // register and define the settings
        add_action('admin_init', array(&$this, 'admin_initialization'));

        // register the widget
        add_action('widgets_init',
            create_function('', 'return register_widget("PPN\Searchbox");')
        );
    }

    /**
     * Adds default values to db 'wp_options'.
     */
    public function install(){
        // default values
        $options = array(
            'refid' => '',
            'api_key' => '',
            'valid_api' => false,
            'products' => array(
                'hotel' => false,
                'car' => false,
                'air' => false,
                'vp' => false
            )
        );

        // update the DB with the default values
        update_option('rs_searchbox_options', $options);

        // track install
        TRK::track(array(
            'ec' => 'wordpress install',
            'ea' => $_SERVER && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : get_site_url(),
            'el' => ('RS_VERSION: ' . RS_PLUGIN_VERSION . ' | WP_VERSION: ' . RS_WP_VERSION)
        ));
    }

    /**
     * Adds a link under settings to the plugins settings page.
     */
    public function add_options(){
        // adds link to settings
        add_options_page(
            'PPN Searchbox Settings',               // Page title on browser bar
            'PPN Searchbox',                        // Menu item text
            'manage_options',                       // Only administrators can open this
            'rs_searchbox',                         // Unique name of settings page
            array(&$this, 'generate_settings_page') // Call to function which creates the form
        );
    }

    /**
     * Load the HTML for the settings page and require the CSS.
     */
    public function generate_settings_page(){
        // get CSS for settings page
        wp_enqueue_style('rs_settings_css');

        // get the template
        require(RS_PLUGIN_INC_DIR . '/settings_page.php');
    }

    /**
     * Register and render the inputs on the settings page.
     */
    public function admin_initialization(){
        // register the settings page
        register_setting(
            'rs_searchbox_settings',           // Option group
            'rs_searchbox_options',            // Option name
            array(&$this, 'validate_settings') // Sanitize inputs function
        );

        // add a settings section to the page
        add_settings_section(
            'rs_searchbox_main',                // ID of the section
            __('API Settings', RS_TEXT_DOMAIN), // Title of the section
            array(&$this, 'section_main'),      // Callback to add inputs to section
            'rs_searchbox'                      // Page name of settings page
        );
    }

    /**
     * Creates the main section for the settings page.
     */
    public function section_main(){
        echo '<p><em>' . __('Please enter and validate your API settings. These are required in order to use your searchbox.', RS_TEXT_DOMAIN) . '</em></p>';
        echo '<span id="rs_ajax_nonce" class="hidden" style="visibility: hidden;">' . wp_create_nonce('rs_ajax_nonce') . '</span>';

        // add input fields
        $this->add_field('refid', 'Your PPN refid:', 'main', array('text', 4, 10));
        $this->add_field('api_key', 'Your PPN API key:', 'main', array('text', 40, 46));
    }

    /**
     * Adds an input to a settings section.
     *
     * @param string $field   The name of the field
     * @param string $title   The type of field
     * @param string $section The section to add the field to
     * @param array  $args    Additional arguments for the input
     */
    private function add_field($field, $title, $section, $args = array()){
        // create args
        $field_args = array('field' => $field, 'type' => $args[0], 'length' => $args[1], 'size' => $args[2]);

        // add input field to a section
        add_settings_field(
            'rs_searchbox_' . $field,      // ID of the input
            __($title, RS_TEXT_DOMAIN),    // Title of the input
            array(&$this, 'create_input'), // Callback to create the input field
            'rs_searchbox',                // Page name of the settings page
            'rs_searchbox_' . $section,    // Section name to add the field to
            $field_args                    // Arguments passed to the callback
        );
    }

    /**
     * Create an input field from arguments.
     *
     * @param array $args The arguments of the input field
     */
    public function create_input($args){
        $output = '';

        // get values from DB
        $values = $this->get_all_options();

        $output .= '<input name="rs_searchbox_options[' . $args['field'] . ']" id="rs_option_' . $args['field'] . '" type="' . $args['type'] . '"';

        // set input max length
        if(! empty($args['length'])){
            $output .= ' maxlength="' . $args['length'] . '"';
        }

        // set input size
        if(! empty($args['size'])){
            $output .= ' size="' . $args['size'] . '"';
        }

        // check if we have value from DB and add it
        if($values && $values[$args['field']]){
            $output .= 'value="' . $values[$args['field']] . '" />';
        }else{
            $output .= 'value="" />';
        }

        echo $output;
    }

    /**
     * Validate the inputs on the settings page.
     *
     * @param array $input An array of input fields
     *
     * @return array|bool  Returns a sanitized input array or false if not valid
     */
    public function validate_settings($input){
        $new_input = array();
        $valid = true;

        // sanitize refid
        if(isset($input['refid'])){
            $new_input['refid'] = absint($input['refid']);
        }

        // sanitize api_key
        if(isset($input['api_key'])){
            $new_input['api_key'] = sanitize_text_field($input['api_key']);
        }

        // validate refid and api_key
        if(isset($new_input['refid']) && isset($new_input['api_key'])){
            // create a new HTTP request
            $request = new \WP_Http();

            // parameters to send to RefData
            $params = array(
                'format' => 'json2',
                'product_value' => 'all',
                'refid' => $new_input['refid'],
                'api_key' => $new_input['api_key']
            );

            // perform the request
            $result = $request->request('https://api.rezserver.com/api/shared/getWEB.RefData', array('method' => 'POST', 'body' => $params));

            // check if the response was valid
            if(isset($result['response']) && $result['response']['code'] == 200){
                // decode response
                $ref_data = json_decode($result['body']);

                if($ref_data){
                    $ref_data = $ref_data->{'getSharedWEB.RefData'};

                    // check error code
                    if(! isset($ref_data->error) && $ref_data->results->status_code == '100'){
                        // check if api is on and which products are enabled
                        $new_input['valid_api'] = $ref_data->results->ref_data->refid_on_off == '1';
                        $new_input['products'] = array(
                            'hotel' => $ref_data->results->ref_data->products->hotel->product_on_off == '1',
                            'car' => $ref_data->results->ref_data->products->car->product_on_off == '1',
                            'air' => $ref_data->results->ref_data->products->air->product_on_off == '1',
                            'vp' => $ref_data->results->ref_data->products->vp->product_on_off == '1'
                        );
                    }else{
                        $valid = false;
                        add_settings_error(
                            'rs_searchbox_options',                   // Name of the settings page
                            'rs_searchbox_texterror',                 // ID of the error
                            'Sorry, your credentials are not valid.', // Error message to display
                            'error'                                   // The type of error
                        );
                    }
                }else{
                    $valid = false;
                    add_settings_error(
                        'rs_searchbox_options',                                                           // Name of the settings page
                        'rs_searchbox_texterror',                                                         // ID of the error
                        'Sorry, there was an issue validating your credentials, please try again later.', // Error message to display
                        'error'                                                                           // The type of error
                    );
                }
            }else{
                $valid = false;
                add_settings_error(
                    'rs_searchbox_options',                                        // Name of the settings page
                    'rs_searchbox_texterror',                                      // ID of the error
                    'Sorry, an error occurred while validating your credentials.', // Error message to display
                    'error'                                                        // The type of error
                );
            }
        }else{
            $valid = false;
            add_settings_error(
                'rs_searchbox_options',                      // Name of the settings page
                'rs_searchbox_texterror',                    // ID of the error
                'Sorry, you must provide your credentials.', // Error message to display
                'error'                                      // The type of error
            );
        }

        // track validate
        TRK::track(array(
            'ec' => 'wordpress validate',
            'ea' => $_SERVER && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : get_site_url(),
            'el' => ('VALID: ' . ($valid ? 'Yes' : ('No' . (isset($ref_data->error) ? ' - ' . $ref_data->error->status_code : ''))) . ' | REFID: ' . $input['refid'] . ' | API_KEY: ' . $input['api_key'])
        ));

        // return valid inputs or false for not valid
        return $valid ? $new_input : false;
    }

    /**
     * Gets all options from the DB.
     *
     * @return array An array with all of the options from the DB
     */
    public static function get_all_options(){
        // Retrieve all options from DB
        $options = get_option('rs_searchbox_options');

        return $options;
    }

    /**
     * Gets a specific option from the DB.
     *
     * @param string $option The name of the option to get
     *
     * @return mixed|bool    The value of the option or false if it doesn't exist
     */
    public static function get_option($option){
        $options = self::get_all_options();

        return $options && isset($options[$option]) ? $options[$option] : false;
    }

    /**
     * Adds localization and internationalization to the searchbox.
     */
    public function localization(){
        load_plugin_textdomain(RS_TEXT_DOMAIN, false, (dirname(RS_PLUGIN_BASENAME) . '/languages/'));
    }
}