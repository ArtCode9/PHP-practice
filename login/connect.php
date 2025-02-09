<?php

   $host = "localhost";
   $user = "artcode";
   $pass = "1";
   $dbname = "artdb";

   $conn = new mysqli($host, $user, $pass, $dbname);

   if($conn->connect_error){
      echo"Failed to Connect DB::" . $conn->connect_error;
   }else{
      echo"connection DONE";
   }

?>