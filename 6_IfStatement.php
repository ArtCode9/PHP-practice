<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>IF statement</title>
</head>
<body>

</body>
</html>
<?php
    //  if statement
      $age = 33;

      if($age > 100){
            echo"Your are too old for working with this <br>";
      }elseif($age >= 18){
            echo"You may enter this sit <br>";
      }elseif($age < 0){
            echo"that's not born yet <br>";
      }else{
            echo"You must be +18 <br>";
      }

      $adult = false;

      if($adult){
         echo"Your are old enough <br>";
      }else {
         echo"You are too small <br>";
      }

      $hours = 50;
      $rate = 15;
      $weekly_pay = null;
      
      if($hours <= 0){
         $weekly_pay = 0; 
      }elseif($hours <= 40){
         $weekly_pay = $hours * $rate;
      }else{
         $weekly_pay = ($rate * 40) + (($hours - 40) * ($rate * 1.5));
      }
      echo"You made \${$weekly_pay} this week";
?>