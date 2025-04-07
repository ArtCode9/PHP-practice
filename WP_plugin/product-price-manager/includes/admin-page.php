<?php
function ppm_render_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'posts';
    
    // پارامترهای صفحه‌بندی و فیلتر
    $current_page = max(1, intval($_GET['paged'] ?? 1));
    $per_page_options = [10, 25, 50, 100];
    $per_page = in_array($_GET['per_page'] ?? 10, $per_page_options) ? intval($_GET['per_page']) : 10;
    $offset = ($current_page - 1) * $per_page;

    // دریافت پارامترهای فیلتر
    $search_term = sanitize_text_field($_GET['search'] ?? '');
    $category_id = intval($_GET['category_filter'] ?? 0);

    // ساخت کوئری پایه
    $query = "SELECT * FROM $table_name 
        WHERE post_type = 'product' 
        AND post_status = 'publish'";

    // اعمال فیلترها
    if (!empty($search_term)) {
        $query .= $wpdb->prepare(" AND post_title LIKE %s", '%' . $wpdb->esc_like($search_term) . '%');
    }
    
    if ($category_id > 0) {
        $query .= $wpdb->prepare(" AND ID IN (
            SELECT object_id FROM {$wpdb->term_relationships} 
            WHERE term_taxonomy_id = %d
        )", $category_id);
    }

    // محاسبه کل آیتم‌ها
    $total_items = $wpdb->get_var("SELECT COUNT(1) FROM ($query) AS total");
    $total_pages = ceil($total_items / $per_page);

    // دریافت محصولات
    $products = $wpdb->get_results($query . $wpdb->prepare(" LIMIT %d OFFSET %d", $per_page, $offset));

    // دریافت دسته‌بندی‌ها
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ]);

    ?>
    <div class="wrap ppm-wrapper">
        <h1 class="wp-heading-inline">مدیریت پیشرفته قیمت‌ها</h1>
        
        <!-- نوار ابزار مدیریت -->
        <div class="ppm-toolbar">
            <form method="get" class="ppm-filters">
                <input type="hidden" name="page" value="product-price-manager">
                
                <!-- بخش جستجو -->
                <div class="ppm-search-section">
                    <input type="text" name="search" placeholder="جستجوی محصول..." 
                        value="<?= esc_attr($search_term) ?>">
                    <button type="submit" class="button button-primary">
                        <span class="dashicons dashicons-search"></span>
                        جستجو
                    </button>
                </div>

                <div class="ppm-filter-group">
                    <select name="category_filter">
                        <option value="0">همه محصولات</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->term_id ?>" <?= selected($category_id, $cat->term_id) ?>>
                                <?= esc_html($cat->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="per_page" class="ppm-per-page">
                        <?php foreach ($per_page_options as $option): ?>
                            <option value="<?= $option ?>" <?= selected($per_page, $option) ?>>
                                نمایش <?= $option ?> مورد
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" class="button button-primary">اعمال فیلترها</button>
                    <a href="<?= admin_url('admin.php?page=product-price-manager') ?>" 
                        class="button">پاکسازی فیلترها</a>
                </div>
            </form>
        </div>

        <!-- جدول محصولات -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column">
                        <input type="checkbox" id="ppm-select-all">
                    </th>
                    <th>نام محصول</th>
                    <th width="100">شناسه</th>
                    <th width="150">قیمت اصلی</th>
                    <th width="150">قیمت ویژه</th>
                    <th width="120">نوع محصول</th>
                    <th width="150">عملیات</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($products as $product): 
                    $product_id = $product->ID;
                    $product_type = get_post_meta($product_id, '_product_type', true);
                    $is_variable = $product_type === 'variable';
                    $parent_id = wp_get_post_parent_id($product_id);

                    // دریافت قیمت‌ها
                    $regular_price = get_post_meta($product_id, '_regular_price', true);
                    $sale_price = get_post_meta($product_id, '_sale_price', true);

                    // اگر محصول متغیر است، Variation‌ها را دریافت کنید
                    if ($is_variable) {
                        $variations = wc_get_products([
                            'type' => 'variation',
                            'parent' => $product_id,
                            'limit' => -1,
                        ]);

                        $regular_price = [];
                        $sale_price = [];
                        foreach ($variations as $variation) {
                            $regular_price[] = $variation->get_regular_price();
                            $sale_price[] = $variation->get_sale_price();
                        }

                        // نمایش کمترین و بیشترین قیمت
                        $regular_price = !empty($regular_price) ? min($regular_price) . ' - ' . max($regular_price) : 'N/A';
                        $sale_price = !empty($sale_price) ? min($sale_price) . ' - ' . max($sale_price) : 'N/A';
                    }
                ?>
                    <tr>
                        <td><input type="checkbox" class="ppm-product-check" value="<?= $product_id ?>"></td>
                        <td>
                            <?php if ($is_variable): ?>
                                <span class="ppm-variable-indicator">★</span>
                            <?php endif; ?>
                            <?= esc_html($product->post_title) ?>
                        </td>
                        <td><?= $product_id ?></td>
                        <td>
                            <input type="text" class="ppm-regular-price" 
                                value="<?= esc_attr($regular_price) ?>"
                                style="width: 100px;">
                        </td>
                        <td>
                            <input type="text" class="ppm-sale-price" 
                                value="<?= esc_attr($sale_price) ?>"
                                style="width: 100px;">
                        </td>
                        <td><?= $is_variable ? 'متغیر' : 'ساده' ?></td>
                        <td>
                            <button class="button ppm-save-single" data-id="<?= $product_id ?>">
                                ذخیره
                            </button>
                            <button class="button ppm-delete-single" 
                                data-id="<?= $product_id ?>" 
                                title="انتقال به زباله‌دان">
                                حذف
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- دکمه‌های عملیات دسته‌ای -->
        <div class="ppm-bulk-actions">
            <button type="button" class="button button-primary ppm-bulk-update">
                <span class="dashicons dashicons-update"></span>
                به‌روزرسانی دسته‌ای
            </button>
            
            <button type="button" class="button button-danger ppm-bulk-delete">
                <span class="dashicons dashicons-trash"></span>
                حذف دسته‌ای
            </button>
        </div>

        <!-- صفحه‌بندی -->
        <div class="ppm-pagination">
            <?= paginate_links([
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => '« قبلی',
                'next_text' => 'بعدی »',
                'total' => $total_pages,
                'current' => $current_page,
            ]) ?>
        </div>
    </div>
    <?php
}