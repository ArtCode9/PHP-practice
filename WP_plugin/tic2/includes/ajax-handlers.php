<?php
// AJAX handler to mark ticket as viewed
function mark_ticket_viewed_callback() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized');
    }

    if (!isset($_POST['ticket_id'])) {
        wp_send_json_error('Missing ticket ID');
    }

    $ticket_id = intval($_POST['ticket_id']);
    global $wpdb;
    $table_name = $wpdb->prefix . '_support_tickets';

    $updated = $wpdb->update(
        $table_name,
        array('viewed' => 1),
        array('id' => $ticket_id),
        array('%d'),
        array('%d')
    );

    if ($updated !== false) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Failed to update ticket');
    }
}

// AJAX handler to get count of new, unviewed tickets
function get_new_tickets_count_callback() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . '_support_tickets';

    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'new' AND viewed = 0");

    wp_send_json_success(array('count' => intval($count)));
}
