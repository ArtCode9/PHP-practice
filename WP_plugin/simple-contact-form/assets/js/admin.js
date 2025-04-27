jQuery(document).ready(function($) {
   // تایید قبل از حذف
   $('.button-link-delete').on('click', function(e) {
       if (!confirm('آیا از حذف این تماس مطمئن هستید؟')) {
           e.preventDefault();
       }
   });
   
   // اعتبارسنجی فرم‌ها
   $('form').on('submit', function() {
       var isValid = true;
       
       $(this).find('[required]').each(function() {
           if ($(this).val() === '') {
               $(this).addClass('error');
               isValid = false;
           } else {
               $(this).removeClass('error');
           }
       });
       
       // اعتبارسنجی تاریخ‌ها
       var dateFrom = $('#date_from').val();
       var dateTo = $('#date_to').val();
       
       if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
           alert('تاریخ "از" باید قبل از تاریخ "تا" باشد.');
           isValid = false;
       }
       
       if (!isValid) {
           alert('لطفاً تمام فیلدهای ضروری را به درستی پر کنید.');
           return false;
       }
   });
   
   // اعمال تاریخ امروز به عنوان پیش‌فرض برای فیلتر تاریخ
   $('.scf-date-filters input[type="date"]').on('focus', function() {
       if (!$(this).val()) {
           $(this).val(new Date().toISOString().split('T')[0]);
       }
   });
});