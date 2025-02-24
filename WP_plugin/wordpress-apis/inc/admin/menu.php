<?php
//  all the code want to execute from admin is from here

// actions
// this code add menu in your admin page 
add_action('admin_menu', 'wp_apis_register_menus');
 
// functions
function wp_apis_register_menus(){

      // search about this function in document
      add_menu_page(
         'ArtCode setting',
         'plugin setting',
         'manage_options',
         'wp_apis_admin',
         'wp_apis_main_menu_handler',  // the name of function
      );
      //  submenu 1
      add_submenu_page(
         'wp_apis_admin',
         'Public',
         'public',
         'manage_options',
         'wp_apis_general',
         'wp_apis_general_page'
      );
      //  submenu 2
      add_submenu_page(
         'wp_apis_admin',
         'Theme',
         'Theme',
         'manage_options',
         'wp_apis_theme',
         'wp_apis_general_theme'
      );
   
      //  submenu 3
      add_submenu_page(
         'wp_apis_admin',
         'User',
         'User',
         'manage_options',
         'wp_apis_user',
         'wp_apis_users'
      );


         add_submenu_page(
         'wp_apis_admin',
         'Batman',
         'Batman',
         'manage_options',
         'wp_apis_batman',
         'wp_apis_batman2'
      );
};

// we use this function inside menu  add_menu_page()  function above
function wp_apis_main_menu_handler(){
     
   $user_data = [
      'firstName' => 'Art',
      'lastName'  => 'Tavan'
   ];


   // in php for get data coming from a form sent by post method we user a per-define var
   if(isset($_POST['saveSetting'])){   //  $_POST  is super global
      
      // $is_plugin_active = isset($_POST['active_plugin']) ? 1 : 0;
      // echo $is_plugin_active;
      //var_dump($is_plugin_active);

      if(isset($_POST['active_plugin'])){
         // for save and update the setting WP use this apis function to WP database
         //add_option('WP_ACTIVE', $is_plugin_active);
         update_option('WP_ACTIVE', 1);
      }else {
         delete_option('WP_ACTIVE');
      }
   }

   // before send form data and save the setting we get add_option name below
   $current_plugin_status = get_option('WP_ACTIVE', 0);

   // this user data define above can access from main.php include down here
   include WP_APIS_TPL.'admin/menus/main.php';
};



function wp_apis_general_page(){

   $user_data = [
      'firstName' => 'Code',
      'lastName'  => 'Lover'
   ];

   if(isset($_POST['option_save'])){

      if(isset($_POST['opt1']) && isset($_POST['opt2'])){
         update_option('WP_PUBLIC_OPTION', 1);
         echo"Public Option is active";
      }else{
         delete_option('WP_PUBLIC_OPTION');
         echo"Public Option is not active";
      }
   }
   $current_public_ = get_option('WP_PUBLIC_OPTION', 0);

   include WP_APIS_TPL.'admin/menus/public.php';
};



function wp_apis_general_theme(){

   $theme = [
      'firstTheme' => 'light',
      'secondTheme' => 'dark'
   ];
   
   include WP_APIS_TPL.'admin/menus/theme.php';
};



function wp_apis_users(){

   if(isset($_POST['saveVip'])){
    
      if(isset($_POST['vip_mode'])){
         update_option('WP_VIP', 1);
         echo"Vip user on";
      }else{
         delete_option('WP_VIP');
         echo"Vip user off";
      }
   }

   $current_VIP = get_option('WP_VIP', 0);

   include WP_APIS_TPL.'admin/menus/user.php';
}

   function wp_apis_batman2(){

      if(isset($_POST['call_batman'])){

         if(isset($_POST['batman_car'])){
            update_option('batman_fly_on', 1);
            echo"Batman on mission do not disturb";
         }else{
            delete_option('batman_fly_on');
            ecHO"Batman is resting for a while";
         }
      }

      $batman_fly = get_option('batman_fly_on' ,0);
      include WP_APIS_TPL.'admin/menus/user2.php';
   }

?>