<?php

function simple_plugin_add_menu(){
      add_menu_page('منوی سفارشی',
                   'منوی سفارشی',
                   'manage_options',
                   'simple_menu',
                   'simple_menu_callback');
};
function simple_menu_callback(){};

add_action('admin_menu', 'simple_plugin_add_menu');

