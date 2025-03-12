<?php

// login section 

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
   ///    login section work correctly Done 
// -=-==-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// register section

   function wp_auth_do_register(){
      
      // var_dump($_POST); // this did not work
      $user_first_name = sanitize_text_field($_POST['user-name']);
      $user_last_name = sanitize_text_field($_POST['user-lastName']);
      $user_email = sanitize_text_field($_POST['user-email']);
      $user_password = sanitize_text_field($_POST['user-password']);

      //var_dump($user_first_name, $user_last_name, $user_email, $user_password); // this did not work

      $validation_result = validate_register_request($user_first_name, $user_last_name, $user_email, $user_password);
      if(!$validation_result['is_valid']){
         wp_send_json([
            'success' => false,
            'message' => $validation_result['message'],
         ], 422);
      }

      // here we register new user with this 👇
      $userEmailParts = explode('@', $user_email);

      $newUser = wp_insert_user([
         'user_login' => apply_filters('pre_user_login', $userEmailParts[0] . rand(1000, 9999)),
         'user_pass' => apply_filters('pre_user_pass', $user_password),
         'user_email' => apply_filters('pre_user_email', $user_email),
         'first_name' => apply_filters('pre_user_first_name', $user_first_name),
         'last_name' => apply_filters('pre_user_last_name', $user_last_name),
         'display_name' => apply_filters('pre_user_display_name', "{$user_first_name} {$user_last_name}")
      ]);

      if(is_wp_error($newUser))
      {
         wp_send_json([
            'success' => false,
            'message' => "Something Wrong from your sign up operation"
         ], 500);
      }
         wp_send_json([
            'success' => true,
            'message' => "sign up Done"
         ], 200);

   }

   function validate_register_request($first_name, $last_name, $email, $password) {      
      
         $result = [
            'is_valid' => true,
            'message' => ""
         ];

         if(empty($first_name) || empty($last_name) || empty($email) || empty($password)) 
         {
            $result['is_valid'] = false;
            $result['message'] = "You should fill all input";
            return $result;
         }
         if(!is_email($email))
         {
            $result['is_valid'] = false;
            $result['message'] = "Email input is not valid";
            return $result;
         }
         // now we check the email does not to belong anyone else
         if(email_exists($email))
         {
            $result['is_valid'] = false;
            $result['message'] = "This email is already use";
            return $result;
         }

         return $result;
   }  

add_action('wp_ajax_wp_auth_login', 'wp_auth_do_login'); // if there is nopriv add this ajax work only for users have account in our site
add_action('wp_ajax_wp_auth_register', 'wp_auth_do_register'); 