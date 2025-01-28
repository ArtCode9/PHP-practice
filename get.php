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
      

      if(!empty($_GET["age"]) > 18){
         echo "👾Dear  " . !empty($_GET["Fname"]) . "  your age is = ". $_GET["age"] ." and You can verify<br>";
      }else{
         echo "😈Dear  " . $_GET["Fname"] . "  Your not Adult<br>";
      };


?>