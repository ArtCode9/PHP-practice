jQuery(document).ready(function($) {
    // تایید قبل از حذف مخاطب
    $('.button-danger').on('click', function(e) {
        if (!confirm('آیا از حذف این مخاطب مطمئن هستید؟')) {
            e.preventDefault();
        }
    });
});