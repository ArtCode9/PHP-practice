<?php
/* 
   Plugin Name: three-plugin
   Plugin URI: www.artcode9.com
   Description: this is a third section of try create plugin
   Version: 1.0.0
   Author: art code 
   Author URI: www.artcode9.com
   Text Domain: third-plugin
*/

defined('ABSPATH') || exit;

define('THIRD_PLUGIN_VERSION' , '1.0.0');
define('THIRD_PLUGIN_DIR' , plugin_dir_path(__FILE__));
define('THIRD_PLUGIN_URL' , plugin_dir_url(__FILE__));



require_once THIRD_PLUGIN_DIR . 'includes/func.php';
require_once THIRD_PLUGIN_DIR . 'includes/short.php';





add_action('admin_menu', 'wp_admin_add_menu');
add_shortcode('short_section', 'add_short_code');