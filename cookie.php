<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cookie</title>
</head>
<body>
  <?php

    // setcookie(name, value, expire, path, domain, secure, httponly);

         $cookieName = "user";
         $cookieValue = "ArtCode";

         setcookie($cookieName, $cookieValue, time() + 86400, "/");
   ?>
   <?php
      if(!isset($_COOKIE[$cookieName])){
            echo"cookie name  " . $cookieName . " is not set";
      }else{
         echo"cookie "  . $cookieName . " is set";
      };
      echo"<hr>";
      if(count($_COOKIE) > 0){
         echo"cookie already exist";
      }else{
         echo"there is no cookie";
      }
   ?>

</body>
</html>