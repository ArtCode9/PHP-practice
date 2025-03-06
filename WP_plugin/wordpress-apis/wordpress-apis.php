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

   // here we add rule for user with add_role function to main user section of wordpress
      add_role(
         'shop_manager',
         'Shop Manager',
         [
            'read' => true,
            'edit_posts' => true,
            'remove_products'
         ]
      );

// here we add Cap to role with add_cap function for all users with extra options
      $role = get_role('administrator');
      $role->add_cap('remove_products');

};
function wp_apis_plugin_deactivation(){

   echo "the wordpress-apis plugin is deActive!";

};
//  after we learn about array we can build option for plugin for users


// here we add menu.php file from admin directory
if(is_admin()){
   include WP_APIS_INC . 'admin/menu.php';
   include WP_APIS_INC . 'admin/metaboxes.php';
};

   include WP_APIS_INC . 'ajax.php';

// =---=-==-=-==-=-=-==-=-=-=-=-=-=-=-=-=-=-=-==-=
// here we add css and js for wordpress with function  >>  wp_register_style();    (check doc)
function wpapis_register_styles(){
   // here we add style css to our pages
   error_log('wpapis_register_styles function called'); // Check your debug log
   wp_register_style('wpapis_main_style', WP_APIS_URL . 'assets/css/main.css', array(), false, 'all');
   wp_enqueue_style('wpapis_main_style');


// here we add js function  to our pages
// with this if  condition we just add this to admin user not main page of our website
   if(is_admin()){
      wp_register_script('wpapis-admin-scripts', WP_APIS_URL . 'assets/js/wpapis-admin.js');
      wp_enqueue_script('wpapis-admin-scripts');
   }else{
      wp_register_script('wpapis-scripts',
                          WP_APIS_URL . 'assets/js/wpais.js',
                          ['jquery'],
                          '1.5.0', 
                          true);

      wp_enqueue_script('wpapis-scripts');
   }   
};

add_action('wp_enqueue_scripts', 'wpapis_register_styles');
add_action('admin_enqueue_scripts', 'wpapis_register_styles');
