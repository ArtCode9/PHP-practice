<?php
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
//  retrive data from database
      $sql = "SELECT * FROM axeart";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc(($result))){
                  echo $row["id"] . "<br>";
                  echo $row["email"]. "<br>";
            }
      }else{
         echo"No user found";
      }

?>