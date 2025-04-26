<?php

function display_ticket_list($tickets) {
    echo '<h2>تیکت‌های مربوطه</h2>';
    // شروع جدول
    echo '<table class="widefat striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>شماره پیگیری</th>';
    echo '<th>نام</th>';
    echo '<th>ایمیل</th>';
    echo '<th>موضوع</th>';
    echo '<th>الویت</th>';
    echo '<th>وضعیت</th>';
    echo '<th>تاریخ</th>';
    echo '<th>پیام</th>';
    echo '<th>پشتیبان</th>';
    echo '<th>عملیات</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($tickets) {
        foreach ($tickets as $ticket) {
            echo '<tr>';
            echo '<td>' . esc_html($ticket->id) . '</td>';
            echo '<td>' . esc_html($ticket->tracking_code) . '</td>';
            echo '<td>' . esc_html($ticket->full_name) . '</td>';
            echo '<td>' . esc_html($ticket->email) . '</td>';
            echo '<td>' . esc_html($ticket->subject) . '</td>';
            echo '<td>' . esc_html($ticket->priority) . '</td>';
            echo '<td>' . esc_html($ticket->status) . '</td>';
            echo '<td>' . esc_html($ticket->created_at) . '</td>';
            echo '<td>' . esc_html($ticket->message) . '</td>';
            echo '<td>' . esc_html($ticket->support_agent) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="10" style="text-align: center;">تیکتی موجود نیست.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
