<?php

function add_ticket_menu() {
   global $wpdb;
   $table_name = $wpdb->prefix . '_support_tickets';
   
   // Get count of new, unviewed tickets
   $new_tickets_count = $wpdb->get_var(
       $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE status = %s AND viewed = %d", 'new', 0)
   );


       // Add menu with notification bubble
       add_menu_page(
         'تیکت‌ها', 
         $new_tickets_count > 0 ? sprintf('تیکت‌ها <span class="update-plugins count-%d"><span class="plugin-count">%d</span></span>', $new_tickets_count, $new_tickets_count) : 'تیکت‌ها',
         'manage_options',
         'support-tickets',
         'display_tickets_in_admin',
         'dashicons-tickets',
         6
       );

   add_submenu_page(
      'support-tickets',
      'تیکت‌های جدید',
      $new_tickets_count > 0 ? sprintf('تیکت‌های جدید <span class="update-plugins count-%d">
                                       <span class="plugin-count">%d</span></span>',
                                       $new_tickets_count, $new_tickets_count)
      : 'تیکت‌های جدید',
      'manage_options',
      'new-tickets',
      'filter_new_tickets'
         );

   add_submenu_page(
      'support-tickets',
      'تیکت‌های فعال',
      'تیکت‌های فعال',
      'manage_options',
      'active-tickets', 
      'filter_active_tickets'
         );

   add_submenu_page(
      'support-tickets',
      'تیکت‌های بسته شده',
      'تیکت‌های بسته شده',
      'manage_options',
      'closed-tickets',
      'filter_closed_tickets'
         );
}

function filter_new_tickets() {
   global $wpdb;
   $table_name = $wpdb->prefix . '_support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='new'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}

function filter_active_tickets() {
   global $wpdb;
   $table_name = $wpdb->prefix . '_support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='active'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}

function filter_closed_tickets() {
   global $wpdb;
   $table_name = $wpdb->prefix . '_support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='closed'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}