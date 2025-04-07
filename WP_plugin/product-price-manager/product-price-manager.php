<?php
/*
Plugin Name: مدیریت حرفه ای قیمت محصولات
Description: افزونه جامع مدیریت قیمت با امکان ویرایش دسته‌ای، فیلتر پیشرفته و مدیریت محصولات
Version: 3.0
Author: kiyanmehr
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/price-update.php';

function ppm_enqueue_scripts() {
    wp_enqueue_style('ppm-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('ppm-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
    
    wp_localize_script('ppm-script', 'ppm_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ppm_nonce'),
        'confirm_delete' => 'آیا از حذف محصولات انتخاب شده اطمینان دارید؟'
    ]);
}
add_action('admin_enqueue_scripts', 'ppm_enqueue_scripts');

function ppm_add_admin_menu() {
    add_menu_page(
        'مدیریت قیمت پیشرفته',
        'قیمت گذاری',
        'manage_options',
        'product-price-manager',
        'ppm_render_admin_page',
        'dashicons-tag',
        6
    );
}
add_action('admin_menu', 'ppm_add_admin_menu');