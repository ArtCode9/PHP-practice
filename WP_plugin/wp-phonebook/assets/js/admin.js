jQuery(document).ready(function($) {
    // اعتبارسنجی فرم
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // بررسی فیلدهای ضروری
        $(this).find('[required]').each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('error');
                isValid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('لطفا فیلدهای ضروری را پر کنید');
        }
    });
    
    // افکت‌های hover روی ردیف‌های جدول
    $('.contacts-table tr').hover(
        function() {
            $(this).css('transform', 'translateX(5px)');
        },
        function() {
            $(this).css('transform', 'translateX(0)');
        }
    );
    
    // تایید قبل از حذف
    $('.btn-danger').on('click', function(e) {
        if (!confirm('آیا از حذف این مخاطب مطمئن هستید؟')) {
            e.preventDefault();
        }
    });
});