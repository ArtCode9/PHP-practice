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