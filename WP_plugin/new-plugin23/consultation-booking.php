<?php 
/* 
   Plugin Name: Consultation Booking System📦
   Description: System consulting for HIS
   Version: 1.0
   Author: Your Name
*/

defined('ABSPATH') || die('Access Denied');

// define constant
define('CONS_BOOKING_VERSION' , '1.0');
define('CONS_BOOKING_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CONS_BOOKING_PLUGIN_URI', plugin_dir_url(__FILE__));


// primary file 
require_once CONS_BOOKING_PLUGIN_DIR . 'includes/class-db.php';
require_once CONS_BOOKING_PLUGIN_DIR . 'includes/class-admin.php';
require_once CONS_BOOKING_PLUGIN_DIR . 'includes/class-ajax.php';
require_once CONS_BOOKING_PLUGIN_DIR . 'includes/class-shortcodes.php';

require_once CONS_BOOKING_PLUGIN_DIR . 'includes/admin-section.php';

// active plugin
// first parameter is main dir plugin file and second parameter is callback , can be a function or method class this is class
register_activation_hook(__FILE__ , ['Consultation_DB', 'activate']);

// deactivate plugin
register_deactivation_hook(__FILE__, ['Consultation_DB', 'deactivate']);



// load file 
add_action('plugin_loaded', 'consultation_booking_load_textdomain');
function consultation_booking_load_textdomain () {
      load_plugin_textdomain('consultation-booking', false , dirname(plugin_basename(__FILE__))
                        . '/languages');
}

add_action('admin_menu', 'add_admin_menu');
function add_admin_menu() {
      add_menu_page(
          'Setttings',
          'Setttings',
          'manage_options',
          'my-plugin',
          'render_admin_page',
          'dashicons-admin-generic',
          6
      );

      add_menu_page(
            'Cloak',
            'Cloak',
            'manage_options',
            'my-plugin2',
            'render_admin_page2',
            'dashicons-admin-generic',
            7
      );

  }

function render_admin_page(){
      require_once CONS_BOOKING_PLUGIN_DIR . 'templates/manage-section.php';
}


// add style and scripts
add_action('wp_enqueue_scripts', 'consultation_booking_scripts');
function consultation_booking_scripts (){

      // styles
      wp_enqueue_style(
            'consultation-booking-style',   // specific name for the style
            plugins_url('assets/css/style.css', __FILE__),  // plugin_url create full directory of plugin files and __FILE__ main address plugin file
            [],  // this array is for list of css style but here there is nothing for it
            CONS_BOOKING_VERSION  // we use plugin version for prevent browser cash
      );

      // scripts    wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
      wp_enqueue_script(
            'consultation-booking-script',     // specific name for the scripts
            plugins_url('assets/js/script.js', __FILE__),     // address file
            ['jquery'],                               // lib jquery
            CONS_BOOKING_VERSION,                     // script version
            true                                      // load file in footer
      );

            
      // local scripts
      wp_localize_script(     // wp_localize_script($handle, $object_name, $l10n);
            'consultation-booking-script',  // script address name above
            'consultation_booking_ajax',    // object name in javascript
            [
                  'ajaxurl' => admin_url('admin-ajax.php'),
                  'nonce'   => wp_create_nonce('consultation_booking_nonce')
            ]
      );
}


