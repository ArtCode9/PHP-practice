<?php
   // loops
   $i = 0;

   while($i <= 10){
      echo"  $i  ";
      $i++;
   }

echo"<hr>";

$i = 0;

while($i <= 80){
      echo $i;
      $i++;
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





?>