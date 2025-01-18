<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Function</title>
</head>
<body>
   
</body>
</html>
<?php
      function hypotenuse(float $a, float $b){
         $c = sqrt($a ** 2 + $b ** 2);
         return $c;
      };

      echo hypotenuse(3, 4) . "<br>";
      echo hypotenuse(6, 9) . "<br>";


      // function is_even($number){
            
      //       return $number % 2;
      // };
      // echo is_even(6);

     
     
   //   function happy_birthday($first_name, $age){
   //          echo"Happy Birthday dear {$first_name}!<br>";
   //          echo"Happy Birthday dear {$first_name}!<br>";
   //          echo"Happy Birthday dear {$first_name}!<br>";
   //          echo"Your are {$age} years old !<br>";
   //    }

   //    happy_birthday("Spongebob", 34);
   //    happy_birthday("patrick", 23);
   
?>