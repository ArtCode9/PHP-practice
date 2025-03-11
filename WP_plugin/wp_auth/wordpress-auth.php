<?php
/*
Plugin Name: wordpress auth
Plugin URI: http://www.example.com
Description: This is not just a plugin is lvl up skill
Author: Art Code9
Author URI: www.artcode9.com
Text Domain: wordpress-auth
Domain Path: /languages/
Version: 1.0.0
*/

define('WP_AUTH_DIR', plugin_dir_path(__FILE__));
define('WP_AUTH_URL', plugin_dir_url(__FILE__));
define('WP_AUTH_INC', WP_AUTH_DIR . '/inc/');
define('WP_AUTH_TPL', WP_AUTH_DIR . '/tpl/');


include WP_AUTH_INC . "functions.php";
include WP_AUTH_INC . "shortcodes.php";
include WP_AUTH_INC . "ajax.php";



