//  keeps going
jQuery(document).ready(function ($) {

   // login section
   $('#loginForm').on('submit', function (event){

      event.preventDefault();

            let userEmail = $('#user-email').val();
            let userPassword = $('#user-password').val();
            let notify = $('.alert');

               $.ajax({
                        url: '/wp-admin/admin-ajax.php', // this is the adress where request send to
                        type: 'post',
                        dataType: 'json',
                        data: {
                                 action: 'wp_auth_login',
                                 user_email: userEmail,
                                 user_password: userPassword                          
                        },
                        success: function (response) {


                        },
                        error: function (error) {
                              // console.log(error.responseJSON); 
                              
                              if(error)
                              {
                                 let message = error.responseJSON.message;
                                 

                                 notify.addClass('alert-error');
                                 notify.append('<p>'+ message +'</p>');
                                 notify.css('display', 'block');
                                 notify.delay(2000).hide(300);

                              }
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


            $.ajax({
                  url: '/wp-admin/admin-ajax.php', // this is the adress where request send to
                  type: 'post',
                  dataType: 'json',
                  data: {
                        action: 'wp_auth_register',
                        user_first_name: firstName,
                        user_last_name: lastName,
                        user_email: userEmail,
                        user_password: userPassword
                  },
                  success: function (response) {},
                  error: function (error) {
                     // console.log(error);
                                 notify.addClass('alert-error');
                                 notify.append('<p>fatale Error happen</p>');
                                 notify.css('display', 'block');
                  }
            });
   });

});
//          Thats Done yes yes 🥳🥳🥳
