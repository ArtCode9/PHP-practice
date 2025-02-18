<?php
/* 
Plugin Name: Hooks Plugin
Plugin URI:  https://example.com
Description: This is my second plugin.
Author: art code
Author URI: https://example.com
Text Domain: myfirstplugin
Domain Path: /languages/
Version: 1.0.0
*/

// first function we focus on it in Wordpress is :  do_action();
// when we call this function in other word we call a many function beside and inside in
// and we can use it infin

function print_order_id(){
      print "Order Purchased!<br>";
};

function sent_order_email(){
      print "order Email send<br>";
};

function sent_order_sms(){
      print "order sms send<br>";
};
function sent_message(){
      echo"this is a last hope for rescue myself";
};

add_action('order_purchased', 'print_order_id');
add_action('order_purchased', 'sent_order_email');
add_action('order_purchased', 'sent_order_sms');
add_action('rescue', 'sent_message');

do_action('order_purchased'); // the first tag we inject is and order
                              // depend on app need Ex: order_purchased
do_action('rescue');
echo"<br>";

function update_order_price($order_price){
      return $order_price * 2;
};

function update_order_price2($order_price){
      return $order_price / 5;
};

function update_order_price3($order_price){
      return  $order_price + 3000;
};
function last_count($t){
      return $t + 7000;
};

add_filter('get_order_price', 'update_order_price');
add_filter('get_order_price', 'update_order_price2');
add_filter('get_order_price', 'update_order_price3');
add_filter('get_order_price', 'last_count');

$result = apply_filters('get_order_price', 25000);

print $result;


?>