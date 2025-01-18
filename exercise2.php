<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Useful Tips</title>
</head>
<body>
   
</body>
</html>
<?php
      $username = "Art code";
      $username2 = "Art the Code";
      $username3 = array("Art", "The", "code");
      $phone = "123-456-7890";

      // $username = strtolower($username);
      // $username = strtoupper($username);
      // $username = trim($username);
      // $username = str_pad($username, 20, "0");
      // $username = strrev($username);
      // $phone = str_replace("-", "/", $phone);
      // $username = str_shuffle($username);
      // $username = strcmp($username, "Art code");
      // $count = strlen($username);
      // $index = strpos($phone, "-");
      // $first_name = substr($username, 0, 3);
      // $last_name = substr($username, 4);

      // echo $last_name;
//////////////////////////////////////////////
      $fullname = explode(" ", $username2);

      foreach($fullname as $name){
         echo $name . "<br>";
      };
///////////////////////////////////////////////
      $imusername = implode("--", $username3);

      echo $imusername;
?>