<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Associative Array</title>
</head>
<body>
         <form action="12_associative_array.php" method="post">
               <label>Enter a country:</label>
               <input type="text" name="country">
               <input type="submit">
         </form>
</body>
</html>
<?php 
         $capitals = array("USA" => "Washington DC",
                           "Japan" => "Kyoto",
                           "South Korea" => "Seoul",
                           "India" => "New Delhi");
         
                           
         $capital = $capitals[$_POST["country"]];
         echo " THE capital is" . $capital . "<br>";


         echo"=====================<br>";
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
         $cat = array_keys($capitals);
         // need all of values in this array 
         $val = array_values($capitals);
         // we can flip keys and the values
         $fliper = array_flip($capitals);
         //  if need to reverse the order
         $capcap = array_reverse($capitals);
         // if need amount of key value pairs 
         echo count($capitals) . "<br>";
         echo count($cat) . "<br>";
         echo count($val) . "<br>";
 

         foreach($capitals as $key => $value){
            echo"{$key} is = {$value}<br>";
         };
         echo"=====================<br>";
         foreach($cat as $key){
            echo"{$key} <br>";
         };
         echo"=====================<br>";
         foreach($val as $key){
            echo"{$key} <br>";
         };
         echo"=====================<br>";
         foreach($fliper as $key => $value){
            echo"{$key} = {$value}<br>";
         }; 
         echo"=====================<br>";
         foreach($capcap as $key => $value){
            echo"{$key} is = {$value}<br>";
         };
?>