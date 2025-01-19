<?php
      
      include("database.php");

      $username = "root";
      $password = "mypass";
      $hash = password_hash($password, PASSWORD_DEFAULT);


      $sql = "INSERT INTO users (user, password)
              value('Spongebob', 'pineapple1')";

   try{
      // mysqli_query($conn, $sql);
      $pdo = new PDO("mysql:host=localhost;dbname=demodb", $username, $password);
      echo"User is now registered";
   }
   catch(PDOException $e){
         echo "Could not register user: " . $e->getMessage();
   }
//    mysqli_close($conn);
?>
 