<?php

function wp_admin_add_menu() {
      add_menu_page(
         'main',
         'main',
         'manage_options',
         'third-plugin',
         'add_menu_to_admin_section',
         'dashicons-editor-removeformatting',
         6
      );
}

function add_menu_to_admin_section() {
   require_once THIRD_PLUGIN_DIR . 'temp/admin-ui.php';
}