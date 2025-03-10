jQuery(document).ready(function ($) {

   $('#loginForm').on('submit', function (event){

      event.preventDefault();
      // alert('js work');     // this is for check js work on button form
      let user_email = $('#userEmail').val();
      let user_password = $('#userPassword').val();
      let notify = $('.alert');

      // now we execute the ajax
      $.ajax({
               url: 'wp-admin/admin-ajax.php',
               type: 'post',
               dataType: 'json',
               data: {
                  action: 'wp_auth_login',
                  user_email: user_email,
                  user_password: user_password
               },
               success: function (resposne) { 
                  console.log(resposne);


               },
               error: function (error) { 
                  console.log(error);
                  if(error) {
                        notify.addClass('alert-error');
                        notify.append('<p>Error happing</p>');
                        notify.css('display', 'block');
                  }
               }
      });
   });


   $('#registerForm').on('submit', function (event) {

      event.preventDefault();
      //alert('register js add');  // this is for check js work on button form
      let first_name = $('#user_Name').val();
      let last_name = $('#user_LastName').val();
      let user_email = $('#user_Email').val();
      let user_password = $('#user_Password').val();
      let notify = $('.alert');

      $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'post',
            dataType: 'json',
            data: {
                  action: 'wp_auth_register',
                  user_first_name: first_name,
                  user_last_name: last_name,
                  user_email: user_email,
                  user_password: user_password 
            },
            success: function (resposne) {
               console.log(resposne);
            },
            error: function (error) {
               console.log(error);
               if(error){
                     notify.addClass('alert-error');
                     notify.append('<p>Error happing sign up falied</p>');
                     notify.css('display', 'block');
               }            
            }
      });
   });
});