<?php
// Create or update the database table on activation
function pdo_crud_activate() {
    try {
        $pdo = pdo_crud_get_pdo();
        
        $table_name = PDO_CRUD_TABLE;
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            nickname VARCHAR(50),
            phone VARCHAR(20),
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $pdo->exec($sql);
    } catch (PDOException $e) {
        wp_die('Database error: ' . $e->getMessage());
    }
}

// Clean up on deactivation (optional)
function pdo_crud_deactivate() {
    // You might want to keep the table for future use
    // To actually delete the table, uncomment the following:
    /*
    try {
        $pdo = pdo_crud_get_pdo();
        $table_name = PDO_CRUD_TABLE;
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $pdo->exec($sql);
    } catch (PDOException $e) {
        error_log('PDO CRUD Plugin deactivation error: ' . $e->getMessage());
    }
    */
}

// Get PDO connection
function pdo_crud_get_pdo() {
    static $pdo = null;
    
    if ($pdo === null) {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_user = DB_USER;
        $db_password = DB_PASSWORD;
        
        try {
            $pdo = new PDO(
                "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
                $db_user,
                $db_password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            wp_die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    return $pdo;
}