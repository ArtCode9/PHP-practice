<?php
// file belong to this section ===> home.php

      session_start();

      if(isset($_POST["login"])){
      
         if(!empty($_POST["username"]) && !empty($_POST["password"])){
               
               $_SESSION["username"]  = $_POST["username"];
               $_SESSION["password"]  = $_POST["password"];

               // header error if come after html === Warning: Cannot modify header information - 
               //                 headers already sent by 
               //                 (output started at C:\Users\ART\Desktop\PHP-practice\20_session.php:7)
               //                 in C:\Users\ART\Desktop\PHP-practice\20_session.php on line 36

               // this function redircet us to home page
               header("Location: home.php");
      
               // here check the input
               // echo $_SESSION["username"] . "<br>";
               // echo $_SESSION["password"] . "<br>";
         }else{
            echo"Missing username/password!!";
         }
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Session</title>
</head>
<body>

      <form action="20_session.php" method="post">
            Username:<br>
            <input type="text" name="username"><br>
            Password:<br>
            <input type="password" name="password"><br>
            <input type="submit" name="login" value="login">
      </form>

</body>
</html>
<?php


// switch between this page and home.php
      // $_SESSION["username"] = "Art code";
      // $_SESSION["password"] = "pizza123";
// now i want to access this two from homepage
      // echo $_SESSION["username"] . "<br>";
      // echo $_SESSION["password"] . "<br>";
?>