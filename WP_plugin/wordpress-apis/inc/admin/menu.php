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
         'user',
         'manage_options',
         'wp_apis_general',
         'wp_apis_general_page'
      );

      // submenu 2
      add_submenu_page(
         'wp_apis_admin',
         'form',
         'form login',
         'manage_options',
         'wp_apis_form',
         'wp_apis_form'
      );

      // submenu 3
      add_submenu_page(
         'wp_apis_admin',
         'Data wpdb',
         'Database Sql',
         'manage_options',
         'wp_apis_db',
         'wp_apis_db'
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

   include WP_APIS_TPL . 'admin/menus/public.php';
};

function wp_apis_form(){

      $user_data = [
         'firstName' => 'Art',
         'lastName'  => 'Coder'
      ];

      if(isset($_POST['save_feeling'])){
         if(isset($_POST['anger']) && isset($_POST['happy']) && isset($_POST['shy'])){
            update_option('WP_FEELING_ACTIVE', 1);
            echo "Your feeling is add to uni";
         }else{
            delete_option('WP_FEELING_ACTIVE');
            echo"Your feeling is remove from uni";
         }
      }
      $option = get_option('WP_FEELING_ACTIVE', 0);

      include WP_APIS_TPL . 'admin/menus/form.php';
};


function wp_apis_db(){

   // we use this api in function to get data from database and pass it to database.php page
   global $wpdb;

   // this section delete item from database ==== 
   $action = $_GET['action'];

   if($action == "delete")
   {
      $item = intval($_GET['item']);

      if($item > 0)
      {  
                    // $wpdb->prefix.'the name of table' 
         $wpdb->delete('batman_t', ['id' => $item]);
      }
   }
   //  =================================
   //  this section add item into database
   if($action == "add")
   {
      if(isset($_POST['saveData'])){
            
        $wpdb->insert('batman_t' , [
            'firstName' => $_POST['firstName'],
            'lastName'  => $_POST['lastName'],
            'mobile'    => $_POST['mobile']
        ]);
      }

      include WP_APIS_TPL . 'admin/menus/add.php';

   }else{

      $samples = $wpdb->get_results("SELECT * FROM batman_t");
      
      include WP_APIS_TPL . 'admin/menus/database.php';
   }

   
};

?>