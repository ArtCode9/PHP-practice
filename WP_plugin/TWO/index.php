<?php 
/* 
PLugin Name: TWO-plug
Plugin URI: www.artcode9.com
Version: 2.0.0
Description: This is a new rebuild of one
Author: ArtCode9
Author URI: www.artcode9.com
*/

defined('ABSPATH') || exit;

define('TOW_PLUG_VERSION' , '1.0.0');
define('TOW_PLUG_DIR' , plugin_dir_path(__FILE__));
define('TOW_PLUG_URL' , plugin_dir_url(__FILE__));


require_once TOW_PLUG_DIR . 'inc/functions.php';
require_once TOW_PLUG_DIR . 'inc/shortcodes.php';


//add action
add_action('admin_menu' , 'add_menu_admin_section');
add_action('admin_menu' , 'add_menu_admin_section_two');
add_action('wp_enqueue_scripts' , 'add_style_to_short');


//add shortcodes
add_shortcode('user_name' , 'add_first_shortcode');
