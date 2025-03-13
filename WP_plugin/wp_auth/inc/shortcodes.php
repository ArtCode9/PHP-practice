<?php

function wp_auth_login_handler ($atts, $content = null )
{
  $wp_auth_options = get_option('wp_auth_options', []); // now this wp_auth_options accessable in login section

   if (isset($wp_auth_options['is_login_active']) && !$wp_auth_options['is_login_active']){
         return '<div><p>Login is out of order</p></div>';
   }

         include WP_AUTH_TPL . "front/login.php";
};

function wp_auth_register_handler ($atts, $content = null)
{
   $wp_auth_options = get_option('wp_auth_options', []); // now this wp_auth_options accessable in login section

   if (isset($wp_auth_options['is_register_active']) && !$wp_auth_options['is_register_active']){
      return '<div><p>Register is out of order try again later</p></div>';
   }   

         include WP_AUTH_TPL . "front/register.php";
}


add_shortcode('wp_auth_login', 'wp_auth_login_handler');
add_shortcode('wp_auth_register', 'wp_auth_register_handler');