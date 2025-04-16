<?php
class WP_Master_Plugin_Core {

    public function __construct() {
        // بارگذاری فایل‌های مورد نیاز
        $this->includes();

        // بارگذاری ترجمه‌ها
        add_action('init', array($this, 'load_textdomain'));

        // ثبت هوک‌های فعال‌سازی/غیرفعال‌سازی
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // بارگذاری ماژول‌ها
        $this->load_modules();
    }

    private function includes() {
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-admin.php';
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-shortcodes.php';
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-products.php';
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-contact-form.php';
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-widgets.php';
        require_once WP_MASTER_PLUGIN_PATH . 'includes/class-api.php';
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'wp-master-plugin',
            false,
            dirname(WP_MASTER_PLUGIN_BASENAME) . '/languages'
        );
    }

    private function load_modules() {
        new WP_Master_Plugin_Admin();
        new WP_Master_Plugin_Shortcodes();
        new WP_Master_Plugin_Products();
        new WP_Master_Plugin_Contact_Form();
        new WP_Master_Plugin_Widgets();
        new WP_Master_Plugin_API();
    }

    public function activate() {
        // ایجاد جداول دیتابیس
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // جدول فرم تماس
        $contacts_table = $wpdb->prefix . 'wp_master_contacts';
        $sql = "CREATE TABLE $contacts_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            message text NOT NULL,
            ip_address varchar(50) NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // ذخیره زمان فعال‌سازی
        update_option('wp_master_plugin_activated', time());
    }

    public function deactivate() {
        // پاک کردن رویدادهای زمان‌بندی شده
        wp_clear_scheduled_hook('wp_master_plugin_daily_maintenance');
    }
}