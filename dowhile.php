<?php
      $num = 99;   
      $i = null;
      while($num == 99){
         echo"<span style='color:red;background-color:black;padding:2px;font-size:23px;'>
               $i</span>";
         if($i == 10){
            break;
         }
         $i++;
      }
echo"<hr>";
echo"<hr>";
echo"Do while section ::::<br>";

$x = 1;
do{
   echo"<span style='color:green;background-color:black;padding:2px;font-size:43px;'>
   $x</span>";
   if($x == 10){
         break;
   }
   $x++;
}while(true);





?>