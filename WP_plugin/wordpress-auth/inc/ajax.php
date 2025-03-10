<?php 
// this file to handle ajax request 

function wp_auth_do_login (){

   //  this is security section add for all input come from login page to database
   $user_email = sanitize_text_field($_POST['user_email']);
   $user_password = sanitize_text_field($_POST['user_password']);
   $validation_result = wp_auth_validate_email_and_password($user_email, $user_password);

   if(!$validation_result['is_valid']){

      wp_send_json([
         'success' => false,
         'message' => $validation_result['message']
      ], 403);
   }
   // var_dump($validation_result);
};


add_action('wp_ajax_nopriv_wp_auth_login', 'wp_auth_do_login');
 

function wp_auth_validate_email_and_password($email, $password) 
{
      $result = [
                  'is_valid' => true,
                  'message' => " "
                ];    

            if(is_null($email) || empty($email)){
               $result['is_valid'] = false;
               $result['message'] = 'Email can be empty';
               return $result;
            }

            if(is_null($password) || empty($password)){
               $result['is_valid'] = false;
               $result['message'] = 'Password can not be empty';
               return $result;
            }

            if(!is_email($email)){
               $result['is_valid'] = false;
               $result['message'] = 'Email is not Correct and valid';
               return $result;
            } 

      return $result;
};