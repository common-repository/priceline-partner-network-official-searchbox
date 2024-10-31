<?php

// disable file editing
defined('ABSPATH') or die('Please do not edit!');

// if uninstall not called from WordPress exit
if(! defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

require_once(plugin_dir_path(__FILE__) . 'includes/trk.php');

// delete options from options table
delete_option('rs_searchbox_options');

// track delete
\PPN\TRK::track(array(
   'ec' => 'searchbox wp uninstall',
   'ea' => $_SERVER && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : get_site_url(),
   'el' => ''
));