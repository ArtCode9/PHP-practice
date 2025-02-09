<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Get Method</title>
</head>
<body>

      <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <label>name:</label><br>
            <input type="text" name="Fname" placeholder="Name"><br>
            <label>Age:</label><br>
            <input type="text" name="age" placeholder="Age"><br><br>
            <input type="submit" value="SEND">
      </form> <br>
      <a href="object.php">Your data</a>
      <hr><hr>
     


</body>
</html>
<?php
      // get value from form inside html
      
      // if(!empty($_REQUEST["Fname"]) && !empty($_REQUEST["age"])){
      //       echo "Welcome " . $_REQUEST["Fname"]. "<br>";
      //       echo "You are " . $_REQUEST["age"] . " old";
      //    } else{
      //          echo"please fill the form";
      //    }
      if($_GET["age"] > 18){
            print_r($_GET["Fname"]);
            echo"<br>";
            echo"welcome ". $_GET["Fname"];
      }else{
            echo"Your NOT elder";
      };

?>