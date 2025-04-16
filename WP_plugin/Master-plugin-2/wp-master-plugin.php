<?php
/**
 * Plugin Name: WP Master Plugin 2
 * Plugin URI: https://example.com/wp-master-plugin
 * Description: پلاگین آموزشی پیشرفته با قابلیت‌های کاربردی
 * Version: 2.0.2
 * Author: art Name
 * Author URI: https://example.com
 * License: GPL-2.0+
 * Text Domain: wp-master-plugin
 */

defined('ABSPATH') || exit;

// تعریف ثابت‌ها
define('WP_MASTER_PLUGIN_VERSION', '2.0.0');
define('WP_MASTER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WP_MASTER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_MASTER_PLUGIN_BASENAME', plugin_basename(__FILE__));

// بارگذاری فایل‌های مورد نیاز
require_once WP_MASTER_PLUGIN_PATH . 'includes/class-core.php';

// راه‌اندازی پلاگین
function wp_master_plugin_init() {
    new WP_Master_Plugin_Core();
}
add_action('plugins_loaded', 'wp_master_plugin_init');