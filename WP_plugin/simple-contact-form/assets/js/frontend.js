jQuery(document).ready(function($) {
   // اعتبارسنجی فرم
   $('.scf-frontend-form form').on('submit', function(e) {
       var isValid = true;
       $(this).find('[required]').each(function() {
           if ($(this).val().trim() === '') {
               $(this).addClass('scf-error');
               isValid = false;
           } else {
               $(this).removeClass('scf-error');
           }
       });
       
       if (!isValid) {
           e.preventDefault();
           alert('لطفاً تمام فیلدهای ضروری را پر کنید.');
       }
   });
   
   // تایید قبل از حذف
   $('.scf-delete-btn').on('click', function(e) {
       if (!confirm('آیا از حذف این مخاطب مطمئن هستید؟')) {
           e.preventDefault();
       }
   });
   
   // اعتبارسنجی تاریخ‌ها
   $('.scf-search-form').on('submit', function() {
       var dateFrom = $('input[name="scf_date_from"]').val();
       var dateTo = $('input[name="scf_date_to"]').val();
       
       if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
           alert('تاریخ "از" باید قبل از تاریخ "تا" باشد.');
           return false;
       }
   });
});

jQuery(document).ready(function($) {
   // اعتبارسنجی فرم
   $('.scf-frontend-form form').on('submit', function(e) {
       var isValid = true;
       $(this).find('[required]').each(function() {
           var $field = $(this);
           var $group = $field.closest('.scf-form-group');
           $group.find('.scf-error-message').remove();
           
           if ($field.val().trim() === '') {
               $field.addClass('scf-error');
               $group.append('<div class="scf-error-message">این فیلد الزامی است</div>');
               isValid = false;
           } else {
               $field.removeClass('scf-error');
           }
       });
       
       if (!isValid) {
           e.preventDefault();
           $('.scf-frontend-form').find('.scf-alert.error').remove();
           $('.scf-frontend-form').prepend(
               '<div class="scf-alert error">لطفاً تمام فیلدهای ضروری را پر کنید.</div>'
           );
           $('html, body').animate({
               scrollTop: $('.scf-frontend-form').offset().top - 100
           }, 500);
       }
   });
});