<?php
// Create admin menu
function pdo_crud_admin_menu() {
    add_menu_page(
        'PDO CRUD Contacts',
        'PDO CRUD Contacts',
        'manage_options',
        'pdo-crud-contacts',
        'pdo_crud_admin_page',
        'dashicons-admin-users',
        20
    );
}

// Admin page content
function pdo_crud_admin_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        check_admin_referer('pdo_crud_nonce');
        
        $action = $_POST['action'];
        $data = [
            'name' => $_POST['name'] ?? '',
            'nickname' => $_POST['nickname'] ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];
        
        switch ($action) {
            case 'create':
                if (pdo_crud_create_contact($data)) {
                    echo '<div class="notice notice-success"><p>Contact created successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error creating contact.</p></div>';
                }
                break;
                
            case 'update':
                $id = (int)$_POST['id'];
                if (pdo_crud_update_contact($id, $data)) {
                    echo '<div class="notice notice-success"><p>Contact updated successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error updating contact.</p></div>';
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if (pdo_crud_delete_contact($id)) {
                    echo '<div class="notice notice-success"><p>Contact deleted successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error deleting contact.</p></div>';
                }
                break;
        }
    }
    
    // Check if we're editing a contact
    $edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
    $contact = $edit_id ? pdo_crud_get_contact($edit_id) : null;
    
    // Get all contacts
    $contacts = pdo_crud_get_contacts();
    ?>
    <div class="wrap">
        <h1>PDO CRUD Contacts</h1>
        
        <h2><?php echo $contact ? 'Edit Contact' : 'Add New Contact'; ?></h2>
        <form method="post" action="">
            <?php wp_nonce_field('pdo_crud_nonce'); ?>
            <input type="hidden" name="action" value="<?php echo $contact ? 'update' : 'create'; ?>">
            <?php if ($contact): ?>
                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
            <?php endif; ?>
            
            <table class="form-table">
                <tr>
                    <th><label for="name">Name</label></th>
                    <td>
                        <input type="text" name="name" id="name" value="<?php echo esc_attr($contact['name'] ?? ''); ?>" required>
                    </td>
                </tr>
                <tr>
                    <th><label for="nickname">Nickname</label></th>
                    <td>
                        <input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($contact['nickname'] ?? ''); ?>">
                    </td>
                </tr>
                <tr>
                    <th><label for="phone">Phone</label></th>
                    <td>
                        <input type="text" name="phone" id="phone" value="<?php echo esc_attr($contact['phone'] ?? ''); ?>">
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <button type="submit" class="button button-primary"><?php echo $contact ? 'Update Contact' : 'Add Contact'; ?></button>
                <?php if ($contact): ?>
                    <a href="<?php echo admin_url('admin.php?page=pdo-crud-contacts'); ?>" class="button">Cancel</a>
                <?php endif; ?>
            </p>
        </form>
        
        <h2>Contact List</h2>
        <?php if (empty($contacts)): ?>
            <p>No contacts found.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Nickname</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo $contact['id']; ?></td>
                            <td><?php echo esc_html($contact['name']); ?></td>
                            <td><?php echo esc_html($contact['nickname']); ?></td>
                            <td><?php echo esc_html($contact['phone']); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=pdo-crud-contacts&edit=' . $contact['id']); ?>" class="button">Edit</a>
                                <form method="post" action="" style="display: inline;">
                                    <?php wp_nonce_field('pdo_crud_nonce'); ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                    <button type="submit" class="button button-link-delete" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

