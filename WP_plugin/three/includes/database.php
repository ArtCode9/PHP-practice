<?php 

 $host = 'localhost';
 $username = 'root';
 $password = '';
 $dbname = 'demo';



try {
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $username , $password);

      // set pdo error mode to exception
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // set default fetch mode to associative array
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

      // SQL to create table
      $sql = "CREATE TABLE IF NOT EXISTS axe (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            family VARCHAR(50) NOT NULL,
            phone VARCHAR(14) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";

      $pdo->exec($sql);


      echo "Connected Successfully;";

} catch(PDOException $e) {

      die('Connection failed: ' . $e->getMessage());
}
