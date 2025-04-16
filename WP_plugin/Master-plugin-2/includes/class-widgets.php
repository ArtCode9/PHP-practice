<?php
class WP_Master_Plugin_Widgets {

    public function __construct() {
        add_action('widgets_init', array($this, 'register_widgets'));
    }

    public function register_widgets() {
        register_widget('WP_Master_Products_Widget');
        register_widget('WP_Master_Contact_Info_Widget');
    }
}

class WP_Master_Products_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wp_master_products',
            __('Latest Products', 'wp-master-plugin'),
            array(
                'description' => __('Display latest products', 'wp-master-plugin'),
                'classname' => 'wp-master-products-widget'
            )
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = apply_filters('widget_title', $instance['title']);
        $count = !empty($instance['count']) ? absint($instance['count']) : 3;
        
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $products = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => $count,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if ($products->have_posts()) {
            echo '<ul class="wp-master-product-list">';
            
            while ($products->have_posts()) {
                $products->the_post();
                $price = get_post_meta(get_the_ID(), '_product_price', true);
                
                echo '<li class="product-item">';
                echo '<a href="' . get_permalink() . '">';
                
                if (has_post_thumbnail()) {
                    echo '<div class="product-thumbnail">';
                    the_post_thumbnail('thumbnail');
                    echo '</div>';
                }
                
                echo '<div class="product-info">';
                echo '<h4 class="product-title">' . get_the_title() . '</h4>';
                
                if ($price) {
                    echo '<span class="product-price">' . 
                         number_format($price, 2) . ' ' . get_woocommerce_currency_symbol() . 
                         '</span>';
                }
                
                echo '</div>';
                echo '</a>';
                echo '</li>';
            }
            
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No products found', 'wp-master-plugin') . '</p>';
        }
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:', 'wp-master-plugin'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>">
                <?php _e('Number of products to show:', 'wp-master-plugin'); ?>
            </label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>"
                   type="number" step="1" min="1" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['count'] = absint($new_instance['count']);
        return $instance;
    }
}

class WP_Master_Contact_Info_Widget extends WP_Widget {
    
    // مشابه ویجت محصولات، برای نمایش اطلاعات تماس
    // ...
}