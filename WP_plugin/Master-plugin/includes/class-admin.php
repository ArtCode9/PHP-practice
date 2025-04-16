<?php
class WP_Master_Plugin_Admin {

    public function __construct() {
        // افزودن منوی مدیریت
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // ثبت تنظیمات
        add_action('admin_init', array($this, 'register_settings'));

        // افزودن لینک تنظیمات به صفحه پلاگین‌ها
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('WP Master Plugin', 'wp-master-plugin'),
            __('WP Master', 'wp-master-plugin'),
            'manage_options',
            'wp-master-plugin',
            array($this, 'render_admin_page'),
            'dashicons-admin-generic',
            80
        );

        add_submenu_page(
            'wp-master-plugin',
            __('Settings', 'wp-master-plugin'),
            __('Settings', 'wp-master-plugin'),
            'manage_options',
            'wp-master-plugin-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting(
            'wp_master_plugin_settings_group',
            'wp_master_plugin_settings',
            array($this, 'sanitize_settings')
        );

        add_settings_section(
            'wp_master_plugin_main_section',
            __('Main Settings', 'wp-master-plugin'),
            array($this, 'render_section_info'),
            'wp-master-plugin'
        );

        add_settings_field(
            'enable_feature',
            __('Enable Feature', 'wp-master-plugin'),
            array($this, 'render_enable_feature_field'),
            'wp-master-plugin',
            'wp_master_plugin_main_section'
        );

        add_settings_field(
            'default_text',
            __('Default Text', 'wp-master-plugin'),
            array($this, 'render_default_text_field'),
            'wp-master-plugin',
            'wp_master_plugin_main_section'
        );
    }

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p><?php _e('Welcome to WP Master Plugin dashboard.', 'wp-master-plugin'); ?></p>
        </div>
        <?php
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('wp_master_plugin_settings_group');
                do_settings_sections('wp-master-plugin');
                submit_button(__('Save Settings', 'wp-master-plugin'));
                ?>
            </form>
        </div>
        <?php
    }

    public function render_section_info() {
        echo '<p>' . __('Configure the main settings of WP Master Plugin.', 'wp-master-plugin') . '</p>';
    }

    public function render_enable_feature_field() {
        $options = get_option('wp_master_plugin_settings');
        $checked = isset($options['enable_feature']) ? $options['enable_feature'] : 0;
        ?>
        <input type="checkbox" name="wp_master_plugin_settings[enable_feature]" value="1" <?php checked(1, $checked); ?> />
        <?php
    }

    public function render_default_text_field() {
        $options = get_option('wp_master_plugin_settings');
        $value = isset($options['default_text']) ? $options['default_text'] : '';
        ?>
        <input type="text" name="wp_master_plugin_settings[default_text]" value="<?php echo esc_attr($value); ?>" class="regular-text" />
        <?php
    }

    public function sanitize_settings($input) {
        $sanitized = array();
        
        if (isset($input['enable_feature'])) {
            $sanitized['enable_feature'] = absint($input['enable_feature']);
        }
        
        if (isset($input['default_text'])) {
            $sanitized['default_text'] = sanitize_text_field($input['default_text']);
        }
        
        return $sanitized;
    }

    public function add_settings_link($links) {
        $settings_link = '<a href="admin.php?page=wp-master-plugin-settings">' . __('Settings', 'wp-master-plugin') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}