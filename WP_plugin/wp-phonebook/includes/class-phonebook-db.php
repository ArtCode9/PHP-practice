<?php
if (!defined('ABSPATH')) {
    exit;
}

class PhoneBook_DB {
    public function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'phonebook_contacts';
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            email varchar(100),
            address text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    public function get_contacts() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'phonebook_contacts';
        return $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");
    }
    
    public function add_contact($data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'phonebook_contacts';
        return $wpdb->insert($table_name, $data);
    }
    
    public function delete_contact($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'phonebook_contacts';
        return $wpdb->delete($table_name, array('id' => $id));
    }


    // this is new section add for update 
    public function get_contact($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'phonebook_contacts';
        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
        );
    }
    
    public function update_contact($id, $data){
            global $wpdb;
            $table_name = $wpdb->prefix . 'phonebook_contacts';

            return $wpdb->update(
                $table_name,
                $data,
                array('id' => $id),
                array('%s', '%s', '%s', '%s',),
                array('%d')
            );
    }
}