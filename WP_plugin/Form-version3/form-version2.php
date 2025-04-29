<?php
/*
Plugin Name: فرم استخدام مدرسین
Description: سیستم مدیریت درخواست‌های استخدام مدرسین زبان
Version: 1.0
Author: شما
Text Domain: teacher-application-form
*/

defined('ABSPATH') || exit;

class Teacher_Application_Form {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'teacher_applications';

        // ثبت هوک‌های فعال‌سازی
        register_activation_hook(__FILE__, array($this, 'create_table'));

        // ثبت شورت‌کد
        add_shortcode('teacher_application_form', array($this, 'render_form'));
        add_shortcode('teacher_applications_list', array($this, 'render_applications_list'));

        // پردازش فرم
        add_action('admin_post_submit_teacher_application', array($this, 'process_form'));
        add_action('admin_post_nopriv_submit_teacher_application', array($this, 'process_form'));
        add_action('wp_ajax_get_application_details', array($this, 'get_application_details'));
        add_action('wp_ajax_get_teacher_application', array($this, 'get_teacher_application'));


        // اضافه کردن استایل‌ها و اسکریپت‌ها
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function create_table() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            first_name varchar(50) NOT NULL,
            last_name varchar(50) NOT NULL,
            father_name varchar(50),
            birth_date date,
            national_id varchar(10),
            gender varchar(10),
            marital_status varchar(20),
            children_count smallint,
            religion varchar(30),
            denomination varchar(30),
            home_phone varchar(15),
            mobile varchar(15),
            address text,
            email varchar(100) NOT NULL,
            languages_7_12 text,
            languages_teenagers text,
            languages_adults text,
            education text,
            certificates text,
            application_date datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'pending',
            PRIMARY KEY (id)
        ) {$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function get_teacher_application() {
        check_ajax_referer('teacher_application_nonce', 'nonce');
    
        if (!isset($_GET['id'])) {
            wp_send_json_error('شناسه درخواست مشخص نشده است');
        };
    
        global $wpdb;
        
        $application = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            intval($_GET['id'])
        ));
    
        if (!$application) {
            wp_send_json_error('درخواست یافت نشد');
        }
    
        $response = array(
            'id' => $application->id,
            'full_name' => $application->first_name . ' ' . $application->last_name,
            'national_id' => $application->national_id,
            'mobile' => $application->mobile,
            'email' => $application->email,
            'application_date' => date_i18n('j F Y H:i', strtotime($application->application_date)),
            'languages' => $this->prepare_languages_data($application),
            'education' => $this->prepare_education_data($application)
        );
    
        wp_send_json_success($response);
    }

    

    public function enqueue_assets() {
        // استایل‌ها
        wp_enqueue_style(
            'teacher-application-style',
            plugins_url('assets/css/style.css', __FILE__),
            array(),
            '1.0'
        );

        // اسکریپت‌ها
        wp_enqueue_script(
            'teacher-application-script',
            plugins_url('assets/js/script.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );

        wp_localize_script(
            'teacher-application-script',
            'teacherApplicationData',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('teacher_application_nonce')
            )
        );
    }

    public function render_form() {
        ob_start();
        ?>
        <div class="teacher-application-form">
            <h2>فرم استخدام مدرسین</h2>
            
            <?php $this->display_messages(); ?>
            
            <form id="teacher-application" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="submit_teacher_application">
                <?php wp_nonce_field('submit_teacher_application', 'teacher_nonce'); ?>
                
                <!-- بخش اطلاعات شخصی -->
                <div class="form-section">
                    <h3>اطلاعات شخصی</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">نام *</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">نام خانوادگی *</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="father_name">نام پدر</label>
                            <input type="text" id="father_name" name="father_name">
                        </div>
                        
                        <div class="form-group">
                            <label for="birth_date">تاریخ تولد</label>
                            <input type="date" id="birth_date" name="birth_date">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="national_id">کد ملی</label>
                            <input type="text" id="national_id" name="national_id" maxlength="10">
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">جنسیت</label>
                            <select id="gender" name="gender">
                                <option value="">انتخاب کنید</option>
                                <option value="male">مرد</option>
                                <option value="female">زن</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="marital_status">وضعیت تأهل</label>
                            <select id="marital_status" name="marital_status">
                                <option value="">انتخاب کنید</option>
                                <option value="single">مجرد</option>
                                <option value="married">متأهل</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="children_count">تعداد فرزند</label>
                            <input type="number" id="children_count" name="children_count" min="0" value="0">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="religion">دین</label>
                            <input type="text" id="religion" name="religion">
                        </div>
                        
                        <div class="form-group">
                            <label for="denomination">مذهب</label>
                            <input type="text" id="denomination" name="denomination">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="home_phone">تلفن ثابت</label>
                            <input type="tel" id="home_phone" name="home_phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="mobile">تلفن همراه *</label>
                            <input type="tel" id="mobile" name="mobile" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">آدرس محل سکونت</label>
                        <textarea id="address" name="address" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">آدرس ایمیل *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <!-- بخش زبان‌ها و گروه‌های سنی -->
                <div class="form-section">
                    <h3>زبان‌ها و گروه‌های سنی</h3>
                    
                    <table class="language-table">
                        <thead>
                            <tr>
                                <th>زبان</th>
                                <th>7-12 سال</th>
                                <th>نوجوانان (13-17)</th>
                                <th>بزرگسالان (18+)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $languages = array('english', 'french', 'german', 'turkish');
                            foreach ($languages as $lang) : ?>
                            <tr>
                                <td><?php echo $this->get_language_name($lang); ?></td>
                                <td><input type="checkbox" name="languages[<?php echo $lang; ?>][7_12]"></td>
                                <td><input type="checkbox" name="languages[<?php echo $lang; ?>][teenagers]"></td>
                                <td><input type="checkbox" name="languages[<?php echo $lang; ?>][adults]"></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- بخش سوابق تحصیلی -->
                <div class="form-section">
                    <h3>سوابق تحصیلی</h3>
                    <div id="education-items">
                        <div class="education-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>مدرک</label>
                                    <select name="education[0][degree]">
                                        <option value="">انتخاب کنید</option>
                                        <option value="diploma">دیپلم</option>
                                        <option value="bachelor">لیسانس</option>
                                        <option value="master">فوق لیسانس</option>
                                        <option value="phd">دکترا</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>رشته</label>
                                    <input type="text" name="education[0][major]" placeholder="مثال: زبان انگلیسی">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>دانشگاه/مدرسه</label>
                                    <input type="text" name="education[0][institution]" placeholder="نام مؤسسه آموزشی">
                                </div>
                                
                                <div class="form-group">
                                    <label>سال فراغت</label>
                                    <input type="number" name="education[0][year]" placeholder="1400" min="1300" max="1405">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-education" class="add-btn">+ افزودن مدرک دیگر</button>
                </div>
                
                <!-- بخش مدارک تخصصی زبان -->
                <div class="form-section">
                    <h3>مدارک تخصصی زبان</h3>
                    <div id="certificate-items">
                        <div class="certificate-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>نوع مدرک</label>
                                    <input type="text" name="certificates[0][type]" placeholder="مثال: آیلتس، تافل">
                                </div>
                                
                                <div class="form-group">
                                    <label>نمره/سطح</label>
                                    <input type="text" name="certificates[0][score]" placeholder="مثال: 7.5، Advanced">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>تاریخ اخذ</label>
                                    <input type="date" name="certificates[0][date]">
                                </div>
                                
                                <div class="form-group">
                                    <label>مرکز صادرکننده</label>
                                    <input type="text" name="certificates[0][institution]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-certificate" class="add-btn">+ افزودن مدرک دیگر</button>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">ارسال درخواست</button>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    private function get_language_name($lang) {
        $names = array(
            'english' => 'انگلیسی',
            'french' => 'فرانسوی',
            'german' => 'آلمانی',
            'turkish' => 'ترکی استانبولی'
        );
        return $names[$lang] ?? $lang;
    }

    public function process_form() {
        if (!isset($_POST['teacher_nonce']) || !wp_verify_nonce($_POST['teacher_nonce'], 'submit_teacher_application')) {
            $this->redirect_with_message('اعتبارسنجی فرم ناموفق بود', 'error');
        }

        global $wpdb;
        
        // آماده‌سازی داده‌ها
        $data = array(
            'first_name' => sanitize_text_field($_POST['first_name']),
            'last_name' => sanitize_text_field($_POST['last_name']),
            'father_name' => sanitize_text_field($_POST['father_name']),
            'birth_date' => sanitize_text_field($_POST['birth_date']),
            'national_id' => sanitize_text_field($_POST['national_id']),
            'gender' => sanitize_text_field($_POST['gender']),
            'marital_status' => sanitize_text_field($_POST['marital_status']),
            'children_count' => intval($_POST['children_count']),
            'religion' => sanitize_text_field($_POST['religion']),
            'denomination' => sanitize_text_field($_POST['denomination']),
            'home_phone' => sanitize_text_field($_POST['home_phone']),
            'mobile' => sanitize_text_field($_POST['mobile']),
            'address' => sanitize_textarea_field($_POST['address']),
            'email' => sanitize_email($_POST['email']),
            'languages_7_12' => maybe_serialize($_POST['languages']['7_12'] ?? array()),
            'languages_teenagers' => maybe_serialize($_POST['languages']['teenagers'] ?? array()),
            'languages_adults' => maybe_serialize($_POST['languages']['adults'] ?? array()),
            'education' => maybe_serialize($_POST['education'] ?? array()),
            'certificates' => maybe_serialize($_POST['certificates'] ?? array())
        );

        // ذخیره در دیتابیس
        $result = $wpdb->insert($this->table_name, $data);

        if ($result === false) {
            $this->redirect_with_message('خطا در ثبت درخواست. لطفاً مجدداً تلاش کنید.', 'error');
        }

        // ارسال ایمیل
        $this->send_notification_email($data);

        $this->redirect_with_message('درخواست شما با موفقیت ثبت شد. با شما تماس خواهیم گرفت.', 'success');
    }

    private function send_notification_email($data) {
        $to = get_option('admin_email');
        $subject = 'درخواست جدید استخدام مدرس - ' . $data['first_name'] . ' ' . $data['last_name'];
        
        $message = "یک درخواست جدید برای استخدام مدرس ثبت شده است:\n\n";
        $message .= "نام: {$data['first_name']} {$data['last_name']}\n";
        $message .= "تلفن: {$data['mobile']}\n";
        $message .= "ایمیل: {$data['email']}\n\n";
        $message .= "برای مشاهده جزئیات کامل به پنل مدیریت مراجعه کنید.";
        
        wp_mail($to, $subject, $message);
    }

    private function display_messages() {
        if (isset($_GET['message'])) {
            $type = isset($_GET['message_type']) ? $_GET['message_type'] : 'info';
            echo '<div class="notice notice-' . esc_attr($type) . '">';
            echo '<p>' . esc_html(urldecode($_GET['message'])) . '</p>';
            echo '</div>';
        }
    }

    private function redirect_with_message($message, $type = 'info') {
        $redirect_url = add_query_arg(array(
            'message' => urlencode($message),
            'message_type' => $type
        ), wp_get_referer() ?: home_url());
        
        wp_redirect($redirect_url);
        exit;
    }

    public function render_applications_list() {
        if (!current_user_can('manage_options')) {
            return '<p>شما دسترسی لازم برای مشاهده این لیست را ندارید.</p>';
        }
    
        global $wpdb;
        
        $applications = $wpdb->get_results(
            "SELECT * FROM {$this->table_name} ORDER BY application_date DESC"
        );
    
        ob_start();
        ?>
        <div class="teacher-applications-list">
            <h2>لیست درخواست‌های استخدام مدرسین</h2>
            
            <div class="list-actions">
                <button onclick="window.print()" class="print-btn">پرینت لیست</button>
            </div>
            
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام و نام خانوادگی</th>
                        <th>تلفن همراه</th>
                        <th>ایمیل</th>
                        <th>تاریخ درخواست</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app) : ?>
                    <tr>
                        <td><?php echo $app->id; ?></td>
                        <td><?php echo esc_html($app->first_name . ' ' . $app->last_name); ?></td>
                        <td><?php echo esc_html($app->mobile); ?></td>
                        <td><?php echo esc_html($app->email); ?></td>
                        <td><?php echo date_i18n('j F Y H:i', strtotime($app->application_date)); ?></td>
                        <td>
                            <span class="status-badge <?php echo $app->status; ?>">
                                <?php echo $this->get_status_label($app->status); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="<?php echo admin_url('admin.php?page=teacher_application_details&id=' . $app->id); ?>" 
                            class="view-btn">مشاهده</a>
                            <button class="print-btn print-application-btn" 
                                    data-id="<?php echo $app->id; ?>">پرینت</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div id="print-application-template" style="display:none;">
                <div class="print-header">
                    <h1>گزارش درخواست استخدام مدرس</h1>
                    <p>تاریخ چاپ: <?php echo date_i18n('j F Y'); ?></p>
                </div>
                <div id="print-application-content"></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    private function get_status_label($status) {
        $labels = array(
            'pending' => 'در انتظار بررسی',
            'approved' => 'تأیید شده',
            'rejected' => 'رد شده'
        );
        return $labels[$status] ?? $status;
    }


    public function get_application_details() {
        check_ajax_referer('advanced_form_nonce', 'nonce');
    
        if (!isset($_GET['id']) || !current_user_can('manage_options')) {
            wp_send_json_error('دسترسی غیرمجاز');
        }
    
        global $wpdb;
        
        $application = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            intval($_GET['id'])
        ));
    
        if (!$application) {
            wp_send_json_error('درخواست یافت نشد');
        }
    
        $response = array(
            'id' => $application->id,
            'full_name' => $application->first_name . ' ' . $application->last_name,
            'national_id' => $application->national_id,
            'birth_date' => $application->birth_date,
            'mobile' => $application->mobile,
            'email' => $application->email,
            'languages' => $this->prepare_languages_data($application),
            'education' => $this->prepare_education_data($application),
            'status' => $this->get_status_label($application->status)
        );
    
        wp_send_json_success($response);
    }
    
    private function prepare_languages_data($application) {
        $languages = array('english', 'french', 'german', 'turkish');
        $result = array();
        
        $lang_7_12 = maybe_unserialize($application->languages_7_12) ?: array();
        $lang_teen = maybe_unserialize($application->languages_teenagers) ?: array();
        $lang_adult = maybe_unserialize($application->languages_adults) ?: array();
        
        foreach ($languages as $lang) {
            $result[] = array(
                'name' => $this->get_language_name($lang),
                'age_7_12' => !empty($lang_7_12[$lang]),
                'teenagers' => !empty($lang_teen[$lang]),
                'adults' => !empty($lang_adult[$lang])
            );
        }
        
        return $result;
    }
    
    private function prepare_education_data($application) {
        $education = maybe_unserialize($application->education) ?: array();
        $result = array();
        
        foreach ($education as $edu) {
            if (!empty($edu['degree'])) {
                $result[] = array(
                    'degree' => $edu['degree'],
                    'major' => $edu['major'] ?? '',
                    'institution' => $edu['institution'] ?? '',
                    'year' => $edu['year'] ?? ''
                );
            }
        }
        
        return $result;
    }
}

new Teacher_Application_Form();

