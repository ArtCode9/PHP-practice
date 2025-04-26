<?php
/* 
   Plugin Name: Ticket System
   Plugin URI: www.artcode9.com
   Description: Ticket problem sending and response
   Version: 2.0.0
   Author: Vida Rajabi & ArtCode9
   Author URI: www.artcode9.com
   Tex Domain: plug-ticket
   Domain Path: /languages/
*/

defined('ABSPATH') || exit;



define('PLUG_TICKET_VERSION' , '1.0.0');
define('PLUG_TICKET_DIR' , plugin_dir_path(__FILE__));
define('PLUG_TICKET_URL' , plugin_dir_url(__FILE__));



require_once PLUG_TICKET_DIR . 'includes/functions.php';
require_once PLUG_TICKET_DIR . 'includes/short.php';
require_once PLUG_TICKET_DIR . 'includes/admin.php';


register_activation_hook(__FILE__ , 'create_support_ticket_table2');



// register form [registration_form]
add_shortcode('registration_form' , 'registration_form_shortcode2');
// ticket form [support_ticket_form]
add_shortcode('support_ticket_form', 'support_ticket_form_shortcode');

add_shortcode('tracking_form', 'tracking_form_shortcode');



// add menu
add_action('admin_menu', 'add_ticket_menu');



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


add_action('admin_enqueue_scripts', 'add_pop_up_script');
