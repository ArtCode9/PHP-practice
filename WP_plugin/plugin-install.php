<?php
/*
   Plugin Name: Install & Uninstall
   Plugin URI: https://example.com
   Description: with this we learn about install and uninstall plugin 
   Author: ArtCode9
   Author URI: www.artcode9.com
   Text Domain: pi
   Domain Path: /languages/
   Version: 1.0.0
*/

// warning before uninstall this plugin make copy of it to prevent deleting


// this is how we create custom table in db😎

function pi_install_default_configs()
{
      // we want check if there is any config already
      $current_configs = get_option('pi_configs');
      if(!$current_configs) {

            $default_configs = [
               'amount' => 50000,
               'role' => 'administrator'
            ];
            update_option('pi_configs', $default_configs);
      }
}

function pi_install_db() 
{
      global $wpdb;
      $customers_table_name = $wpdb->prefix . 'customers';
      $collate = $wpdb->get_charset_collate();

      $customers_table_sql = "
            CREATE TABLE IF NOT EXISTS `{$customers_table_name}` (
            `ID` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `wallet` int(11) NOT NULL,
            `total_orders` int(11) NOT NULL
            ) {$collate};
      ";

      // how we run code now look at this 👇
      require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
      dbDelta($customers_table_sql);
}

function pi_uninstall()
{
      global $wpdb;
      $customers_table_name = $wpdb->prefix . 'customers';
      $wpdb->query("DROP TABLE IF EXISTS {$customers_table_name}");
      delete_option('pi_configs');
}

function pi_activate()
{
   pi_install_default_configs();
   pi_install_db();

   
   // here we uninstall plugin and delete config and tables
   register_uninstall_hook(__FILE__, 'pi_uninstall');

}

register_activation_hook(__FILE__, 'pi_activate');