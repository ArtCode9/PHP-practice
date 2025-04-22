<?php 

function create_support_ticket_table2() {
      global $wpdb;
      $table_name = $wpdb->prefix . '_support_tickets';
      $charset_collate = $wpdb->get_charset_collate();

      // check if the table already exists
      if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
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

              // check for errors
              if(!empty($wpdb->last_error)) {
                  error_log('Error creating support_tickets table :' . $wpdb->last_error);
              }
      }
}

function display_tickets_in_admin() {
      global $wpdb;
      $table_name = $wpdb->prefix . '_support_tickets';
  
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
  