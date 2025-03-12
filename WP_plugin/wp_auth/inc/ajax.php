<?php

function wp_auth_do_login()
{  
      $user_email = sanitize_text_field($_POST['user_email']);
      $user_password = sanitize_text_field($_POST['user_password']);
      $validation_result = wp_auth_validate_email_and_password($user_email, $user_password);


   ///         the problem was started from here i can get this two in preview output
   //   var_dump($user_email, $user_password);
   //   var_dump($validation_result);

   if(!$validation_result['is_valid']){

         wp_send_json([
               'success' => false,
               'message' => $validation_result['message'],
         ], 403);

   }


   $user = wp_authenticate_email_password(null, $user_email, $user_password);
   if(is_wp_error($user)){

      wp_send_json([
         'success' => false,
         'message' => 'There is no user with this information',
      ], 403);      
   }
   
   $loginResult =  wp_signon([
      'user_login' => $user->user_login,
      'user_password' => $user_password,
      'remember' => false
   ]);
   if(is_wp_error($loginResult))
   {
      wp_send_json([
         'success' => false,
         'message' => 'Can not access to site try again later!',
      ], 403);
   }
   wp_send_json([
      'success' => true,
      'message' => 'mission Done',
   ], 200);
};


add_action('wp_ajax_wp_auth_login', 'wp_auth_do_login'); // if there is nopriv add this ajax work only for users have account in our site


function wp_auth_validate_email_and_password ($email, $password)
{
      // this is default
      $result = [
         'is_valid' => true,
         'message' => ''
      ];
      // but if this condition happen these execute
      if(is_null($email) || empty($email)){
         $result['is_valid'] = false;
         $result['message'] = 'Email can leave Empty🤬';
         return $result;
      }
      if(is_null($password) || empty($password)){
         $result['is_valid'] = false;
         $result['message'] = 'Password can leave Empty🥵';
         return $result;
      }
      if(!is_email($email)){
         $result['is_valid'] = false;
         $result['message'] = 'Email is invalid !!🙄';
         return $result;
      }

      return $result;
}