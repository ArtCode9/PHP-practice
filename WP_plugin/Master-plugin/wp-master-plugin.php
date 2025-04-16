<?php 
/* 
   PLugin Name: WP Master Plugin
   Plugin URI: ww.artcode9.com
   Description: This is  master ref plugin build 
   Version: 1.0.0
   Author: ArtCode
   Author URI : www.artcode9.com
   Text Domain: wp-master-plugin
*/

// جلوگیری از دسترسی مستقیم
defined('ABSPATH') || exit;

// تعریف ثابت‌های پلاگین
define('WP_MASTER_PLUGIN_VERSION', '1.0.0');
define('WP_MASTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_MASTER_PLUGIN_URL', plugin_dir_url(__FILE__));

// بارگذاری فایل‌های مورد نیاز
require_once WP_MASTER_PLUGIN_DIR . 'includes/class-admin.php';
require_once WP_MASTER_PLUGIN_DIR . 'includes/class-widget.php';
require_once WP_MASTER_PLUGIN_DIR . 'includes/class-api.php';

/**
 * کلاس اصلی پلاگین
 */
class WP_Master_Plugin {

   public function __construct() {
       // بارگذاری ترجمه‌ها
       add_action('init', array($this, 'load_textdomain'));

       // ثبت هوک‌ها
       $this->register_hooks();

       // مقداردهی اولیه
       $this->init();
   }
     /**
     * بارگذاری فایل‌های ترجمه
     */
    public function load_textdomain() {
      load_plugin_textdomain(
          'wp-master-plugin',
          false,
          dirname(plugin_basename(__FILE__)) . '/languages'
      );
   }
     /**
     * ثبت هوک‌های اصلی
     */
    private function register_hooks() {
      // اکشن هوک برای وقتی که پلاگین فعال می‌شود
      register_activation_hook(__FILE__, array($this, 'activate'));

      // اکشن هوک برای وقتی که پلاگین غیرفعال می‌شود
      register_deactivation_hook(__FILE__, array($this, 'deactivate'));

      // فیلتر برای تغییر عنوان پست‌ها
      add_filter('the_title', array($this, 'filter_post_title'), 10, 2);

      // اکشن برای نمایش محتوا بعد از پست
      add_action('the_content', array($this, 'display_after_content'));
   }

  /**
   * فعال‌سازی پلاگین
   */
  public function activate() {
      // ایجاد جداول دیتابیس اگر نیاز باشد
      $this->create_database_tables();

      // تنظیمات پیش‌فرض
      update_option('wp_master_plugin_settings', array(
          'enable_feature' => 1,
          'default_text' => __('Hello from WP Master Plugin!', 'wp-master-plugin')
      ));

      // زمان فعال‌سازی را ذخیره کنید
      update_option('wp_master_plugin_activated', time());
   }

  /**
   * غیرفعال‌سازی پلاگین
   */
  public function deactivate() {
      // پاک کردن رویدادهای زمان‌بندی شده
      wp_clear_scheduled_hook('wp_master_plugin_daily_event');
   }

  /**
   * مقداردهی اولیه پلاگین
   */
  private function init() {
      // مقداردهی بخش مدیریت
      new WP_Master_Plugin_Admin();

      // ثبت ویجت
      add_action('widgets_init', function() {
          register_widget('WP_Master_Plugin_Widget');
      });

      // مقداردهی REST API
      new WP_Master_Plugin_API();
   }

  /**
   * ایجاد جداول دیتابیس
   */
  private function create_database_tables() {
      global $wpdb;

      $table_name = $wpdb->prefix . 'wp_master_plugin_data';
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          title varchar(100) NOT NULL,
          content text NOT NULL,
          created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
   }

  /**
   * فیلتر عنوان پست
   */
  public function filter_post_title($title, $id) {
      if (!is_admin() && in_the_loop()) {
          $settings = get_option('wp_master_plugin_settings');
          if (!empty($settings['default_text'])) {
              $title = $settings['default_text'] . ' - ' . $title;
          }
      }
      return $title;
  }

  /**
   * نمایش محتوا بعد از پست
   */
  public function display_after_content($content) {
      if (is_single()) {
          $extra_content = '<div class="wp-master-plugin-notice">';
          $extra_content .= __('This content is added by WP Master Plugin', 'wp-master-plugin');
          $extra_content .= '</div>';
          $content .= $extra_content;
      }
      return $content;
  }
}

// راه‌اندازی پلاگین
new WP_Master_Plugin();
