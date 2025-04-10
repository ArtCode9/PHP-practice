<?php
class Consultation_AJAX {
    public function __construct() {
        add_action('wp_ajax_submit_booking', [$this, 'submit_booking']);
        add_action('wp_ajax_nopriv_submit_booking', [$this, 'submit_booking']);
    }
    
    public function submit_booking() {
        check_ajax_referer('consultation_booking_nonce', 'nonce');
        
        $data = [
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'consultant_id' => absint($_POST['consultant']),
            'booking_date' => sanitize_text_field($_POST['date']),
            'booking_time' => sanitize_text_field($_POST['time']),
        ];
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'consultation_bookings';
        
        $result = $wpdb->insert($table_name, $data);
        
        if ($result) {
            $this->send_notification($data);
            wp_send_json_success(__('نوبت شما با موفقیت ثبت شد!', 'consultation-booking'));
        } else {
            wp_send_json_error(__('خطا در ثبت نوبت! لطفاً مجدداً تلاش کنید.', 'consultation-booking'));
        }
    }
    
    private function send_notification($data) {
        $to = get_option('admin_email');
        $subject = __('رزرو جدید مشاوره', 'consultation-booking');
        $message = "جزئیات رزرو جدید:\n\n";
        $message .= "نام: {$data['name']}\n";
        $message .= "ایمیل: {$data['email']}\n";
        $message .= "تلفن: {$data['phone']}\n";
        $message .= "مشاور: مشاور شماره {$data['consultant_id']}\n";
        $message .= "تاریخ: {$data['booking_date']}\n";
        $message .= "ساعت: {$data['booking_time']}\n";
        
        wp_mail($to, $subject, $message);
    }
}

new Consultation_AJAX();