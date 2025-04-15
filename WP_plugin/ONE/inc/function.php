<?php 

// menu
function add_submenu_admin(){
   add_menu_page(
      'setting',
      'setting',
      'manage_options',
      'admin-section',
      'admin_menu_section_ui',
      'dashicons-menu-alt3',
      6
   );
}

function admin_menu_section_ui(){
   require_once ONE_PLUG_DIR . 'temp/admin.php';
}


// add style and scripts
function my_plugin_style() {
      // register style
      wp_enqueue_style(
         'my-plugin-frontend',
         ONE_PLUG_URI . 'assets/css/style.css',
         [],
         ONE_PLUG_VERSION
      );
      // add js for admin
   wp_enqueue_script(
      'my-plugin-frontend-js',
      ONE_PLUG_URI . 'assets/js/ad-script.js',
      ['jquery'],
      ONE_PLUG_VERSION,
      true
   );

}
function admin_plugin_style() {
   // register style for admin
   wp_enqueue_style(
      'my-plugin-admin',
      ONE_PLUG_URI . 'assets/css/ad-style.css',
      [],
      ONE_PLUG_VERSION
   );
   // // add js for admin
   // wp_enqueue_script(
   //    'my-plugin-admin-js',
   //    ONE_PLUG_URI . 'assets/js/ad-script.js',
   //    ['jquery'],
   //    ONE_PLUG_VERSION,
   //    true
   // );
}