<?php

function wp_auth_load_assets()
{

   wp_register_style('wp_auth_style', WP_AUTH_URL . 'assets/css/auth.css');
   wp_enqueue_style('wp_auth_style');

   wp_register_script('wp_auth_script', WP_AUTH_URL . 'assets/js/auth.js', ['jquery']);
   wp_enqueue_script('wp_auth_script');
   
};

function enqueue_custom_script() {
   wp_enqueue_script('custom-script', 'path-to-your-script.js', array('jquery'), null, true);
   
   // Localize the script to add the admin-ajax URL and nonce
   wp_localize_script('custom-script', 'ajax_data', array(
       'ajaxurl' => admin_url('admin-ajax.php'),
       'nonce'   => wp_create_nonce('wp_auth_nonce')  // For security
   ));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');

add_action('wp_enqueue_scripts', 'wp_auth_load_assets');