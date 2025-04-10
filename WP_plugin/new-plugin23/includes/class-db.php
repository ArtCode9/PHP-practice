<?php
class Consultation_DB {
    public static function activate() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'consultation_bookings';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            consultant_id tinyint(1) NOT NULL,
            booking_date date NOT NULL,
            booking_time time NOT NULL,
            status varchar(20) DEFAULT 'pending',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        
        // ایجاد صفحه پیش‌فرض برای فرم نوبت دهی
        self::create_default_page();
    }
    
    private static function create_default_page() {
        $page = [
            'post_title' => __('رزرو مشاوره', 'consultation-booking'),
            'post_content' => '[consultation_booking_form]',
            'post_status' => 'publish',
            'post_type' => 'page'
        ];
        
        wp_insert_post($page);
    }
    
    public static function deactivate() {
        // پاک کردن داده‌ها هنگام غیرفعال سازی (اختیاری)
        // global $wpdb;
        // $table_name = $wpdb->prefix . 'consultation_bookings';
        // $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }
}