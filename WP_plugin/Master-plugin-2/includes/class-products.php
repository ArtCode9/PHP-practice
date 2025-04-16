<?php
class WP_Master_Plugin_Products {

    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_product_meta'));
        add_filter('manage_product_posts_columns', array($this, 'add_price_column'));
        add_action('manage_product_posts_custom_column', array($this, 'show_price_column'), 10, 2);
    }

    public function register_post_type() {
        $labels = array(
            'name' => __('Products', 'wp-master-plugin'),
            'singular_name' => __('Product', 'wp-master-plugin'),
            'add_new' => __('Add New', 'wp-master-plugin'),
            'add_new_item' => __('Add New Product', 'wp-master-plugin'),
            'edit_item' => __('Edit Product', 'wp-master-plugin'),
            'featured_image' => __('Product Image', 'wp-master-plugin')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'rewrite' => array('slug' => 'products'),
            'menu_icon' => 'dashicons-cart',
            'show_in_rest' => true
        );

        register_post_type('product', $args);

        // دسته‌بندی محصولات
        register_taxonomy(
            'product_category',
            'product',
            array(
                'label' => __('Categories', 'wp-master-plugin'),
                'hierarchical' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug' => 'product-category')
            )
        );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'wp_master_product_meta',
            __('Product Details', 'wp-master-plugin'),
            array($this, 'render_meta_box'),
            'product',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('wp_master_save_product_data', 'wp_master_product_nonce');

        $price = get_post_meta($post->ID, '_product_price', true);
        $sku = get_post_meta($post->ID, '_product_sku', true);
        $stock = get_post_meta($post->ID, '_product_stock', true);
        ?>
        <div class="wp-master-product-fields">
            <div class="field-group">
                <label for="product_price"><?php _e('Price', 'wp-master-plugin'); ?></label>
                <input type="number" step="0.01" id="product_price" 
                       name="product_price" value="<?php echo esc_attr($price); ?>">
            </div>
            
            <div class="field-group">
                <label for="product_sku"><?php _e('SKU', 'wp-master-plugin'); ?></label>
                <input type="text" id="product_sku" 
                       name="product_sku" value="<?php echo esc_attr($sku); ?>">
            </div>
            
            <div class="field-group">
                <label for="product_stock"><?php _e('Stock Quantity', 'wp-master-plugin'); ?></label>
                <input type="number" id="product_stock" 
                       name="product_stock" value="<?php echo esc_attr($stock); ?>">
            </div>
        </div>
        <?php
    }

    public function save_product_meta($post_id) {
        if (!isset($_POST['wp_master_product_nonce']) || 
            !wp_verify_nonce($_POST['wp_master_product_nonce'], 'wp_master_save_product_data')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // ذخیره فیلدهای قیمت، SKU و موجودی
        $fields = array('price', 'sku', 'stock');
        foreach ($fields as $field) {
            if (isset($_POST['product_' . $field])) {
                update_post_meta(
                    $post_id,
                    '_product_' . $field,
                    sanitize_text_field($_POST['product_' . $field])
                );
            }
        }
    }

    public function add_price_column($columns) {
        $new_columns = array();
        
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            
            if ($key === 'title') {
                $new_columns['price'] = __('Price', 'wp-master-plugin');
                $new_columns['stock'] = __('Stock', 'wp-master-plugin');
            }
        }
        
        return $new_columns;
    }

    public function show_price_column($column, $post_id) {
        switch ($column) {
            case 'price':
                $price = get_post_meta($post_id, '_product_price', true);
                echo $price ? number_format($price, 2) . ' ' . get_woocommerce_currency_symbol() : '—';
                break;
                
            case 'stock':
                $stock = get_post_meta($post_id, '_product_stock', true);
                echo $stock !== '' ? intval($stock) : '—';
                break;
        }
    }
}