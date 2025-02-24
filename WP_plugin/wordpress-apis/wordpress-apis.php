<?php
/* 
Plugin Name: wordpress apis
Plugin URI:  https://example.com
Description: APIs on wordpress
Author: art code
Author URI: https://example.com
Text Domain: wordpressApis
Domain Path: /languages/
Version: 1.0.0
*/

define('WP_APIS_DIR', plugin_dir_path(__FILE__));
define('WP_APIS_URL', plugin_dir_url(__FILE__));
define('WP_APIS_INC', WP_APIS_DIR.'/inc/');
define('WP_APIS_TPL', WP_APIS_DIR.'/tpl/');


register_activation_hook(__FILE__, 'wp_apis_plugin_activation');
register_deactivation_hook(__FILE__, 'wp_apis_plugin_deactivation');


function wp_apis_plugin_activation(){
   echo"this is wordpress-apis";
};
function wp_apis_plugin_deactivation(){
   echo"this is wordpress-plugin";
};
//  after we learn about array we can build option for plugin for users


// here we add menu.php file from admin directory
if(is_admin()){
   include WP_APIS_INC.'admin/menu.php';
   include WP_APIS_INC.'admin/metaboxes.php';
};

?>