<?php
function scf_render_contacts_list() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_contact_form';
    
    // دریافت پارامترهای جستجو و فیلتر
    $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $filter_date_from = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
    $filter_date_to = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';
    
    // ساخت کوئری پایه
    $query = "SELECT * FROM $table_name";
    $where = array();
    $query_params = array();
    
    // اضافه کردن شرایط جستجو
    if (!empty($search)) {
        $where[] = "(name LIKE %s OR email LIKE %s OR phone LIKE %s)";
        $search_term = '%' . $wpdb->esc_like($search) . '%';
        $query_params = array_merge($query_params, array($search_term, $search_term, $search_term));
    }
    
    // اضافه کردن فیلتر تاریخ
    if (!empty($filter_date_from)) {
        $where[] = "created_at >= %s";
        $query_params[] = $filter_date_from;
    }
    
    if (!empty($filter_date_to)) {
        $where[] = "created_at <= %s";
        $query_params[] = $filter_date_to . ' 23:59:59';
    }
    
    // ترکیب شرایط
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    $query .= " ORDER BY created_at DESC";
    
    // اجرای کوئری
    if (!empty($query_params)) {
        $contacts = $wpdb->get_results($wpdb->prepare($query, $query_params));
    } else {
        $contacts = $wpdb->get_results($query);
    }
    
    // نمایش فرم جستجو و فیلتر
    ?>
    <div class="scf-list-header">
        <a href="<?php echo admin_url('admin.php?page=simple-contact-form&view=add-new'); ?>" class="page-title-action">افزودن جدید</a>
        
        <form method="get" action="<?php echo admin_url('admin.php'); ?>" class="search-form" style="display: inline-block; float: right; margin-left: 10px;">
            <input type="hidden" name="page" value="simple-contact-form">
            <div class="scf-filters" style="display: flex; align-items: center;">
                <input type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder="جستجو..." class="scf-search-input">
                
                <div class="scf-date-filters" style="margin-left: 10px;">
                    <label for="date_from">از تاریخ:</label>
                    <input type="date" name="date_from" id="date_from" value="<?php echo esc_attr($filter_date_from); ?>" style="margin-right: 5px;">
                    
                    <label for="date_to">تا تاریخ:</label>
                    <input type="date" name="date_to" id="date_to" value="<?php echo esc_attr($filter_date_to); ?>" style="margin-right: 5px;">
                </div>
                
                <button type="submit" class="button" style="margin-right: 5px;">فیلتر</button>
                <a href="<?php echo admin_url('admin.php?page=simple-contact-form'); ?>" class="button">پاک کردن فیلترها</a>
            </div>
        </form>
    </div>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th width="5%">شناسه</th>
                <th width="25%">نام</th>
                <th width="25%">ایمیل</th>
                <th width="20%">تلفن</th>
                <th width="15%">تاریخ ایجاد</th>
                <th width="10%">عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($contacts)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">
                        <?php echo empty($search) && empty($filter_date_from) && empty($filter_date_to) ? 
                            'هیچ تماسی یافت نشد' : 
                            'نتیجه‌ای برای جستجوی شما یافت نشد'; ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?php echo esc_html($contact->id); ?></td>
                        <td><?php echo esc_html($contact->name); ?></td>
                        <td><?php echo esc_html($contact->email); ?></td>
                        <td><?php echo esc_html($contact->phone); ?></td>
                        <td><?php echo esc_html($contact->created_at); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=simple-contact-form&action=edit&id=' . $contact->id); ?>" class="button">ویرایش</a>
                            <a href="<?php echo admin_url('admin.php?page=simple-contact-form&action=delete&id=' . $contact->id); ?>" class="button button-link-delete" onclick="return confirm('آیا از حذف این تماس مطمئن هستید؟')">حذف</a>
                            <a href="<?php echo admin_url('admin.php?page=simple-contact-form&action=print&id=' . $contact->id); ?>" class="button">پرینت</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
}