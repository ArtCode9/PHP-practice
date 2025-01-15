<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Radius of Circle</title>
</head>
<body>
         <form action="exercise1.php" method="post">
               <label>radius:</label><br>
               <input type="text" name="rad"><br>
               <input type="submit" value="calculate">
         </form><br>
</body>
</html>
<?php
      $radius = $_POST["rad"];
      $circum = null;
      $area = null;
      $volume = null;

      $circum = 2 * pi() * $radius;
      $circum = round($circum, 2);

      $area = round((pi() * pow($radius, 2)), 2);

      $volume = round(4/3 * pi() * pow($radius, 3));
      
      echo"circum of circle is : {$circum}cm <br>";
      echo"Area of circle is : {$area}cm^2 <br>";
      echo"Volume of circle is : {$volume}cm^3 <br>";
?>