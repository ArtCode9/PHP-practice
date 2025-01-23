<?php

      // include("database.php");
      // global $conn;   
      // $sql2 = "INSERT INTO users (user, password)
      //           VALUES ('batman3', 'batman3')";

      
      // mysqli_query($conn, $sql2);

      // $sql2 = "INSERT INTO axeart (email)
      //           VALUES ('phplover@gmail.com')";

      // $import = "INSERT INTO users (user, password)
      //             VALUES('Artcode567', '444w123w')";

      // mysqli_query($conn, $import);

      // mysqli_close($conn);

      $db_server = "localhost";
      $db_user = "artcode";
      $db_pass = "1";
      $db_name = "artdb";
      $conn = "";
      try{
         $conn = mysqli_connect($db_server, 
                                $db_user, 
                                $db_pass,
                                $db_name);
      }catch(mysqli_sql_exception){
            echo"Could not connect <br>";
      }
// insert data to database
      $sqlinput = "INSERT INTO input (number, nickname)
                        VALUE('10', 'coffrt')";
      mysqli_query($conn, $sqlinput);

      mysqli_close($conn);
      echo"Hello";
?>
