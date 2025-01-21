<?php 
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Insert data to base</title>
</head>
<body>
         <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
               <h2>Welcome To register Form:</h2>
               Email:<br>
               <input type="text" name="email"><br>
               <input type="submit" name="submit" value="register">               
         </form>
</body>
</html>

<?php
      if($_SERVER["REQUEST_METHOD"] == "POST"){

          $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

          if(empty($email)){
               echo"Please enter your email";
          }else{
            $sql = "INSERT INTO axeart (email)
                     VALUES('$email')";
            mysqli_query($conn, $sql);
            echo"You verify email!";
          }
      }

      mysqli_close($conn);
?>