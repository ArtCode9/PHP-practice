<?php
function scf_shortcode_handler($atts) {
   ob_start(); // شروع بافر خروجی
   
   // فقط برای کاربران لاگین شده
   if (!is_user_logged_in()) {
       return '<p>برای دسترسی به این بخش باید وارد سایت شوید.</p>';
   }
   
   // بررسی سطح دسترسی
   if (!current_user_can('manage_options')) {
       return '<p>شما مجوز دسترسی به این بخش را ندارید.</p>';
   }
   
   // دریافت پارامترهای شورتکد
   $atts = shortcode_atts(array(
       'show_form' => 'yes',
       'show_list' => 'yes'
   ), $atts);
   
   // نمایش فرم یا لیست بر اساس پارامترها
   if ($atts['show_form'] === 'yes') {
       scf_render_frontend_form();
   }
   
   if ($atts['show_list'] === 'yes') {
       scf_render_frontend_list();
   }
   
   return ob_get_clean(); // بازگرداندن محتوای بافر
}


function scf_render_frontend_form() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'simple_contact_form';
   
   // پردازش ارسال فرم
   if (isset($_POST['scf_frontend_submit'])) {
       $nonce = $_POST['scf_frontend_nonce'] ?? '';
       
       if (wp_verify_nonce($nonce, 'scf_frontend_action')) {
           $data = array(
               'name' => sanitize_text_field($_POST['name']),
               'email' => sanitize_email($_POST['email']),
               'phone' => sanitize_text_field($_POST['phone'])
           );
           
           $wpdb->insert($table_name, $data);
           
           echo '<div class="scf-alert success">تماس با موفقیت ذخیره شد.</div>';
       }
   }
   
   // نمایش فرم
   ?>
   <div class="scf-frontend-form">
       <h3>فرم تماس جدید</h3>
       <form method="post">
           <?php wp_nonce_field('scf_frontend_action', 'scf_frontend_nonce'); ?>
           
           <div class="scf-form-group">
               <label for="scf_name">نام کامل</label>
               <input type="text" id="scf_name" name="name" required>
           </div>
           
           <div class="scf-form-group">
               <label for="scf_email">آدرس ایمیل</label>
               <input type="email" id="scf_email" name="email" required>
           </div>
           
           <div class="scf-form-group">
               <label for="scf_phone">شماره تلفن</label>
               <input type="tel" id="scf_phone" name="phone" required>
           </div>
           
           <button type="submit" name="scf_frontend_submit" class="scf-submit-btn">ذخیره اطلاعات</button>
       </form>
   </div>
   <?php
}



function scf_render_frontend_list() {
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
}



function scf_frontend_styles() {
   wp_enqueue_style('scf-frontend-css', plugins_url('assets/css/frontend.css', __FILE__));
    wp_enqueue_script('scf-frontend-js', plugins_url('assets/js/frontend.js', __FILE__), array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'scf_frontend_styles');