<?php
if (!defined('ABSPATH')) {
    exit;
}

class PhoneBook_Admin {
    public function add_admin_menu() {
        add_menu_page(
            'Phone Book',
            'Phone Book',
            'manage_options',
            'wp-phonebook',
            array($this, 'render_admin_page'),
            'dashicons-phone',
            25
        );
        
    }
    
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_wp-phonebook' !== $hook) {
            return;
        }
        
        // اضافه کردن فونت dashicons
        wp_enqueue_style('dashicons');

        wp_enqueue_style(
            'wp-phonebook-admin',
            WP_PHONEBOOK_URL . 'assets/css/admin.css',
            array(),
            WP_PHONEBOOK_VERSION
        );
        
        wp_enqueue_script(
            'wp-phonebook-admin',
            WP_PHONEBOOK_URL . 'assets/js/admin.js',
            array('jquery'),
            WP_PHONEBOOK_VERSION,
            true
        );
    }
    
    public function render_admin_page() {
        $db = new PhoneBook_DB();
        
        if (isset($_POST['add_contact'])) {
            $data = array(
                'name' => sanitize_text_field($_POST['name']),
                'phone' => sanitize_text_field($_POST['phone']),
                'email' => sanitize_email($_POST['email']),
                'address' => sanitize_textarea_field($_POST['address'])
            );
            $db->add_contact($data);
        }

        if (isset($_POST['update_contact'])) {
            $id = intval($_POST['contact_id']);
            $data = array(
                'name' => sanitize_text_field($_POST['name']),
                'phone' => sanitize_text_field($_POST['phone']),
                'email' => sanitize_email($_POST['email']),
                'address' => sanitize_textarea_field($_POST['address'])
            );
            $db->update_contact($id, $data);
        }
        
        if (isset($_GET['delete_contact'])) {
            $db->delete_contact(intval($_GET['delete_contact']));
        }
        
        // دریافت مخاطب برای ویرایش
        $edit_contact = null;
        if (isset($_GET['edit_contact'])) {
             $edit_contact = $db->get_contact(intval($_GET['edit_contact']));
        }

        $contacts = $db->get_contacts();
        
        include WP_PHONEBOOK_PATH . 'templates/admin-page.php';
    }
}