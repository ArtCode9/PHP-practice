jQuery(document).ready(function($) {
    
    $('.button-danger').on('click', function(e) {
        if (!confirm('Are You sure delete This ?')) {
            e.preventDefault();
        }
    });
    
    // تایید قبل از ویرایش مخاطب
    $('.button-secondary').on('click', function() {
        // می‌توانید اعتبارسنجی اضافه کنید
    });
});