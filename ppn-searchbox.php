<?php
/**
 * Plugin Name: Priceline Partner Network Official Searchbox
 * Plugin URI: http://www.pricelinepartnernetwork.com
 * Description: The official plugin for Priceline Partner Network that will add a searchbox to your page.
 * Author: Priceline Partner Network
 * Author URI: http://www.pricelinepartnernetwork.com
 * Version: 1.1.0
 */

// disable file editing
defined('ABSPATH') or die('Please do not edit!');

// check if page is being loaded directly and exit
if(! defined('WPINC')){
    die;
}

// define plugin constants
define('RS_PLUGIN_NAME', 'PPN Official Searchbox');
define('RS_PLUGIN_VERSION', '1.1.0');
define('RS_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('RS_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('RS_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('RS_PLUGIN_IMG_DIR', (RS_PLUGIN_DIR_URL . 'images'));
define('RS_PLUGIN_CSS_DIR', (RS_PLUGIN_DIR_URL . 'css'));
define('RS_PLUGIN_JS_DIR', (RS_PLUGIN_DIR_URL . 'js'));
define('RS_PLUGIN_INC_DIR', (RS_PLUGIN_DIR_PATH . 'includes'));
define('RS_TEMPLATE_PATH', (RS_PLUGIN_DIR_PATH . 'themes'));
define('RS_TEMPLATE_URL', (RS_PLUGIN_DIR_URL . 'themes'));
define('RS_TEXT_DOMAIN', 'rs_text_domain');
define('RS_DEFAULT_REFID', 2050);
define('RS_WP_VERSION', get_bloginfo('version'));

// require components
require_once(RS_PLUGIN_INC_DIR . '/core.php');
require_once(RS_PLUGIN_INC_DIR . '/widget.php');
require_once(RS_PLUGIN_INC_DIR . '/trk.php');

// create new core
$core = new PPN\Core();