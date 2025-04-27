<?php
function scf_shortcode_handler($atts) {
   ob_start();
   
   // بررسی لاگین بودن کاربر
   if (!is_user_logged_in()) {
       return '<div class="scf-alert error">برای دسترسی به این بخش باید وارد سایت شوید.</div>';
   }
   
   // بررسی سطح دسترسی
   if (!current_user_can('manage_options')) {
       return '<div class="scf-alert error">شما مجوز دسترسی به این بخش را ندارید.</div>';
   }
   
   // پردازش فرم ارسالی
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scf_frontend_submit'])) {
       scf_process_frontend_form();
   }
   
   // نمایش پیام‌ها
   if (isset($_GET['scf_message'])) {
       switch ($_GET['scf_message']) {
           case 'added':
               echo '<div class="scf-alert success">تماس جدید با موفقیت ثبت شد.</div>';
               break;
       }
   }
   
   // نمایش محتوا
   $atts = shortcode_atts(array(
       'show_form' => 'yes',
       'show_list' => 'yes'
   ), $atts);
   
   if ($atts['show_form'] === 'yes') {
       scf_render_frontend_form();
   }
   
   if ($atts['show_list'] === 'yes') {
       scf_render_frontend_list();
   }
   
   return ob_get_clean();
}

function scf_process_frontend_form() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'simple_contact_form';
   
   // بررسی nonce
   if (!isset($_POST['scf_frontend_nonce']) || !wp_verify_nonce($_POST['scf_frontend_nonce'], 'scf_frontend_action')) {
       echo '<div class="scf-alert error">خطای امنیتی رخ داده است.</div>';
       return false;
   }
   
   // اعتبارسنجی فیلدها
   $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
   $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
   $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
   
   if (empty($name) || empty($email) || empty($phone)) {
       echo '<div class="scf-alert error">لطفاً تمام فیلدهای ضروری را پر کنید.</div>';
       return false;
   }
   
   // ذخیره در دیتابیس
   $result = $wpdb->insert($table_name, array(
       'name' => $name,
       'email' => $email,
       'phone' => $phone
   ), array('%s', '%s', '%s'));
   
   if ($result === false) {
       echo '<div class="scf-alert error">خطا در ذخیره اطلاعات: ' . $wpdb->last_error . '</div>';
       return false;
   }
   
   // ریدایرکت برای جلوگیری از ارسال مجدد فرم
   wp_redirect(add_query_arg('scf_message', 'added', wp_get_referer()));
   exit;
}


function scf_render_frontend_form() {
   // مقادیر قبلی برای نمایش در صورت خطا
   $name = isset($_POST['name']) ? esc_attr($_POST['name']) : '';
   $email = isset($_POST['email']) ? esc_attr($_POST['email']) : '';
   $phone = isset($_POST['phone']) ? esc_attr($_POST['phone']) : '';
   ?>
   <div class="scf-frontend-form">
       <h3>فرم تماس جدید</h3>
       <form method="post">
           <?php wp_nonce_field('scf_frontend_action', 'scf_frontend_nonce'); ?>
           
           <div class="scf-form-group">
               <label for="scf_name">نام کامل</label>
               <input type="text" id="scf_name" name="name" value="<?php echo $name; ?>" required>
           </div>
           
           <div class="scf-form-group">
               <label for="scf_email">آدرس ایمیل</label>
               <input type="email" id="scf_email" name="email" value="<?php echo $email; ?>" required>
           </div>
           
           <div class="scf-form-group">
               <label for="scf_phone">شماره تلفن</label>
               <input type="tel" id="scf_phone" name="phone" value="<?php echo $phone; ?>" required>
           </div>
           
           <button type="submit" name="scf_frontend_submit" class="scf-submit-btn">ذخیره اطلاعات</button>
       </form>
   </div>
   <?php
}



/* function scf_render_frontend_list() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'simple_contact_form';
   
   // پارامترهای جستجو و فیلتر
   $search = isset($_GET['scf_search']) ? sanitize_text_field($_GET['scf_search']) : '';
   $date_from = isset($_GET['scf_date_from']) ? sanitize_text_field($_GET['scf_date_from']) : '';
   $date_to = isset($_GET['scf_date_to']) ? sanitize_text_field($_GET['scf_date_to']) : '';
   
   // ساخت کوئری
   $query = "SELECT * FROM $table_name";
   $where = array();
   $params = array();
   
   if (!empty($search)) {
       $where[] = "(name LIKE %s OR email LIKE %s OR phone LIKE %s)";
       $search_term = '%' . $wpdb->esc_like($search) . '%';
       $params = array_merge($params, array($search_term, $search_term, $search_term));
   }
   
   if (!empty($date_from)) {
       $where[] = "created_at >= %s";
       $params[] = $date_from;
   }
   
   if (!empty($date_to)) {
       $where[] = "created_at <= %s";
       $params[] = $date_to . ' 23:59:59';
   }
   
   if (!empty($where)) {
       $query .= " WHERE " . implode(" AND ", $where);
   }
   
   $query .= " ORDER BY created_at DESC";
   
   // اجرای کوئری
   if (!empty($params)) {
       $contacts = $wpdb->get_results($wpdb->prepare($query, $params));
   } else {
       $contacts = $wpdb->get_results($query);
   }
   
   // پردازش عملیات حذف
   if (isset($_GET['scf_action']) && $_GET['scf_action'] === 'delete' && isset($_GET['scf_id'])) {
       $id = intval($_GET['scf_id']);
       $nonce = $_GET['scf_nonce'] ?? '';
       
       if (wp_verify_nonce($nonce, 'scf_delete_' . $id)) {
           $wpdb->delete($table_name, array('id' => $id));
           echo '<div class="scf-alert success">مخاطب با موفقیت حذف شد.</div>';
       }
   }
   
   // نمایش فرم جستجو و فیلتر
   ?>
   <div class="scf-frontend-list">
       <h3>لیست مخاطبین</h3>
       
       <form method="get" class="scf-search-form">
           <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">
           
           <div class="scf-search-fields">
               <input type="text" name="scf_search" value="<?php echo esc_attr($search); ?>" placeholder="جستجو...">
               
               <div class="scf-date-filters">
                   <label>از تاریخ: <input type="date" name="scf_date_from" value="<?php echo esc_attr($date_from); ?>"></label>
                   <label>تا تاریخ: <input type="date" name="scf_date_to" value="<?php echo esc_attr($date_to); ?>"></label>
               </div>
               
               <button type="submit" class="scf-filter-btn">فیلتر</button>
               <a href="?page_id=<?php echo get_the_ID(); ?>" class="scf-clear-btn">پاک کردن فیلترها</a>
           </div>
       </form>
       
       <div class="scf-contacts-table">
           <table>
               <thead>
                   <tr>
                       <th>نام</th>
                       <th>ایمیل</th>
                       <th>تلفن</th>
                       <th>تاریخ ثبت</th>
                       <th>عملیات</th>
                   </tr>
               </thead>
               <tbody>
                   <?php if (empty($contacts)): ?>
                       <tr>
                           <td colspan="5">هیچ مخاطبی یافت نشد</td>
                       </tr>
                   <?php else: ?>
                       <?php foreach ($contacts as $contact): ?>
                           <tr>
                               <td><?php echo esc_html($contact->name); ?></td>
                               <td><?php echo esc_html($contact->email); ?></td>
                               <td><?php echo esc_html($contact->phone); ?></td>
                               <td><?php echo esc_html($contact->created_at); ?></td>
                               <td class="scf-actions">
                                   <a href="?page_id=<?php echo get_the_ID(); ?>&scf_action=delete&scf_id=<?php echo $contact->id; ?>&scf_nonce=<?php echo wp_create_nonce('scf_delete_' . $contact->id); ?>" 
                                      class="scf-delete-btn" 
                                      onclick="return confirm('آیا از حذف این مخاطب مطمئن هستید؟')">حذف</a>
                                   <button class="scf-print-btn" onclick="window.open('<?php echo add_query_arg(array(
                                       'scf_action' => 'print',
                                       'scf_id' => $contact->id,
                                       'scf_nonce' => wp_create_nonce('scf_print_' . $contact->id)
                                   ), get_permalink()); ?>', '_blank')">پرینت</button>
                               </td>
                           </tr>
                       <?php endforeach; ?>
                   <?php endif; ?>
               </tbody>
           </table>
       </div>
   </div>
   <?php
} */


function scf_render_frontend_list() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'simple_contact_form';
   
   // ساخت کوئری پایه
   $query = "SELECT * FROM $table_name WHERE 1=1";
   $query_params = array();
   
   // اضافه کردن شرایط جستجو اگر وجود دارد
   if (isset($_GET['scf_search']) && !empty($_GET['scf_search'])) {
       $search_term = '%' . $wpdb->esc_like(sanitize_text_field($_GET['scf_search'])) . '%';
       $query .= " AND (name LIKE %s OR email LIKE %s OR phone LIKE %s)";
       $query_params = array_merge($query_params, array($search_term, $search_term, $search_term));
   }
   
   $query .= " ORDER BY created_at DESC";
   
   // اجرای کوئری
   if (!empty($query_params)) {
       $contacts = $wpdb->get_results($wpdb->prepare($query, $query_params));
   } else {
       $contacts = $wpdb->get_results($query);
   }
   
   // نمایش لیست
   ?>
   <div class="scf-contacts-table">
       <?php if (empty($contacts)): ?>
           <div class="scf-alert info">هیچ مخاطبی یافت نشد.</div>
       <?php else: ?>
           <table>
               <thead>
                   <tr>
                       <th>نام</th>
                       <th>ایمیل</th>
                       <th>تلفن</th>
                       <th>تاریخ ثبت</th>
                       <th>عملیات</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($contacts as $contact): ?>
                       <tr>
                           <td><?php echo esc_html($contact->name); ?></td>
                           <td><?php echo esc_html($contact->email); ?></td>
                           <td><?php echo esc_html($contact->phone); ?></td>
                           <td><?php echo esc_html($contact->created_at); ?></td>
                           <td class="scf-actions">
                               <!-- دکمه‌های عملیات -->
                               <a href="?page_id=<?php echo get_the_ID(); ?>&scf_action=delete&scf_id=<?php echo $contact->id; ?>&scf_nonce=<?php echo wp_create_nonce('scf_delete_' . $contact->id); ?>" 
                                      class="scf-delete-btn" 
                                      onclick="return confirm('آیا از حذف این مخاطب مطمئن هستید؟')">حذف</a>
                                   <button class="scf-print-btn" onclick="window.open('<?php echo add_query_arg(array(
                                       'scf_action' => 'print',
                                       'scf_id' => $contact->id,
                                       'scf_nonce' => wp_create_nonce('scf_print_' . $contact->id)
                                   ), get_permalink()); ?>', '_blank')">پرینت</button>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
       <?php endif; ?>
   </div>
   <?php
}



function scf_frontend_styles() {
   wp_enqueue_style('scf-frontend-css', plugins_url('assets/css/frontend.css', __FILE__));
    wp_enqueue_script('scf-frontend-js', plugins_url('assets/js/frontend.js', __FILE__), array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'scf_frontend_styles');