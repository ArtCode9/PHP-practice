<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>isset() empty()</title>
</head>
<body>
         <form action="13_issetEmpty.php" method="post">
            <label>Username:</label>
            <input type="text" name="username"><br>
            <label>Password:</label>
            <input type="password" name="password"><br>
            <input type="submit" value="Log in" name="login"><br>
         </form>   
</body>
</html>
<?php

         /* if(isset($_POST["login"])){
               $username = $_POST["username"]; 
               $password = $_POST["password"]; 
               
               if(empty($username)){
                  echo"username is missing<br>";
               }
               elseif(empty($password)){
                  echo"password is missing<br>";
               }
               else{
                  echo"Hello {$username}<br>";
               }
         } */

////////////////////////////////////////
         
         foreach($_POST as $key => $value){
               echo"{$key} = {$value} <br>";
         }
//////////////////////////////////////////

         // isset() = returns true if a variable is declared and not null
         // empty() = returns true if a variable is not declared , false , null, ""

        /*  $username = true;
         $nickname = "coder";

         if(isset($username)){
            echo "This username is set<br>";
         }else {
            echo "set a username for yourself<br>";
         }

         if(empty($nickname)){
            echo"This variable is empty";
         }else{
            echo"This variable is NOT empty";
         }
 */
?>