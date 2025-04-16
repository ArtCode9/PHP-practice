<?php
class WP_Master_Plugin_API {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        register_rest_route('wp-master-plugin/v1', '/data', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_data'),
            'permission_callback' => array($this, 'check_permission')
        ));

        register_rest_route('wp-master-plugin/v1', '/data', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_data'),
            'permission_callback' => array($this, 'check_permission')
        ));
    }

    public function get_data(WP_REST_Request $request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp_master_plugin_data';
        
        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
        
        return new WP_REST_Response($results, 200);
    }

    public function create_data(WP_REST_Request $request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp_master_plugin_data';
        
        $parameters = $request->get_params();
        
        $title = sanitize_text_field($parameters['title']);
        $content = sanitize_textarea_field($parameters['content']);
        
        $result = $wpdb->insert($table_name, array(
            'title' => $title,
            'content' => $content,
            'created_at' => current_time('mysql')
        ));
        
        if ($result === false) {
            return new WP_Error('db_error', __('Could not insert data', 'wp-master-plugin'), array('status' => 500));
        }
        
        return new WP_REST_Response(array(
            'message' => __('Data created successfully', 'wp-master-plugin'),
            'id' => $wpdb->insert_id
        ), 201);
    }

    public function check_permission() {
        return current_user_can('edit_posts');
    }
}