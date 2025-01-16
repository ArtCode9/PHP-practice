<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Associative Array</title>
</head>
<body>

</body>
</html>
<?php 
         $capitals = array("USA" => "Washington DC",
                           "Japan" => "Kyoto",
                           "South Korea" => "Seoul",
                           "India" => "New Delhi");
         echo $capitals["Japan"] . "<br>";
         
         // change one of them use key
         $capitals["USA"] = "Las Vegas"; 
         // add a new key value pair
         $capitals["China"] = "Beijing";
         //  pop function remove the last
         array_pop($capitals);
         // shift function remove the first
         array_shift($capitals);
         // need all of the keys in this array it also return new array 
         array_keys($capitals);


         foreach($capitals as $key => $value){
            echo"{$key} is = {$value}<br>";
         };



?>