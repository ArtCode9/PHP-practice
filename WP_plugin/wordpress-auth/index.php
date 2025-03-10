<?php
/* 
Plugin Name: wordpress-auth
Plugin URI:  https://example.com
Description: plugin for manage auth
Author: Art_Code
Author URI: https://example.com
Text Domain: wordpress-auth
Domain Path: /languages/
Version: 1.0.0
*/


define('WP_AUTH_DIR', plugin_dir_path(__FILE__));
define('WP_AUTH_URL', plugin_dir_url(__FILE__));
define('WP_AUTH_INC', WP_AUTH_DIR . '/inc/');
define('WP_AUTH_TPL', WP_AUTH_DIR . '/tpl/');



//after add js and css file now we add it below
include WP_AUTH_INC . "functions.php";

// after we create the shortcode file we include that here and after active plugin we access those shortcode
include WP_AUTH_INC . "shortCode.php";
