<?php
/*
   Plugin Name: Simple Login & Signup
   Plugin URI: www.example.com
   Description: A simple plugin create  with AI 
   Version: 1.0.0
   Author: ArtCode
   Author URI: www.artcode.com
*/

if(!defined('ABSPATH')){
   exit;
}

// shortcode for the login form
function simple_login_form() {
 
   include "login.php";
}

// shortcode for the signup form
function simple_signup_form(){

      $output = '<form action="" method="post">';
      $output .= '<label for="username">Username</label>';
      $output .= '<input type="text" name="username" placeholder="Username" required>';
      $output .= '<label for="password">Password</label>';
      $output .= '<input type="password" name="password" placeholder="Password" required>';
      $output .= '<input type="submit" name="sub-but" value="login">';
      $output .= '</form>';
      return $output;
}


function ssf_signup_form() {
      ob_start(); // Start output buffering
      ?>
         <form id="ssf-signup-form" method="post" style="border:4px solid lightseagreen;border-radius: 19px; padding: 9px;">
               <label for="ssf-name">Name:</label>
               <input type="text" name="ssf-name" id="ssf-name" required> <br>

               <label for="ssd-email">Email:</label>
               <input type="email" name="ssf-email" id="ssf-email" required><br>

               <input type="submit" name="ssf-submit" value="Sign up">
         </form>
      <?php
      return ob_get_clean(); // Return the buffered content
};

function ssf_handle_form_submission() {
   if (isset($_POST['ssf_submit'])) {
       $name = sanitize_text_field($_POST['ssf_name']);
       $email = sanitize_email($_POST['ssf_email']);

       if (!empty($name) && !empty($email)) {
           // Save the data to the database
           global $wpdb;
           $table_name = $wpdb->prefix . 'ssf_signups'; // Custom table name

           // Create the table if it doesn't exist
           if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
               $charset_collate = $wpdb->get_charset_collate();
               $sql = "CREATE TABLE $table_name (
                   id mediumint(9) NOT NULL AUTO_INCREMENT,
                   name varchar(255) NOT NULL,
                   email varchar(255) NOT NULL,
                   signup_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                   PRIMARY KEY (id)
               ) $charset_collate;";
               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               dbDelta($sql);
           }

           // Insert the data into the table
           $wpdb->insert(
               $table_name,
               array(
                   'name' => $name,
                   'email' => $email,
               )
           );

           // Display a success message
           echo '<p>Thank you for signing up, ' . esc_html($name) . '!</p>';
       } else {
           echo '<p>Please fill out all fields.</p>';
       }
   }
}


add_action('init', 'ssf_handle_form_submission');
add_shortcode('signup_form', 'ssf_signup_form');
add_shortcode('simple_login', 'simple_login_form');
add_shortcode('simple_signup', 'simple_signup_form');

