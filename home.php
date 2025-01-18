<?php 
   session_start(); 

   if(isset($_POST["logout"])){
      session_destroy();
      header("Location: 20_session.php");
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home Session</title>
</head>
<body>
         <h1>This is the home page</h1><br>
         <form action="home.php" method="post">
               <input type="submit" name="logout" value="logout">
         </form>
</body>
</html>
<?php
      echo $_SESSION["username"] . "<br>";
      echo $_SESSION["password"] . "<br>";
    

?>