<?php
//  all the code want to execute from admin is from here


// actions
// this code add menu in your admin page 
add_action('admin_menu', 'wp_apis_register_menus');
 

// functions
function wp_apis_register_menus(){

      // search about this function in document
      add_menu_page(
         'plugin setting',
         'plugin setting',
         'manage_options',
         'wp_apis_admin',
         'wp_apis_main_menu_handler',  // the name of function
      );
};

// we use this function inside menu  add_menu_page()  function above
function wp_apis_main_menu_handler(){
   
   $user_data = [
      'firstName' => 'Art',
      'lastName'  => 'Tavan'
   ];

   // this user data define above can access from main.php include down here

   include WP_APIS_TPL.'admin/menus/main.php';
   
   
   // in php for get data coming from a form sent by post method we user a per-define var
   if(isset($_POST['saveSetting'])){   //  $_POST  is super global
      var_dump($_POST);
   }
};  

?>