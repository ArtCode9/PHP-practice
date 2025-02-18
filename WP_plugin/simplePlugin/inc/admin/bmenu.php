<?php

function simple_plugin_add_menu(){
      add_menu_page('Axemenu',
                   'Axemenu',
                   'manage_options',
                   'simple_menu',
                   'simple_menu_callback');
};
function simple_plugin_add_menu2(){
   add_menu_page('Axemen2u',
                'Axemen2u',
                'manage_options',
                'simple_menu',
                'simple_menu_callback');
};
function simple_menu_callback(){};

add_action('admin_menu', 'simple_plugin_add_menu');
// add_action('admin_menu', 'simple_plugin_add_menu2');
