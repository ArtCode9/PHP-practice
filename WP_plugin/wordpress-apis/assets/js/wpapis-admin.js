// alert('loaded from admin');

// Here we work for first time on jquery

jQuery(document).ready(function ($){

   $('#sendAjaxRequest').on('click', function (event) {
      
      $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'post',
            dataType: 'json',
            data: {
               action:'calculate_operation',
               numberOne: 25,
               numberTwo: 87
            },
            success: function(response) {
               alert(response.result);
               console.log(response);
            },
            error: function(error) {}
      });
      
   });

});