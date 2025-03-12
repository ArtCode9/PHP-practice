//  keeps going
jQuery(document).ready(function ($) {

   // login section
   $('#loginForm').on('submit', function (event){

      event.preventDefault();

            let userEmail = $('#user-email').val();
            let userPassword = $('#user-password').val();
            let notify = $('.alert');
            let ajaxurl = ajax_data.ajaxurl; // Will contain the correct URL.

               $.ajax({
                  url: ajaxurl, // this is the address where request send to
                        type: 'post',
                        dataType: 'json',
                        data: {
                                 action: 'wp_auth_login',
                                 user_email: userEmail,
                                 user_password: userPassword , 
                                 nonce: ajax_data.nonce  // Add the nonce for security                        
                        },
                        success: function (response) {
                           if(response.success){

                              notify.removeClass('alert-error').addClass('alert-success');
                              notify.html('<p>' + response.message + '</p>');
                              notify.css('display', 'block');
                              setTimeout(function () {
                                 window.location.href = 'http://localhost/wordpress/';
                              }, 2000);

                           }
                        },
                        error: function (error) {
                           console.log('The operation failed');
                           // Check if error.responseJSON exists and is an object
                           if (error.responseJSON && error.responseJSON.message) {
                               let message = error.responseJSON.message;
           
                               notify.addClass('alert-error');
                               notify.html('<p>' + message + '</p>');
                               notify.css('display', 'block');
                               notify.delay(2000).hide(300);
                           } else {
                               // Handle non-JSON errors
                               notify.addClass('alert-error');
                               notify.append('<p>Unexpected error occurred. Please try again later.</p>');
                               notify.css('display', 'block');
                               notify.delay(2000).hide(300);
                           }
                           /* console.log(`The operation is failed`);
                              console.log(error.responseJSON); 
                              
                              if(error)
                              {
                                 let message = error.responseJSON.message;
                                 
                                 notify.addClass('alert-error');
                                 notify.append('<p>'+ message +'</p>');
                                 notify.css('display', 'block');
                                 notify.delay(2000).hide(300);
                              } */
                        }
               });
   });

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

   // register section       
   $('#registerForm').on('submit', function (event) {

       event.preventDefault();
      
            let firstName = $('#user-name').val();
            let lastName  = $('#user-lastName').val();
            let userEmail = $('#user-email').val();
            let userPassword = $('#user-password').val();
            let notify = $('.alert');
            let ajaxurl = ajax_data.ajaxurl; // Will contain the correct URL.


            $.ajax({
                  url: ajaxurl, // this is the address where request send to
                  type: 'post',
                  dataType: 'json',
                  data: {
                        action: 'wp_auth_register',
                        user_first_name: firstName,
                        user_last_name: lastName,
                        user_email: userEmail,
                        user_password: userPassword,
                        nonce: ajax_data.nonce  // Add the nonce for security
                  },
                  success: function (response) {
                     if(response.success){

                        notify.removeClass('alert-error').addClass('alert-success');
                        notify.html('<p>' + response.message + '</p>');
                        notify.show(300);
                        notify.css('display', 'block');
                        setTimeout(function () {
                           window.location.href = 'http://localhost/wordpress/login-pages';
                        }, 2000);

                     }
                  },
                  error: function (error) {
                     console.log('The operation failed');
                     // Check if error.responseJSON exists and is an object
                     if (error.responseJSON && error.responseJSON.message) {
                         let message = error.responseJSON.message;
     
                         notify.addClass('alert-error');
                         notify.html('<p>' + message + '</p>');
                         notify.show();
                         notify.css('display', 'block');
                         notify.delay(2000).hide(300);
                     } else {
                         // Handle non-JSON errors
                         notify.addClass('alert-error');
                         notify.append('<p>Unexpected error occurred. Sign up failed.</p>');
                         notify.css('display', 'block');
                         notify.delay(2000).hide(300);
                     }
                  }
            });
   });

});
//          Thats Done yes yes 🥳🥳🥳
