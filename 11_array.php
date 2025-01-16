<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Array</title>
</head>
<body>
   
</body>
</html>
<?php
      $food_1 = "apple";
      $food_2 = "orange";
      $food_3 = "banana";
      $food_4 = "coconut";

      //  array
      $foods = array("apple","orange","banana","coconut");

      echo $foods[0] . "<br><br>";

      $foods[0] = "pineapple"; // change first elements
      array_push($foods, "kiwi", "Art");// add 
      array_pop($foods);   // remove last element   ==> art remove now
      array_shift($foods); // remove first element
      $reversed_foods = array_reverse($foods);
   

      foreach($foods as $food) {
            echo $food . "<br><br>";
      };

      foreach($reversed_foods as $food) {
         echo $food . "<br><br>";
   };

   echo count($reversed_foods);

?>