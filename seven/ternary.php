<?php

   $num = 100;
   if($num == 100){
      $msg = "$num is equal to 100";
   }else{
      $msg = "$num is not equal to 100";
   };
echo $msg;
echo"<hr>";

// now we create condition with ternary option

$msg2 = ($num == 100) ? "$num is equal to 100" : "$num is not equal to 100";
echo $msg2;


?>