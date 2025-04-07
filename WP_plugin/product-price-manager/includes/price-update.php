<?php
// به‌روزرسانی تک محصول
add_action('wp_ajax_ppm_save_single', function() {
    check_ajax_referer('ppm_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $regular = sanitize_text_field($_POST['regular']);
    $sale = sanitize_text_field($_POST['sale']);

    // بررسی نوع محصول
    $product_type = get_post_meta($product_id, '_product_type', true);

    if ($product_type === 'variable') {
        // اگر محصول متغیر است، قیمت‌ها را برای همه Variation‌ها اعمال کنید
        $variations = wc_get_products([
            'type' => 'variation',
            'parent' => $product_id,
            'limit' => -1,
        ]);

        foreach ($variations as $variation) {
            update_post_meta($variation->get_id(), '_regular_price', $regular);
            update_post_meta($variation->get_id(), '_sale_price', $sale);
        }
    } else {
        // اگر محصول ساده است، قیمت‌ها را مستقیماً اعمال کنید
        update_post_meta($product_id, '_regular_price', $regular);
        update_post_meta($product_id, '_sale_price', $sale);
    }
    
    wp_send_json_success(['message' => 'تغییرات با موفقیت ذخیره شد']);
});

// به‌روزرسانی دسته‌ای
add_action('wp_ajax_ppm_bulk_update', function() {
    check_ajax_referer('ppm_nonce', 'nonce');
    
    foreach ($_POST['prices'] as $item) {
        $product_id = intval($item['product_id']);
        $regular = sanitize_text_field($item['regular']);
        $sale = sanitize_text_field($item['sale']);

        // بررسی نوع محصول
        $product_type = get_post_meta($product_id, '_product_type', true);

        if ($product_type === 'variable') {
            // اگر محصول متغیر است، قیمت‌ها را برای همه Variation‌ها اعمال کنید
            $variations = wc_get_products([
                'type' => 'variation',
                'parent' => $product_id,
                'limit' => -1,
            ]);

            foreach ($variations as $variation) {
                update_post_meta($variation->get_id(), '_regular_price', $regular);
                update_post_meta($variation->get_id(), '_sale_price', $sale);
            }
        } else {
            // اگر محصول ساده است، قیمت‌ها را مستقیماً اعمال کنید
            update_post_meta($product_id, '_regular_price', $regular);
            update_post_meta($product_id, '_sale_price', $sale);
        }
    }
    
    wp_send_json_success(['message' => 'به‌روزرسانی دسته‌ای انجام شد']);
});

// حذف دسته‌ای
add_action('wp_ajax_ppm_bulk_delete', function() {
    check_ajax_referer('ppm_nonce', 'nonce');
    
    foreach ($_POST['product_ids'] as $product_id) {
        wp_trash_post(intval($product_id));
    }
    
    wp_send_json_success(['message' => 'محصولات انتخاب شده حذف شدند']);
});