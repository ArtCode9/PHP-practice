<?php

// register form
function registration_form_shortcode2() {
      ob_start();
      ?>
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


// تابع برای پردازش ارسال تیکت
function handle_ticket_submission() {
   if (isset($_POST['submit_ticket'])) {
       global $wpdb;
       $table_name = $wpdb->prefix . '_support_tickets';
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
        $table_name = $wpdb->prefix . '_support_tickets';
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