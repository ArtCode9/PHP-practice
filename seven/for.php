<?php
   
   echo"<span style='color: green;font-size:46px;font-weight:bold;text-align:center'>For Loop ></span>";
   echo"<hr style='border:9px solid lightgreen'>";    

   for($j = 0; $j <= 10; $j++){
         echo"<span style='color:orange; font-weight:bold'>$j</span> ";
   }
   
   echo"<hr style='border:9px solid lightgreen'>";    

   for($x = 10; $x >= 0; $x--){
      echo"<span style='color:blue; font-weight:bold'>$x</span> ";
   }

   echo"<hr style='border:9px solid blue'>";    

   $users = array(["erfan", 20], ["maryam", 28], ["ehsan", 18], ["sara", 22]);
   print_r($users);
   echo"<hr style='border:9px solid lightgreen'>";    
   var_dump($users);
   echo"<hr style='border:9px solid orange'>";    

   for($k = 0; $k < sizeof($users); $k++){
      echo"😁Name = {$users[$k][0]} ... age={$users[$k][1]}". " / ";
   }

   echo"<hr style='border:9px solid #E75480'>";    
    $e = 0;
    while($e < sizeof($users)){
       echo"Name = {$users[$e][0]} ... age={$users[$e][1]} " . " / ";
       $e++;
    }

?>