<?php
/**
 * Plugin Name: Simple Contact Form
 * Description: یک فرم ساده برای ذخیره اطلاعات کاربران در پیشخوان وردپرس
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // خروج اگر مستقیماً فراخوانی شود
}

// تعریف ثابت‌ها
define('SCF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SCF_PLUGIN_URL', plugin_dir_url(__FILE__));

// ایجاد جدول دیتابیس هنگام فعال‌سازی پلاگین
register_activation_hook(__FILE__, 'scf_create_database_table');

function scf_create_database_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'simple_contact_form';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// بارگذاری فایل‌های مورد نیاز
require_once SCF_PLUGIN_DIR . 'includes/admin-page.php';
require_once SCF_PLUGIN_DIR . 'includes/form-handler.php';
require_once SCF_PLUGIN_DIR . 'includes/list-table.php';
require_once SCF_PLUGIN_DIR . 'includes/shortcode.php';


// در فایل اصلی پلاگین (simple-contact-form.php) بعد از تعریف ثابت‌ها این کد را اضافه کنید:
   add_shortcode('simple_contact_form', 'scf_shortcode_handler');