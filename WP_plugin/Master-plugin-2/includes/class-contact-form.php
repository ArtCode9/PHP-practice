<?php
class WP_Master_Plugin_Contact_Form {

    public function __construct() {
        add_shortcode('wp_master_contact', array($this, 'render_contact_form'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_wp_master_submit_contact', array($this, 'handle_submission'));
        add_action('wp_ajax_nopriv_wp_master_submit_contact', array($this, 'handle_submission'));
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'wp-master-contact-form',
            WP_MASTER_PLUGIN_URL . 'assets/css/contact-form.css',
            array(),
            WP_MASTER_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'wp-master-contact-form',
            WP_MASTER_PLUGIN_URL . 'assets/js/contact-form.js',
            array('jquery'),
            WP_MASTER_PLUGIN_VERSION,
            true
        );
        
        wp_localize_script(
            'wp-master-contact-form',
            'wp_master_contact',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wp_master_contact_nonce')
            )
        );
    }

    public function render_contact_form() {
        ob_start();
        include WP_MASTER_PLUGIN_PATH . 'templates/contact-form.php';
        return ob_get_clean();
    }

    public function handle_submission() {
        // بررسی nonce
        if (!check_ajax_referer('wp_master_contact_nonce', 'security', false)) {
            wp_send_json_error(array(
                'message' => __('Security check failed', 'wp-master-plugin')
            ));
        }

        // دریافت و اعتبارسنجی داده‌ها
        $data = array(
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'message' => sanitize_textarea_field($_POST['message'] ?? ''),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        // بررسی فیلدهای اجباری
        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            wp_send_json_error(array(
                'message' => __('Please fill all required fields', 'wp-master-plugin')
            ));
        }

        // ذخیره در دیتابیس
        global $wpdb;
        $table = $wpdb->prefix . 'wp_master_contacts';
        
        $result = $wpdb->insert($table, array(
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'ip_address' => $data['ip'],
            'created_at' => current_time('mysql')
        ));

        if ($result) {
            // ارسال ایمیل
            $to = get_option('admin_email');
            $subject = sprintf(__('New contact form submission from %s', 'wp-master-plugin'), $data['name']);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            $body = sprintf(
                '<p>%s: %s</p><p>%s: %s</p><p>%s:</p><p>%s</p>',
                __('Name', 'wp-master-plugin'), $data['name'],
                __('Email', 'wp-master-plugin'), $data['email'],
                __('Message', 'wp-master-plugin'), nl2br($data['message'])
            );
            
            wp_mail($to, $subject, $body, $headers);
            
            wp_send_json_success(array(
                'message' => __('Thank you! Your message has been sent.', 'wp-master-plugin')
            ));
        } else {
            wp_send_json_error(array(
                'message' => __('An error occurred. Please try again later.', 'wp-master-plugin')
            ));
        }
    }
}