<?php
/* 
Plugin Name: Simple Plugin
Plugin URI:  https://example.com
Description: a simple plugin.
Author: art code
Author URI: https://example.com
Text Domain: simplePlugin
Domain Path: /languages/
Version: 1.0.0
*/

// define constant in php and two WP function: 1) plugin_dir_path  and 2)  plugin_dir_url
define('PLUGIN_DIR' , 10);
define('PLUGIN_DIR_PATH', plugin_dir_path(__FILE__)); // this my plugin path dir
define('PLUGIN_URL', plugin_dir_url(__FILE__));  // this is my url dir
define('PLUGIN_INC', PLUGIN_DIR_PATH."/inc/");


echo PLUGIN_DIR;
echo"<br>";
echo PLUGIN_DIR_PATH; 
echo"<br>";
echo PLUGIN_URL; 
echo"<br>";
echo"this is simple plugin coming";

function simple_plugin_activation(){
   echo "this is simple plugin activation";         
};
function simple_plugin_deactivation(){
   echo "this is simple plugin deactivation";
};
register_activation_hook(__FILE__, 'simple_plugin_activation');
register_deactivation_hook(__FILE__, 'simple_plugin_deactivation');


if(is_admin()){
   //  include PLUGIN_INC."admin/amenu.php";
   include PLUGIN_INC."admin/bmenu.php";
}else{
   include PLUGIN_INC."user/umenu.php";
}
include PLUGIN_INC."common/public.php";


?>