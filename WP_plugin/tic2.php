<?php 

/* 
Plugin Name: My ticket2 
Plugin URI:  https://example.com
Description: This is my ticket handling with deepSeek.
Author: art code
Author URI: https://example.com
Text Domain: ticket by deepSeek
Domain Path: /languages/
Version: 1.0.0
*/

function create_table_ticket (){
      global $wpDB;
      $table_name = $wpDB->prefix . 'Batman_support';
      
      // here we want retrieves Data from database character collate(collect and combine)
      $charset_collate = $wpDB->get_charset_collate();

      // check table if already exist
      if($wpDB->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

         $sql = "CREATE TABLE $table_name (
               id INT AUTO_INCREMENT PRIMARY KEY,
               title VARCHAR(255) NOT NULL,
               description TEXT NOT NULL,
               status ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
               updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
         ) $charset_collate;";

      }
};

?>
   <h1> Sending form ticket</h1>
   <form action="tic2.php" method="post">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" required><br><br>

      <label for="description">Description</label><br>
      <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

      <input type="submit" value="Send Ticket">
   </form>
<?php



?>