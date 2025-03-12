<?php

function wp_auth_admin_settings()
{

      add_menu_page(
         'Enter and sign up',
         'Enter and sign up',
         'manage_options',
         'wp_auth',
         'wp_auth_settings'
      );

};

function wp_auth_settings() 
{
   $wp_auth_options = get_option('wp_auth_options', []);

   //var_dump($wp_auth_options);

   if(isset($_POST['savaData']))
   {
      var_dump($_POST);
      
      $wp_auth_options['is_login_active'] = isset($_POST['is_login_active']);
      $wp_auth_options['is_register_active'] = isset($_POST['is_register_active']);
      $wp_auth_options['login_form_title'] = sanitize_text_field($_POST['login_form_title']);
      $wp_auth_options['register_form_title'] = sanitize_text_field($_POST['register_form_title']);

      update_option('wp_auth_options', $wp_auth_options);
   }

   include WP_AUTH_TPL . "admin/settings.php";
}

add_action('admin_menu', 'wp_auth_admin_settings');