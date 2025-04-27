<?php
// افزودن منوی مدیریت
add_action('admin_menu', 'scf_add_admin_menu');

function scf_add_admin_menu() {
    add_menu_page(
        'فرم تماس ساده',
        'فرم تماس',
        'manage_options',
        'simple-contact-form',
        'scf_admin_page_content',
        'dashicons-email-alt',
        6
    );
}

// محتوای صفحه مدیریت
function scf_admin_page_content() {
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">فرم تماس ساده</h1>
        
        <?php
        // نمایش فرم یا لیست بسته به پارامتر action
        if (isset($_GET['action']) && in_array($_GET['action'], ['edit', 'delete', 'print'])) {
            $action = sanitize_text_field($_GET['action']);
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            
            switch ($action) {
                case 'edit':
                    scf_render_edit_form($id);
                    break;
                case 'delete':
                    scf_delete_contact($id);
                    break;
                case 'print':
                    scf_print_contact($id);
                    break;
            }
        } else {
            if (isset($_GET['view']) && $_GET['view'] === 'add-new') {
                scf_render_add_form();
            } else {
                scf_render_contacts_list();
            }
        }
        ?>
    </div>
    <?php
}

// فرم افزودن جدید
function scf_render_add_form() {
    ?>
    <h2>افزودن تماس جدید</h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="scf_save_contact">
        <?php wp_nonce_field('scf_save_contact_nonce', 'scf_nonce'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row"><label for="name">نام</label></th>
                <td><input type="text" name="name" id="name" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="email">ایمیل</label></th>
                <td><input type="email" name="email" id="email" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="phone">تلفن</label></th>
                <td><input type="tel" name="phone" id="phone" class="regular-text" required></td>
            </tr>
        </table>
        
        <p class="submit">
            <button type="submit" class="button button-primary">ذخیره</button>
            <a href="<?php echo admin_url('admin.php?page=simple-contact-form'); ?>" class="button">انصراف</a>
        </p>
    </form>
    <?php
}

// فرم ویرایش
function scf_render_edit_form($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    $contact = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    
    if (!$contact) {
        wp_die('رکورد مورد نظر یافت نشد');
    }
    
    ?>
    <h2>ویرایش تماس</h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="scf_update_contact">
        <input type="hidden" name="id" value="<?php echo esc_attr($contact->id); ?>">
        <?php wp_nonce_field('scf_update_contact_nonce', 'scf_nonce'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row"><label for="name">نام</label></th>
                <td><input type="text" name="name" id="name" class="regular-text" value="<?php echo esc_attr($contact->name); ?>" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="email">ایمیل</label></th>
                <td><input type="email" name="email" id="email" class="regular-text" value="<?php echo esc_attr($contact->email); ?>" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="phone">تلفن</label></th>
                <td><input type="tel" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr($contact->phone); ?>" required></td>
            </tr>
        </table>
        
        <p class="submit">
            <button type="submit" class="button button-primary">بروزرسانی</button>
            <a href="<?php echo admin_url('admin.php?page=simple-contact-form'); ?>" class="button">انصراف</a>
        </p>
    </form>
    <?php
}

// صفحه پرینت
function scf_print_contact($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    $contact = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    
    if (!$contact) {
        wp_die('رکورد مورد نظر یافت نشد');
    }
    
    ?>
    <div class="scf-print-container" style="padding: 20px; background: #fff;">
        <h1 style="text-align: center;">جزئیات تماس</h1>
        <table class="widefat" style="width: 100%; margin-top: 20px;">
            <tr>
                <th style="width: 30%; text-align: right;">شناسه:</th>
                <td><?php echo esc_html($contact->id); ?></td>
            </tr>
            <tr>
                <th style="text-align: right;">نام:</th>
                <td><?php echo esc_html($contact->name); ?></td>
            </tr>
            <tr>
                <th style="text-align: right;">ایمیل:</th>
                <td><?php echo esc_html($contact->email); ?></td>
            </tr>
            <tr>
                <th style="text-align: right;">تلفن:</th>
                <td><?php echo esc_html($contact->phone); ?></td>
            </tr>
            <tr>
                <th style="text-align: right;">تاریخ ایجاد:</th>
                <td><?php echo esc_html($contact->created_at); ?></td>
            </tr>
        </table>
        
        <div style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" class="button button-primary">پرینت</button>
            <a href="<?php echo admin_url('admin.php?page=simple-contact-form'); ?>" class="button">بازگشت</a>
        </div>
    </div>
    
    <style>
        @media print {
            .wp-admin-bar, .update-nag, #adminmenumain, #wpfooter, .submit {
                display: none !important;
            }
            .scf-print-container {
                margin: 0;
                padding: 0 !important;
            }
        }
    </style>
    <?php
}

// افزودن استایل‌ها و اسکریپت‌های مدیریتی
add_action('admin_enqueue_scripts', 'scf_admin_assets');

function scf_admin_assets($hook) {
    if ($hook !== 'toplevel_page_simple-contact-form') {
        return;
    }
    
    wp_enqueue_style(
        'scf-admin-css',
        SCF_PLUGIN_URL . 'assets/css/admin.css',
        array(),
        filemtime(SCF_PLUGIN_DIR . 'assets/css/admin.css')
    );
    
    wp_enqueue_script(
        'scf-admin-js',
        SCF_PLUGIN_URL . 'assets/js/admin.js',
        array('jquery'),
        filemtime(SCF_PLUGIN_DIR . 'assets/js/admin.js'),
        true
    );
}