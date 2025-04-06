<?php
/*
Plugin Name: Gamer Manager
Description: A plugin to manage gamers and their associated games
Version: 1.0
Author: ART CODE
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/gamer-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/gamer-meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/gamer-shortcodes.php';

// Enqueue admin scripts and styles
function gamer_manager_admin_scripts() {
    wp_enqueue_style('gamer-manager-admin', plugins_url('assets/css/admin.css', __FILE__));
    wp_enqueue_script('gamer-manager-admin', plugins_url('assets/js/admin.js', __FILE__),
    array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'gamer_manager_admin_scripts');

// Enqueue frontend scripts and styles
function gamer_manager_frontend_scripts() {
    wp_enqueue_style('gamer-manager-frontend', plugins_url('assets/css/frontend.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'gamer_manager_frontend_scripts');