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
               <label>Name:</label><br>
               <input type="text" name="name"><br>
               <label>Nickname:</label><br>
               <input type="text" name="nickname"><br>
               <label>Password:</label><br>
               <input type="password" name="password"><br>
               <label>Phone Number:</label><br>
               <input type="text" name="number"><br>
               <input type="submit" name="submit" value="register">               
         </form>
</body>
</html>

<?php
      if($_SERVER["REQUEST_METHOD"] == "POST"){

         $name = $_POST["name"];
         $nickname = $_POST["nickname"];
         $password = $_POST["password"]; 
         $number = $_POST["number"];

      // one way
      //    $sql = "INSERT INTO batman (`name`, `nickname`, `password`, `phone_number`)
      //                VALUES('$name', '$nickname', '$password', $number)";
      

      //      if( $conn->execute_query($sql) == true){
      //       echo"you verify";
      //      }else{
      //       echo"please enter info";
      //      }
                

      
      // second way
      $sql = "INSERT INTO batman (`name`, `nickname`, `password`, `phone_number`)
                     VALUES(?, ?, ?, ?)";
      try{
         $stmt = $conn->prepare($sql);
         $stmt->bind_param('ssss', $name, $nickname, $password, $number);
            
         $stmt->execute();
         $stmt->close();   
      }catch(Exception $e){
            echo"Error happen" . $e->getMessage();
      }  
          
      }

      mysqli_close($conn);
?>