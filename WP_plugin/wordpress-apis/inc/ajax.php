<?php

// in fact we invoke a hook with ajax
// all the ajax action should starts with wp_ajax_ 
add_action('wp_ajax_calculate_operation' , 'wp_apis_handle_ajax_operation');  // we add action in javascript define for ajax add after this


function wp_apis_handle_ajax_operation() 
{
   $numberOne = $_POST['numberOne'];
   $numberTwo = $_POST['numberTwo'];

   wp_send_json([
      'success' => true,
      'result'  => $numberOne + $numberTwo
   ]);

}