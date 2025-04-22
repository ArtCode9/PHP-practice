<?php

function add_ticket_menu() {
   add_menu_page(
         'تیکت‌ها', 
         'تیکت‌ها',
         'manage_options',
         'support-tickets',
         'display_tickets_in_admin'
         );

   add_submenu_page(
      'support-tickets',
      'تیکت‌های جدید',
      'تیکت‌های جدید',
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
   $table_name = $wpdb->prefix . 'support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='new'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}

function filter_active_tickets() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='active'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}

function filter_closed_tickets() {
   global $wpdb;
   $table_name = $wpdb->prefix . 'support_tickets';
   $tickets = $wpdb->get_results("SELECT * FROM $table_name WHERE status='closed'");
   require_once PLUG_TICKET_DIR . 'templates/display.php';
   display_ticket_list($tickets);
}