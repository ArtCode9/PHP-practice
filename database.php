<?php

      $db_server = "localhost";
      $db_user = "root";
      $db_pass = "mypass";
      $db_name = "demodb";
      $conn = "";

      // try{
      // $conn = mysqli_connect($db_server,
      //                        $db_user, 
      //                        $db_pass, 
      //                        $db_name);
      //    }
      //    catch(mysqli_sql_exception){
      //       echo"Could not connect!!";
      //    }

      $username = "root";
      $password = "mypass";


      try{
         // mysqli_query($conn, $sql);
         $pdo = new PDO("mysql:host=localhost;dbname=demodb", $username, $password);
         echo"User is now registered";
      }
      catch(PDOException $e){
            echo "Could not register user: " . $e->getMessage();
      }
      // if($conn){
      //    echo"You are connected!!";
      // }
?>