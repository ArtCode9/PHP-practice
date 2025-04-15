<?php 
/* 
   Plugin Name: ONE-plug
   Plugin URI: www.artcode9.com
   Version: 1.0.0
   Description: This is a new plugin ONE
   Author: artcode
   Author URI: www.artcode.com
*/

defined('ABSPATH') || exit;

// define constant
define('ONE_PLUG_VERSION', '1.0.0');
define('ONE_PLUG_DIR' , plugin_dir_path(__FILE__));
define('ONE_PLUG_URI' , plugin_dir_url(__FILE__));


// load file
require_once ONE_PLUG_DIR . 'inc/function.php';
require_once ONE_PLUG_DIR . 'inc/short.php';


// add action
add_action('admin_menu', 'add_submenu_admin');
add_action('wp_enqueue_scripts' , 'my_plugin_style');
add_action('admin_enqueue_scripts' , 'admin_plugin_style');

// add shortcode
add_shortcode('hello', 'shortcode_handler');
add_shortcode('form' , 'form_handler');
