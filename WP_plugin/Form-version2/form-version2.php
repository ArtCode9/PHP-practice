<?php
/*
Plugin Name: مدیر فرم پیشرفته
Description: سیستم کامل مدیریت فرم با قابلیت‌های CRUD و پرینت
Version: 3.0
Author: شما
Text Domain: advanced-form-manager
*/

defined('ABSPATH') || exit;

class Advanced_Form_Manager {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'advanced_forms';

        // ثبت هوک‌های فعال‌سازی و کوتاه‌کد
        register_activation_hook(__FILE__, array($this, 'create_table'));
        add_shortcode('advanced_form', array($this, 'render_form'));

        // ثبت هوک‌های پردازش فرم
        add_action('admin_post_process_advanced_form', array($this, 'process_form'));
        add_action('admin_post_nopriv_process_advanced_form', array($this, 'process_form'));
        
        // ثبت هوک‌های AJAX
        add_action('wp_ajax_get_form_record', array($this, 'get_record_data'));
        add_action('wp_ajax_nopriv_get_form_record', array($this, 'get_record_data'));

        // اضافه کردن استایل‌ها و اسکریپت‌ها
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        // اضافه کردن این خط برای پردازش حذف
        add_action('init', array($this, 'handle_delete_request'));
    }

    public function create_table() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            full_name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$charset_collate};";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'advanced-form-style',
            plugin_dir_url(__FILE__) . 'assets/css/style.css'
        );
        
        wp_enqueue_script(
            'advanced-form-script',
            plugin_dir_url(__FILE__) . 'assets/js/script.js',
            array('jquery'),
            '1.0',
            true
        );
        
        wp_localize_script(
            'advanced-form-script',
            'advancedFormData',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('advanced_form_nonce')
            )
        );
    }

    public function render_form() {
        ob_start();
        
        $this->display_messages();
        
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
            $this->render_edit_form(intval($_GET['id']));
        } else {
            $this->render_main_form();
        }
        
        $this->render_data_table();
        
        return ob_get_clean();
    }

    private function render_main_form() {
        ?>
        <div class="advanced-form-container">
            <h2 class="form-title">فرم ثبت اطلاعات</h2>
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="process_advanced_form">
                <?php wp_nonce_field('advanced_form_create', 'advanced_form_nonce'); ?>
                
                <div class="form-group">
                    <label for="full_name">نام کامل:</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">ایمیل:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">شماره تلفن:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="submit" value="create" class="submit-btn">ذخیره اطلاعات</button>
                </div>
            </form>
        </div>
        <?php
    }

    public function handle_delete_request() {
      if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
          // بررسی nonce برای امنیت
          if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'advanced_form_delete_' . $_GET['id'])) {
              $this->redirect_with_message('عملیات غیرمجاز', 'error');
          }
  
          global $wpdb;
          $result = $wpdb->delete(
              $this->table_name,
              array('id' => intval($_GET['id'])),
              array('%d')
          );
          
          if ($result === false) {
              $this->redirect_with_message('خطا در حذف رکورد', 'error');
          } else {
              $this->redirect_with_message('رکورد با موفقیت حذف شد', 'success');
          }
      }
  }


    private function render_edit_form($id) {
        global $wpdb;
        
        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d", $id
        ));
        
        if ($record) {
            ?>
            <div class="advanced-form-container">
                <h2 class="form-title">ویرایش اطلاعات</h2>
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                    <input type="hidden" name="action" value="process_advanced_form">
                    <input type="hidden" name="id" value="<?php echo $record->id; ?>">
                    <?php wp_nonce_field('advanced_form_update_' . $record->id, 'advanced_form_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="full_name">نام کامل:</label>
                        <input type="text" id="full_name" name="full_name" 
                               value="<?php echo esc_attr($record->full_name); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo esc_attr($record->email); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">شماره تلفن:</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo esc_attr($record->phone); ?>" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="submit" value="update" class="submit-btn">به‌روزرسانی</button>
                        <a href="?" class="cancel-btn">انصراف</a>
                    </div>
                </form>
            </div>
            <?php
        }
    }

    public function process_form() {
        if (!isset($_POST['submit']) || !isset($_POST['advanced_form_nonce'])) {
            $this->redirect_with_message('درخواست نامعتبر', 'error');
        }

        global $wpdb;
        
        // اعتبارسنجی nonce
        if ($_POST['submit'] == 'create') {
            if (!wp_verify_nonce($_POST['advanced_form_nonce'], 'advanced_form_create')) {
                $this->redirect_with_message('اعتبارسنجی فرم ناموفق', 'error');
            }
        } elseif ($_POST['submit'] == 'update') {
            if (!wp_verify_nonce($_POST['advanced_form_nonce'], 'advanced_form_update_' . $_POST['id'])) {
                $this->redirect_with_message('اعتبارسنجی فرم ناموفق', 'error');
            }
        }

        // آماده‌سازی داده‌ها
        $data = array(
            'full_name' => sanitize_text_field($_POST['full_name']),
            'email'     => sanitize_email($_POST['email']),
            'phone'     => sanitize_text_field($_POST['phone'])
        );

        // عملیات CRUD
        if ($_POST['submit'] == 'create') {
            $result = $wpdb->insert($this->table_name, $data);
            $message = $result ? 'اطلاعات با موفقیت ذخیره شد' : 'خطا در ذخیره اطلاعات';
        } elseif ($_POST['submit'] == 'update' && isset($_POST['id'])) {
            $result = $wpdb->update(
                $this->table_name,
                $data,
                array('id' => intval($_POST['id']))
            );
            $message = $result !== false ? 'اطلاعات با موفقیت به‌روزرسانی شد' : 'خطا در به‌روزرسانی اطلاعات';
        }

        $this->redirect_with_message($message, $result ? 'success' : 'error');
    }

    public function get_record_data() {
        check_ajax_referer('advanced_form_nonce', 'nonce');

        if (!isset($_GET['id'])) {
            wp_send_json_error('شناسه رکورد مشخص نشده است');
        }

        global $wpdb;
        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d", 
            intval($_GET['id'])
        ));

        if (!$record) {
            wp_send_json_error('رکورد یافت نشد');
        }

        wp_send_json_success(array(
            'id' => $record->id,
            'full_name' => $record->full_name,
            'email' => $record->email,
            'phone' => $record->phone,
            'created_at' => date_i18n('j F Y H:i', strtotime($record->created_at))
        ));
    }

    private function render_data_table() {
        global $wpdb;
        
        $results = $wpdb->get_results(
            "SELECT * FROM {$this->table_name} ORDER BY created_at DESC"
        );
        
        if ($results) {
            ?>
            <div class="data-table-container">
                <h3>لیست اطلاعات ثبت‌شده</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>نام کامل</th>
                            <th>ایمیل</th>
                            <th>تلفن</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                        <tr>
                            <td><?php echo esc_html($row->full_name); ?></td>
                            <td><?php echo esc_html($row->email); ?></td>
                            <td><?php echo esc_html($row->phone); ?></td>
                            <td><?php echo date_i18n('Y/m/d H:i', strtotime($row->created_at)); ?></td>
                            <td class="actions">
                              <a href="?action=edit&id=<?php echo $row->id; ?>" class="edit-btn">ویرایش</a>
                              <a href="<?php echo wp_nonce_url(
                                 add_query_arg(array(
                                       'action' => 'delete',
                                       'id' => $row->id
                                 )),
                                 'advanced_form_delete_' . $row->id
                              ); ?>" class="delete-btn" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                              <button class="print-btn" data-record-id="<?php echo $row->id; ?>">پرینت</button>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div id="print-template" style="display:none;">
            <div class="print-header">
        <h1>گزارش اطلاعات کاربر</h1>
        <div class="company-info">
            <p>شرکت نمونه</p>
            <p>تلفن: ۰۲۱-۱۲۳۴۵۶۷۸</p>
            <p>تاریخ چاپ: <?php echo date_i18n('j F Y'); ?></p>
        </div>
    </div>
    
    <div class="print-content">
        <table class="print-table">
            <tr>
                <th>شناسه رکورد:</th>
                <td id="print-id"></td>
            </tr>
            <tr>
                <th>نام کامل:</th>
                <td id="print-name"></td>
            </tr>
            <tr>
                <th>ایمیل:</th>
                <td id="print-email"></td>
            </tr>
            <tr>
                <th>تلفن:</th>
                <td id="print-phone"></td>
            </tr>
            <tr>
                <th>تاریخ ثبت:</th>
                <td id="print-date"></td>
            </tr>
        </table>
        
        <div class="print-footer">
            <p>امضا: ___________________________</p>
            <p class="notice">این سند به صورت خودکار تولید شده است</p>
        </div>
    </div>
</div>
            <?php
        } else {
            echo '<p class="no-records">هیچ رکوردی یافت نشد.</p>';
        }
    }

    private function display_messages() {
        if (isset($_GET['message'])) {
            $message = sanitize_text_field($_GET['message']);
            $type = isset($_GET['message_type']) ? sanitize_text_field($_GET['message_type']) : 'info';
            echo '<div class="notice notice-' . esc_attr($type) . '"><p>' . esc_html($message) . '</p></div>';
        }
    }

    private function redirect_with_message($message, $type = 'success') {
        $redirect_url = add_query_arg(array(
            'message' => urlencode($message),
            'message_type' => $type
        ), wp_get_referer() ?: home_url());
        
        wp_redirect($redirect_url);
        exit;
    }
}

new Advanced_Form_Manager();