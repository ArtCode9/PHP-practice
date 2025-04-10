jQuery(document).ready(function($) {
   $('#booking-form').on('submit', function(e) {
       e.preventDefault();
       
       var form = $(this);
       var response = $('#booking-response');
       
       $.ajax({
           url: consultation_booking_ajax.ajaxurl,
           type: 'POST',
           data: {
               action: 'submit_booking',
               nonce: consultation_booking_ajax.nonce,
               name: $('#name').val(),
               email: $('#email').val(),
               phone: $('#phone').val(),
               consultant: $('#consultant').val(),
               date: $('#date').val(),
               time: $('#time').val()
           },
           beforeSend: function() {
               form.find('button').prop('disabled', true).text('در حال ثبت...');
           },
           success: function(res) {
               if (res.success) {
                   response.removeClass('error').addClass('success').text(res.data).show();
                   form[0].reset();
               } else {
                   response.removeClass('success').addClass('error').text(res.data).show();
               }
           },
           error: function() {
               response.removeClass('success').addClass('error').text('خطا در ارتباط با سرور').show();
           },
           complete: function() {
               form.find('button').prop('disabled', false).text('ثبت نوبت');
           }
       });
   });
});