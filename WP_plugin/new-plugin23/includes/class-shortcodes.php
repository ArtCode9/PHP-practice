<?php
class Consultation_Shortcodes {
    public function __construct() {
        add_shortcode('consultation_booking_form', [$this, 'booking_form']);
        add_shortcode('consultation_booking_list', [$this, 'booking_list']);
    }
    
    public function booking_form() {
        ob_start();
        include CONS_BOOKING_PLUGIN_DIR . 'templates/booking-form.php';
        return ob_get_clean();
    }
    
    public function booking_list() {
        ob_start();
        if (is_user_logged_in() && current_user_can('manage_options')) {
            include CONS_BOOKING_PLUGIN_DIR . 'templates/admin-page.php';
        } else {
            echo '<p>' . __('برای مشاهده لیست نوبت‌ها باید مدیر سایت باشید.', 'consultation-booking') . '</p>';
        }
        return ob_get_clean();
    }
}

new Consultation_Shortcodes();