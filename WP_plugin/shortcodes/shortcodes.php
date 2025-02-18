<?php
    
/* 
Plugin Name: shortcodes
Plugin URI:  https://example.com
Description: This is my first plugin.
Author: art code
Author URI: https://example.com
Text Domain: short-codes
Domain Path: /languages/
Version: 1.0.0
*/

// login => function login(){}  
// we create shortcode with this shortcode

function login_shortC ($attributes){

   var_dump($attributes);
   $x = 15;
   if($x > 10){
        return '<h1>Wordpress '. $attributes['role'] .' page😁</h1>';   
   }else{     
        return '<h1>Wordpress Register page😁</h1>';
   }
};

function login_shortD($arr){
     var_dump($arr);
     $c = 14;
     if($c > 10){
          return '<h1>WP is'.$arr['name'].' terotry for action</h1>';
     }else 
     {
          return '<h1>Wordpress is to fly</h1>';
     }
};

add_shortcode('login', 'login_shortC');
add_shortcode('loginD', 'login_shortD');



