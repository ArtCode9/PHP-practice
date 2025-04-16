<?php
class WP_Master_Plugin_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wp_master_plugin_widget',
            __('WP Master Widget', 'wp-master-plugin'),
            array('description' => __('A custom widget for WP Master Plugin', 'wp-master-plugin'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $text = !empty($instance['text']) ? $instance['text'] : __('Default widget text', 'wp-master-plugin');
        echo '<div class="textwidget">' . wpautop(esc_html($text)) . '</div>';
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $text = !empty($instance['text']) ? $instance['text'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_attr_e('Title:', 'wp-master-plugin'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                <?php esc_attr_e('Content:', 'wp-master-plugin'); ?>
            </label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('text')); ?>"
                      rows="5"><?php echo esc_textarea($text); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['text'] = (!empty($new_instance['text'])) ? sanitize_textarea_field($new_instance['text']) : '';
        return $instance;
    }
}