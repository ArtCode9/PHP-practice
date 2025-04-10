<div class="consultation-bookings-list">
    <h2><?php _e('لیست نوبت‌های مشاوره', 'consultation-booking'); ?></h2>
    
    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'consultation_bookings';
    $bookings = $wpdb->get_results("SELECT * FROM $table_name ORDER BY booking_date DESC, booking_time DESC");
    
    if ($bookings) :
    ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('نام', 'consultation-booking'); ?></th>
                    <th><?php _e('ایمیل', 'consultation-booking'); ?></th>
                    <th><?php _e('تلفن', 'consultation-booking'); ?></th>
                    <th><?php _e('مشاور', 'consultation-booking'); ?></th>
                    <th><?php _e('تاریخ', 'consultation-booking'); ?></th>
                    <th><?php _e('ساعت', 'consultation-booking'); ?></th>
                    <th><?php _e('وضعیت', 'consultation-booking'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td><?php echo esc_html($booking->name); ?></td>
                        <td><?php echo esc_html($booking->email); ?></td>
                        <td><?php echo esc_html($booking->phone); ?></td>
                        <td><?php echo sprintf(__('مشاور %d', 'consultation-booking'), $booking->consultant_id); ?></td>
                        <td><?php echo esc_html($booking->booking_date); ?></td>
                        <td><?php echo esc_html($booking->booking_time); ?></td>
                        <td><?php echo esc_html($booking->status); ?></td>
                        <td>
                            <form method="post" class="delete-booking-form">
                                <input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
                                <?php wp_nonce_field('delete_booking_' . $booking->id); ?>
                                <button type="submit" class="button button-delete" onclick="return confirm('Are you sure to delete it?')">
                                    <?php _e('delete','consultation-booking')?>                    
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p><?php _e('هیچ نوبتی ثبت نشده است.', 'consultation-booking'); ?></p>
    <?php endif; ?>
</div>