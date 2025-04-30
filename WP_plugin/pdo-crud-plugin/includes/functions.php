<?php
// Create a new contact
function pdo_crud_create_contact($data) {
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        
        $stmt = $pdo->prepare("INSERT INTO $table_name (name, nickname, phone) VALUES (:name, :nickname, :phone)");
        $stmt->execute([
            ':name' => sanitize_text_field($data['name']),
            ':nickname' => sanitize_text_field($data['nickname']),
            ':phone' => sanitize_text_field($data['phone'])
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log('PDO CRUD create error: ' . $e->getMessage());
        return false;
    }
}

// Read all contacts
function pdo_crud_get_contacts() {
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        
        $stmt = $pdo->query("SELECT * FROM $table_name ORDER BY id DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('PDO CRUD read error: ' . $e->getMessage());
        return [];
    }
}

// Read single contact by ID
function pdo_crud_get_contact($id) {
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        
        $stmt = $pdo->prepare("SELECT * FROM $table_name WHERE id = :id");
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log('PDO CRUD read single error: ' . $e->getMessage());
        return false;
    }
}

// Update contact
function pdo_crud_update_contact($id, $data) {
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        
        $stmt = $pdo->prepare("UPDATE $table_name SET name = :name, nickname = :nickname, phone = :phone WHERE id = :id");
        return $stmt->execute([
            ':name' => sanitize_text_field($data['name']),
            ':nickname' => sanitize_text_field($data['nickname']),
            ':phone' => sanitize_text_field($data['phone']),
            ':id' => (int)$id
        ]);
    } catch (PDOException $e) {
        error_log('PDO CRUD update error: ' . $e->getMessage());
        return false;
    }
}

// Delete contact
function pdo_crud_delete_contact($id) {
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        
        $stmt = $pdo->prepare("DELETE FROM $table_name WHERE id = :id");
        return $stmt->execute([':id' => (int)$id]);
    } catch (PDOException $e) {
        error_log('PDO CRUD delete error: ' . $e->getMessage());
        return false;
    }
}

// Add shortcode for frontend from
function pdo_crud_frontend_form_shortcode() {
    ob_start();
    // Add this at the beginning of your shortcode function if you want inline styles
echo '<style>
.pdo-crud-frontend-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f9f9f9;
    border: 1px solid #ddd;
}
.pdo-crud-frontend-form .form-group {
    margin-bottom: 15px;
}
.pdo-crud-frontend-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.pdo-crud-frontend-form input[type="text"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
.pdo-crud-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
.pdo-crud-table th, .pdo-crud-table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
}
.pdo-crud-table th {
    background-color: #f2f2f2;
}
.notice {
    padding: 10px;
    margin: 10px 0;
    border: 1px solid transparent;
}
.notice-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.notice-error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
</style>';

    // Handle form submissions
    if(isset($_POST['pdo_crud_frontend_action'])) {
        $action = $_POST['pdo_crud_frontend_action'];
        $data = [
            'name' => $_POST['name'] ?? '',
            'nickname' => $_POST['nickname'] ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];

        switch ($action) {
            case 'create' :
                if(pdo_crud_create_contact($data)){
                    echo '<div class="notice notice-success"><p>Contact created successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error creating contact.</p></div>';
                }
                break;
            case 'update':
                $id = (int)$_POST['id'];
                if(pdo_crud_update_contact($id, $data)) {
                    echo '<div class="notice notice-success"><p>Contact updated successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error updating contact</p></div>';
                }
                break;
        }
    }

    // check if  we are editing a contact
    $edit_id = isset($_GET['edit_contact']) ? (int)$_GET['edit_contact'] : 0;
    $contact = $edit_id ? pdo_crud_get_contact($edit_id) : null;

    ?>
    <div class="pdo-crud-frontend-form">
        <h2><?php echo $contact ? 'Edit Contact' : 'Add New Contact'; ?></h2>
        <form method="post" action="functions.php">
            <input type="hidden" name="pdo_crud_frontend_action" value="<?php echo $contact ? 'update' : 'create'; ?>">
            <?php wp_nonce_field('pdo_crud_frontend_nonce', 'pdo_crud_nonce'); ?>
            <?php if ($contact): ?>
                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?php echo esc_attr($contact['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($contact['nickname'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr($contact['phone'] ?? ''); ?>">
            </div>
            
            <button type="submit" class="button"><?php echo $contact ? 'Update Contact' : 'Add Contact'; ?></button>
            <?php if ($contact): ?>
                <a href="?" class="button">Cancel</a>
            <?php endif; ?>
        </form>
        
        <h2>Contact List</h2>
        <?php
        $contacts = pdo_crud_get_contacts();
        if (empty($contacts)): ?>
            <p>No contacts found.</p>
        <?php else: ?>
            <table class="pdo-crud-table">
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
                                <a href="?edit_contact=<?php echo $contact['id']; ?>" class="button">Edit</a>
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="pdo_crud_frontend_action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                    <?php wp_nonce_field('pdo_crud_frontend_nonce', 'pdo_crud_nonce'); ?>
                                    <button type="submit" class="button" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
    
    return ob_get_clean();
};

add_shortcode('pdo_crud_form', 'pdo_crud_frontend_form_shortcode');
