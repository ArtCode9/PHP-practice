<?php
/* 
Plugin Name: My ticket
Plugin URI:  https://example.com
Description: This is my ticket.
Author: art code
Author URI: https://example.com
Text Domain: myfirstticket
Domain Path: /languages/
Version: 1.0.0
*/

// بررسی اینکه وردپرس فعال است
if (!defined('ABSPATH')) {
    exit;
}

// بارگذاری فایل‌های لازم برای reCAPTCHA
// add_action('wp_enqueue_scripts', 'enqueue_recaptcha_scripts');
// function enqueue_recaptcha_scripts() {
//     if (!is_admin()) {
//         wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
//     }
// }

//🚩 ==================================================================
// ایجاد جدول برای ذخیره تیکت‌ها
function create_support_ticket_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'support_tickets';
    $charset_collate = $wpdb->get_charset_collate();

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            tracking_code VARCHAR(50) NOT NULL UNIQUE,
            user_id bigint(20) NOT NULL,
            ip_address varchar(100) NOT NULL,
            full_name tinytext NOT NULL,
            email VARCHAR(100) NOT NULL,
            domain VARCHAR(100) NOT NULL,
            subject text NOT NULL,
            priority varchar(20) DEFAULT 'low' NOT NULL,
            support_agent tinytext NOT NULL,
            message text NOT NULL,
            response text DEFAULT NULL,
            attachment varchar(255) DEFAULT NULL,
            status varchar(20) DEFAULT 'new' NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Check for errors
        if (!empty($wpdb->last_error)) {
            error_log('Error creating support_tickets table: ' . $wpdb->last_error);
        }
    }
}

register_activation_hook(__FILE__, 'create_support_ticket_table');

// ==================================================================


// 🚩==================================================================
// فرم ثبت نام کاربر
function registration_form_shortcode() {
    ob_start();
    ?>
    <style>
        /* CSS برای فرم‌ها */
        .registration-form {
            background-color: #1F1F3A;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        .registration-form input,
        .registration-form select,
        .registration-form textarea {
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ccc;
            font-family: 'Yekan Bakh', sans-serif;
        }
        .submit-button {
            background-color: #FFD400;
            border: none;
            color: #1F1F3A;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <form class="registration-form" method="POST">
        <input type="text" name="username" placeholder="نام کاربری" required>
        <input type="email" name="email" placeholder="آدرس ایمیل" required>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <input type="submit" name="register_user" class="submit-button" value="ثبت نام">
    </form>

    <?php
    handle_registration();
    return ob_get_clean();
}
add_shortcode('registration_form', 'registration_form_shortcode');
// ==================================================================


// 🚩==================================================================

function handle_registration() {
    if (isset($_POST['register_user'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password
        );

        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            echo '<p style="color: green;">ثبت نام با موفقیت انجام شد.</p>';
        } else {
            echo '<p style="color: red;">خطا در ثبت نام: ' . $user_id->get_error_message() . '</p>';
        }
    }
}
// ==================================================================


// 🚩==================================================================

// [support_ticket_form] کد کوتاه برای فرم ارسال تیکت
function support_ticket_form_shortcode() {
    ob_start();
    ?>
    <style>
            .support-ticket-form {
                border: none;
                border-radius: 9px;
                background-color: lightblue;
                padding: 17px;
                text-align: center;
                display: flex;
                flex-direction: column;
            }
            .support-ticket-form input {
                margin-top: 9px;
                border: none;
                border-radius: 9px;
                padding: 9px;
                font-size: 16px;
            }
            .support-ticket-form textarea {
                margin: 9px;
                height: 66px;
            }
            .submit-button {
                border: none;
                border-radius: 9999px;
                background-color: tomato;
                margin-left: 22px;
            }
            .fileindex{
                margin: 0;
            }
    </style>

    <form class="support-ticket-form" method="POST" enctype="multipart/form-data">
        <input type="text" name="full_name" placeholder="نام و نام خانوادگی" required>
        <input type="email" name="email" placeholder="آدرس ایمیل" required>
        <input type="text" name="domain" placeholder="آدرس دامنه" required>
        <input type="text" name="subject" placeholder="موضوع" required>

        <label for="priority">الویت:</label>
        <select name="priority" required>
            <option value="low">کم</option>
            <option value="medium">متوسط</option>
            <option value="high">زیاد</option>
            <option value="urgent">اورژانسی</option>
        </select>

        <label for="support_agent">پشتیبان:</label>
        <select name="support_agent" required>
            <option value="مهدی رحیمی">مهندس مهدی رحیمی</option>
            <option value="نگین بهراملو">مهندس نگین بهراملو</option>
            <option value="ویدا رجبی">مهندس ویدا رجبی</option>
        </select>

        <textarea name="message" placeholder="متن پیام" required></textarea>
        <input type="file" name="attachment" class="fileindex">
        <!-- <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div> کلید سایت خود را در اینجا وارد کنید -->
        <input type="submit" name="submit_ticket" class="submit-button" value="ارسال تیکت">
    </form>

    <?php
    handle_ticket_submission();
    return ob_get_clean();
}
add_shortcode('support_ticket_form', 'support_ticket_form_shortcode');
// ==================================================================


// 🚩==================================================================

// تابع برای پردازش ارسال تیکت
function handle_ticket_submission() {
    if (isset($_POST['submit_ticket'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'support_tickets';
        $user_id = get_current_user_id();
        $ip_address = $_SERVER['REMOTE_ADDR'];

      // Validate reCAPTCHA
      //   $response = $_POST['g-recaptcha-response'];
        $secretKey = 'YOUR_SECRET_KEY';
        $remoteIp = $_SERVER['REMOTE_ADDR'];
      //   $url = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$response}&remoteip={$remoteIp}";
      //   $responseKeys = json_decode(file_get_contents($url), true);

      //   if (intval($responseKeys["success"]) !== 1) {
      //       echo '<p style="color:red;">لطفاً تأیید CAPTCHA را انجام دهید.</p>';
      //       return;
      //   }

        // Handle file upload
        $uploaded_file = $_FILES['attachment'];
        $allowed_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'application/zip', 'text/plain', 'application/pdf');

        if (in_array($uploaded_file['type'], $allowed_types) || empty($uploaded_file['name'])) {
            $attachment = '';

            if (!empty($uploaded_file['name'])) {
                $upload_dir = wp_upload_dir();
                $file_path = $upload_dir['path'] . '/' . basename($uploaded_file['name']);
                if (move_uploaded_file($uploaded_file['tmp_name'], $file_path)) {
                    $attachment = basename($uploaded_file['name']);
                }
            }

// doc : uniqid -> generate a time-based identifier  [ uniqid( string $prefix= "", bool $more_entropy = false) ]
            $tracking_code = uniqid('');

            $wpdb->insert($table_name, array(
                'tracking_code' => $tracking_code,
                'user_id' => $user_id,
                'ip_address' => $ip_address,
                'full_name' => sanitize_text_field($_POST['full_name']),
                'email' => sanitize_email($_POST['email']),
                'domain' => sanitize_text_field($_POST['domain']),
                'subject' => sanitize_text_field($_POST['subject']),
                'priority' => sanitize_text_field($_POST['priority']),
                'support_agent' => sanitize_text_field($_POST['support_agent']),
                'message' => sanitize_textarea_field($_POST['message']),
                'attachment' => $attachment,
                'status' => 'new',
            ));

            echo '<p style="color: green;">تیکت شما با موفقیت ارسال شد! کد پیگیری: ' . esc_html($tracking_code) . '</p>';
        } else {
            echo '<p style="color:red;">فقط پسوندهای مجاز را بارگذاری کنید.</p>';
        }
    }
}
// ==================================================================

// ==================================================================
// نمایش تیکت‌ها در پیشخوان با فیلتر بر اساس وضعیت
function display_tickets_in_admin() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'support_tickets';

    // فیلتر بر اساس وضعیت
    $status_filter = isset($_GET['ticket_status']) ? sanitize_text_field($_GET['ticket_status']) : 'all';

    $query = "SELECT * FROM $table_name";
    if ($status_filter !== 'all') {
        $query .= " WHERE status = '$status_filter'";
    }
    $tickets = $wpdb->get_results($query);

    echo '<h2>تیکت‌های دریافتی</h2>';
    
    // منوی فیلتر
    echo '<form method="GET">';
    echo '<select name="ticket_status">';
    echo '<option value="all"' . ($status_filter === 'all' ? ' selected' : '') . '>همه تیکت‌ها</option>';
    echo '<option value="new"' . ($status_filter === 'new' ? ' selected' : '') . '>تیکت‌های جدید</option>';
    echo '<option value="active"' . ($status_filter === 'active' ? ' selected' : '') . '>تیکت‌های فعال</option>';
    echo '<option value="closed"' . ($status_filter === 'closed' ? ' selected' : '') . '>تیکت‌های بسته شده</option>';
    echo '</select>';
    echo '<input type="submit" value="فیلتر" class="button">';
    echo '</form>';

    // شروع جدول
    echo '<table class="widefat striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>شماره پیگیری</th>';
    echo '<th>نام</th>';
    echo '<th>ایمیل</th>';
    echo '<th>موضوع</th>';
    echo '<th>الویت</th>';
    echo '<th>وضعیت</th>';
    echo '<th>تاریخ</th>';
    echo '<th>پیام</th>';
    echo '<th>پشتیبان</th>';
    echo '<th>عملیات</th>';
    echo '<th>پاسخ</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($tickets) {
        foreach ($tickets as $ticket) {
            echo '<tr>';
            echo '<td>' . esc_html($ticket->id) . '</td>';
            echo '<td>' . esc_html($ticket->tracking_code) . '</td>';
            echo '<td>' . esc_html($ticket->full_name) . '</td>';
            echo '<td>' . esc_html($ticket->email) . '</td>';
            echo '<td>' . esc_html($ticket->subject) . '</td>';
            echo '<td>' . esc_html($ticket->priority) . '</td>';
            echo '<td>' . esc_html($ticket->status) . '</td>';
            echo '<td>' . esc_html($ticket->created_at) . '</td>';
            echo '<td>' . esc_html($ticket->message) . '<a href="#popup" onclick="showModal()">Show Message</a>' . 
            '
                <div id="popup" style="display:none; width:800px; padding:22px; font-size:33px; position:fixed; top:50%; left:50%; 
                        transform:translate(-50%, -50%); background:tomato; padding:20px;
                        border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,0.1);">                
                        '. esc_html($ticket->message)/* in this part set get data from database on condition */ .' 
                    <button onclick="hideModal()">close</button> </div>

            '
            .'</td>';
            echo '<td>' . esc_html($ticket->support_agent) . '</td>';
            echo '<td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="ticket_id" value="' . esc_attr($ticket->id) . '">
                    <select name="status">
                        <option value="new"' . ($ticket->status === 'new' ? ' selected' : '') . '>جدید</option>
                        <option value="active"' . ($ticket->status === 'active' ? ' selected' : '') . '>فعال</option>
                        <option value="closed"' . ($ticket->status === 'closed' ? ' selected' : '') . '>بسته شده</option>
                    </select>
                    <input type="submit" name="update_status" value="به‌روزرسانی" class="button">
                </form>
            </td>';
            echo '<td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="ticket_id" value="' . esc_attr($ticket->id) . '">
                    <textarea name="response" placeholder="پاسخ..." required></textarea>
                    <input type="submit" name="submit_response" value="پاسخ" class="button">
                </form>
            </td>';
            echo '</tr>';

// =======================================================

// =======================================================
        }
    } else {
        echo '<tr><td colspan="11" style="text-align: center;">تیکتی موجود نیست.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // بررسی ارسال تغییرات وضعیت
    if (isset($_POST['update_status'])) {
        $ticket_id = intval($_POST['ticket_id']);
        $status = sanitize_text_field($_POST['status']);

        // بروزرسانی وضعیت تیکت
        $wpdb->update($table_name, array('status' => $status), array('id' => $ticket_id));

        echo '<div class="updated"><p>وضعیت تیکت با موفقیت به‌روزرسانی شد.</p></div>';
    }

    // بررسی ارسال پاسخ
    if (isset($_POST['submit_response'])) {
        $ticket_id = intval($_POST['ticket_id']);
        $response = sanitize_textarea_field($_POST['response']);

        // بروزرسانی پاسخ
        $wpdb->update($table_name, array('response' => $response), array('id' => $ticket_id));

        echo '<div class="updated"><p>پاسخ شما با موفقیت ثبت شد.</p></div>';
    }
}

// اضافه کردن منوی اصلی و زیرمنوها در پیشخوان
function add_ticket_menu() {
    add_menu_page('تیکت‌ها', 'تیکت‌ها', 'manage_options', 'support-tickets', 'display_tickets_in_admin');
    add_submenu_page('support-tickets', 'تیکت‌های جدید', 'تیکت‌های جدید', 'manage_options', 'new-tickets', 'filter_new_tickets');
    add_submenu_page('support-tickets', 'تیکت‌های فعال', 'تیکت‌های فعال', 'manage_options', 'active-tickets', 'filter_active_tickets');
    add_submenu_page('support-tickets', 'تیکت‌های بسته شده', 'تیکت‌های بسته شده', 'manage_options', 'closed-tickets', 'filter_closed_tickets');
}

function filter_new_tickets() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'support_tickets';
    $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='new'");
    display_ticket_list($tickets);
}

function filter_active_tickets() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'support_tickets';
    $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='active'");
    display_ticket_list($tickets);
}

function filter_closed_tickets() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'support_tickets';
    $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='closed'");
    display_ticket_list($tickets);
}

function display_ticket_list($tickets) {
    echo '<h2>تیکت‌های مربوطه</h2>';
    // شروع جدول
    echo '<table class="widefat striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>شماره پیگیری</th>';
    echo '<th>نام</th>';
    echo '<th>ایمیل</th>';
    echo '<th>موضوع</th>';
    echo '<th>الویت</th>';
    echo '<th>وضعیت</th>';
    echo '<th>تاریخ</th>';
    echo '<th>پیام</th>';
    echo '<th>پشتیبان</th>';
    echo '<th>عملیات</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($tickets) {
        foreach ($tickets as $ticket) {
            echo '<tr>';
            echo '<td>' . esc_html($ticket->id) . '</td>';
            echo '<td>' . esc_html($ticket->tracking_code) . '</td>';
            echo '<td>' . esc_html($ticket->full_name) . '</td>';
            echo '<td>' . esc_html($ticket->email) . '</td>';
            echo '<td>' . esc_html($ticket->subject) . '</td>';
            echo '<td>' . esc_html($ticket->priority) . '</td>';
            echo '<td>' . esc_html($ticket->status) . '</td>';
            echo '<td>' . esc_html($ticket->created_at) . '</td>';
            echo '<td>' . esc_html($ticket->message) . '</td>';
            echo '<td>' . esc_html($ticket->support_agent) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="10" style="text-align: center;">تیکتی موجود نیست.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
}

// اضافه کردن منوی اصلی و زیرمنوها در پیشخوان
add_action('admin_menu', 'add_ticket_menu');

// فرم پیگیری تیکت
// shortcode = [tracking_form]
function tracking_form_shortcode() {
    ob_start();
    ?>
    <style>
        .box{
            border-radius: 9px;
            background-color: lightblue;
            align-items: center;
            text-align: center;
            padding: 9px;
        }
        .ticket {
            background-color: lightblue;
            border-radius: 9px;
            padding: 9px;
            display: flex;
            flex-direction: column;
        }
        .ticket h3 {
            text-align: center;
        }
    </style>
    <div class="box">
        <h2>پیگیری تیکت</h2>
        <form method="POST">
            <input type="text" name="tracking_code" placeholder="شماره پیگیری" required>
            <input type="submit" name="submit_tracking" value="پیگیری" class="submit-button">
        </form>
    </div>
    <?php

    if (isset($_POST['submit_tracking'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'support_tickets';
        $tracking_code = sanitize_text_field($_POST['tracking_code']);

        $ticket = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE tracking_code = %s", $tracking_code));

        if ($ticket) {
            echo '<div class="ticket">';
            echo '<h3>جزئیات تیکت شما</h3>';
            echo '<p><strong>موضوع:</strong> ' . esc_html($ticket->subject) . '</p>';
            echo '<p><strong>وضعیت:</strong> ' . esc_html($ticket->status) . '</p>';
            echo '<p><strong>پاسخ:</strong> ' . esc_html($ticket->response ? $ticket->response : 'پاسخی دریافت نکرده‌اید.') . '</p>';
            echo '</div>';
        } else {
            echo '<p style="color: red;">تیکتی با این شماره پیگیری پیدا نشد.</p>';
        }
    }

    return ob_get_clean();
}
add_shortcode('tracking_form', 'tracking_form_shortcode');


// ایمن‌سازی با اضافه کردن محدودیت برای بارگذاری فایل‌ها
function secure_file_uploads() {
    // Limit file sizes (in bytes)
    @ini_set('upload_max_filesize', '5M');
}
add_action('init', 'secure_file_uploads');


// افزودن فیلد برای نشان دادن وضعیت تیکت در فرم
function add_status_field_in_ticket_form() {
    echo '<input type="hidden" name="ticket_status" value="new">';
}
add_action('support_ticket_form', 'add_status_field_in_ticket_form');


?>
    <script>
    function showModal() {
        document.getElementById('popup').style.display = 'block';
    }

    function hideModal() {
        document.getElementById('popup').style.display = 'none';
    }
    </script>
<?php

?>