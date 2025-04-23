<?php 

function add_pop_up_script (){
    wp_enqueue_style(
        'support-tickets',
        PLUG_TICKET_URL . 'assets/css/admin-ui.css',
        [],
        PLUG_TICKET_VERSION
    );

    wp_enqueue_script(
        'support-tickets',
        PLUG_TICKET_URL . 'assets/js/script.js',
        ['jquery'],
        PLUG_TICKET_VERSION,
        true
    );
};

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
                  phone VARCHAR(25) NOT NULL,
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
     /*  not working 1️⃣: 
     global $wpdb;
      $table_name = $wpdb->prefix . '_support_tickets';
  
      // فیلتر بر اساس وضعیت
      $status_filter = isset($_GET['ticket_status']) ? sanitize_text_field($_GET['ticket_status']) : 'all';
    
      $query = "SELECT * FROM $table_name";
      // Only add WHERE clause if filtering for a specific status (not 'all')
      if (in_array($status_filter, ['new', 'active', 'closed'])) {
            $query .= $wpdb->prepare(" WHERE status = %s", $status_filter);
      }

      $tickets = $wpdb->get_results($query); */

      /* not working 2️⃣:
      global $wpdb;

    // 1. Ensure the table prefix is correct
    $table_name = $wpdb->prefix . '_support_tickets'; // Removed underscore (_) if not part of your table name

    // 2. Safely get the status filter (default: 'all')
    $status_filter = isset($_GET['ticket_status']) ? sanitize_text_field($_GET['ticket_status']) : 'all';

    // 3. Start building the query
    $query = "SELECT * FROM {$table_name}";

    // 4. Add WHERE clause only for valid statuses
    if (in_array($status_filter, ['new', 'active', 'closed'], true)) { // `true` for strict type checking
        $query .= $wpdb->prepare(" WHERE status = %s", $status_filter);
    }

    // 5. Execute & debug (temporarily add this for testing)
    $tickets = $wpdb->get_results($query);

    // 6. Check for database errors
    if ($wpdb->last_error) {
        wp_die('Database error: ' . esc_html($wpdb->last_error)); // Show error safely
    }

    // 7. Debug output (remove later)
    echo '<pre>';
    var_dump($tickets); // Check if data is returned
    echo '</pre>'; */

  
    global $wpdb;
    
    // 1. Correct table name (remove extra underscore if not needed)
    $table_name = $wpdb->prefix . '_support_tickets'; // Changed from 'support_tickets'
    
    // 2. Get current admin URL without existing query args
    $admin_url = admin_url('admin.php?page=support-tickets');
    
    // 3. Safely get the status filter
    $status_filter = isset($_GET['ticket_status']) ? sanitize_text_field($_GET['ticket_status']) : 'all';
    
    // 4. Build base query
    $query = "SELECT * FROM {$table_name}";
    $where = array();
    
    // 5. Add status condition if needed
    if (in_array($status_filter, ['new', 'active', 'closed'], true)) {
        $where[] = $wpdb->prepare("status = %s", $status_filter);
    }
    
    // 6. Combine WHERE clauses if any
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    // 7. Add ordering
    $query .= " ORDER BY created_at DESC";
    
    // 8. Execute query
    $tickets = $wpdb->get_results($query);
    
    // Error handling
    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);
        echo '<div class="error"><p>خطا در دریافت اطلاعات از پایگاه داده</p></div>';
    }
    
    // Display filter form
    echo '<h2>تیکت‌های دریافتی</h2>';
    echo '<form method="GET" action="' . esc_url($admin_url) . '">';
    echo '<input type="hidden" name="page" value="support-tickets">';
    echo '<select name="ticket_status">';
    echo '<option value="all"' . selected($status_filter, 'all', false) . '>همه تیکت‌ها</option>';
    echo '<option value="new"' . selected($status_filter, 'new', false) . '>تیکت‌های جدید</option>';
    echo '<option value="active"' . selected($status_filter, 'active', false) . '>تیکت‌های فعال</option>';
    echo '<option value="closed"' . selected($status_filter, 'closed', false) . '>تیکت‌های بسته شده</option>';
    echo '</select>';
    echo '<input type="submit" value="فیلتر" class="button">';
    echo '</form>';
    echo '<br>';



    // Add JavaScript for the popup
    echo '<script>
    function showModal(ticketId) {
        document.getElementById("popup-overlay-" + ticketId).style.display = "block";
        document.getElementById("popup-" + ticketId).style.display = "block";
    }
    
    function hideModal(ticketId) {
        document.getElementById("popup-overlay-" + ticketId).style.display = "none";
        document.getElementById("popup-" + ticketId).style.display = "none";
    }
    </script>';


      // شروع جدول
      echo '<table class="widefat striped" id="tableBox">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>ID</th>';
      echo '<th>شماره پیگیری</th>';
      echo '<th>نام</th>';
      echo '<th>ایمیل</th>';
      echo '<th>تلفن</th>';
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
              echo '<td>' . esc_html($ticket->phone) . '</td>';
              echo '<td>' . esc_html($ticket->subject) . '</td>';
              echo '<td>' . esc_html($ticket->priority) . '</td>';
              echo '<td>' . esc_html($ticket->status) . '</td>';
              echo '<td>' . esc_html($ticket->created_at) . '</td>';
              echo '<td><a href="javascript:void(0)" onclick="showModal('
               . $ticket->id . ')" style="font-size:33px;" title="View full message">🎫</a></td>';

              // Popup HTML for this ticket
            echo '<div class="popup-overlay" id="popup-overlay-' . $ticket->id . '"></div>';
            echo '<div class="ticket-popup" id="popup-' . $ticket->id . '">';
            echo '<h3>پیام تیکت #' . $ticket->id . '</h3>';
            echo '<p>' . nl2br(esc_html($ticket->message)) . '</p>';
            echo '<button onclick="hideModal(' . $ticket->id . ')">بستن</button>';
            echo '</div>';


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
  