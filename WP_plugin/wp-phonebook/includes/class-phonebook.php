<?php
if (!defined('ABSPATH')) {
    exit;
}

class PhoneBook {
    public function __construct() {
        // بارگذاری وابستگی‌ها
        $this->load_dependencies();
        
        // تنظیم هک‌های مدیریتی
        if (is_admin()) {
            $this->admin_hooks();
        }
        
        // تنظیم هک‌های عمومی
        $this->public_hooks();
    }
    
    public function run() {
        // اجرای عملیات اولیه
        $this->create_tables();
    }
    
    private function load_dependencies() {
        require_once WP_PHONEBOOK_PATH . 'includes/class-phonebook-db.php';
        require_once WP_PHONEBOOK_PATH . 'includes/class-phonebook-admin.php';
        require_once WP_PHONEBOOK_PATH . 'includes/class-phonebook-public.php';
    }
    
    private function admin_hooks() {
        $admin = new PhoneBook_Admin();
        add_action('admin_menu', array($admin, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($admin, 'enqueue_admin_assets'));
    }
    
    private function public_hooks() {
        $public = new PhoneBook_Public();
        add_action('wp_enqueue_scripts', array($public, 'enqueue_public_assets'));
    }
    
    private function create_tables() {
        $db = new PhoneBook_DB();
        $db->create_tables();
    }
}