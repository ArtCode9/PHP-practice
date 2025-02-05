<?php
   // loops  🚩🚩🚩🚩🚩🚩🚩🚩🚩
   $i = 0;

   while($i <= 10){
      echo"  $i ";
      $i++;
   }

echo"<hr>";

$i = 0;

while($i <= 80){
      echo $i;
      $i++;
}
echo "<hr>";
echo "<br>";
$j = 1;
while($j <= 25){
   echo $j . "  You Strong   ";
   $j++;
}
echo"<hr>";


$i = null;
while(true){
   echo"<span style='color:red;background-color:black;padding:2px;font-size:23px;'>
         $i</span>";
   if($i == 10){
      break;
   }
   $i++;
}
echo "<br>";
echo "<hr>";
$x = null;

while(true){
      echo"<span style='color: blue; background-color: black; font-size: 23px; padding:17px'>$x</span>";
      if($x == 10){
            break;  
      }
      $x++;
}




?>