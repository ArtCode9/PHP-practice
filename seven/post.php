<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>POST Method</title>
</head>
<body>
         <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                  <label>Name:</label><br>
                  <input type="text" name="Fname" placeholder="Name"><br>
                  <hr>
                  <label>Age:</label><br>
                  <input type="text" name="age" placeholder="Your Age"><br>
                  <hr>
                  <input type="submit" value="SEND" name="send">
         </form>  
</body>
</html>
<?php
      
      if(isset($_POST["send"])){
         if(!empty($_POST["Fname"]) && !empty($_POST["age"])){
            echo "Welcome " . $_POST["Fname"]. "<br>";
            echo "You are " . $_POST["age"] . " old";
         } else{
               echo"please fill the form";
         }
      };
?>