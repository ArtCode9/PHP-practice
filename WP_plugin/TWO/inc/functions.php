<?php 

function add_menu_admin_section() {
   add_menu_page(
      'Main',
      'Main',
      'manage_options',
      'main-slug',
      'add_admin_menu_section',
      'dashicons-image-crop',
      6
   );
}

function add_admin_menu_section () {
   require_once TOW_PLUG_DIR . 'temp/admin-ui.php';
}


function add_menu_admin_section_two() {
   add_menu_page(
      'User',
      'User',
      'manage_options',
      'user-slug',
      'add_user_menu_section',
      'dashicons-image-crop',
      6
   );
}

function add_user_menu_section () {
   require_once TOW_PLUG_DIR . 'temp/admin-user.php';
}


//add style
function add_style_to_short () {
   wp_enqueue_style(
      'pugin-front-style',
      TOW_PLUG_URL . 'assets/css/front.css',
      [],
      TOW_PLUG_VERSION
   );
}