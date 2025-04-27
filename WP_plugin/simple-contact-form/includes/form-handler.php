<?php
// ذخیره تماس جدید
add_action('admin_post_scf_save_contact', 'scf_save_contact');
add_action('admin_post_nopriv_scf_save_contact', 'scf_save_contact');

function scf_save_contact() {
    if (!isset($_POST['scf_nonce']) || !wp_verify_nonce($_POST['scf_nonce'], 'scf_save_contact_nonce')) {
        wp_die('اعتبارسنجی غیرمجاز');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('دسترسی غیرمجاز');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    
    $data = array(
        'name' => sanitize_text_field($_POST['name']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone'])
    );
    
    $format = array('%s', '%s', '%s');
    
    $wpdb->insert($table_name, $data, $format);
    
    wp_redirect(admin_url('admin.php?page=simple-contact-form&message=added'));
    exit;
}

// بروزرسانی تماس
add_action('admin_post_scf_update_contact', 'scf_update_contact');
add_action('admin_post_nopriv_scf_update_contact', 'scf_update_contact');

function scf_update_contact() {
    if (!isset($_POST['scf_nonce']) || !wp_verify_nonce($_POST['scf_nonce'], 'scf_update_contact_nonce')) {
        wp_die('اعتبارسنجی غیرمجاز');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('دسترسی غیرمجاز');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    $id = intval($_POST['id']);
    
    $data = array(
        'name' => sanitize_text_field($_POST['name']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone'])
    );
    
    $where = array('id' => $id);
    $format = array('%s', '%s', '%s');
    $where_format = array('%d');
    
    $wpdb->update($table_name, $data, $where, $format, $where_format);
    
    wp_redirect(admin_url('admin.php?page=simple-contact-form&message=updated'));
    exit;
}

// حذف تماس
function scf_delete_contact($id) {
    if (!current_user_can('manage_options')) {
        wp_die('دسترسی غیرمجاز');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    
    $wpdb->delete($table_name, array('id' => $id), array('%d'));
    
    wp_redirect(admin_url('admin.php?page=simple-contact-form&message=deleted'));
    exit;
}