<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Logical Operator</title>
</head>
<body>
   
</body>
</html>
<?php
      // &&  =>  true if both condition are true
      // ||  =>  true if at least one condition is true
      // !   =>  True if false,, False if true
//////////////////////////////////////////////////////////
      
      // $temp = 15;
      // $cloudy = true;

      // if($temp < 0 || $temp > 30){
      //    echo"The weather is bad😜.<br>";
      // }else{
      //    echo"The weather is cool😍<br>";
      // }
      // // true didn't need value define in condition
      // if($cloudy){
      //    echo"It's Cloudy<br>";
      // }elseif(!$cloudy){
      //    echo"It's false condition";
      // }else{
      //    echo"It's sunny<br>";
      // }

////////////////////////////////////////////////////

   // $age = 18;
   // $citizen = true;

   // if($age >= 18 && $citizen){
   //    echo"You can vote😂<br>";
   // }else{
   //    echo"You cannot vote😂<br>";
   // };

   // if(!$age >= 18 || !$citizen){
   //       echo"You cannot vote😫<br>";
   // }else{
   //       echo"You can vote😫<br>";
   // };

////////////////////////////////////////////////////
   $child = false;
   $senior = true;
   $ticket = null;

   if($child || $senior){
      $ticket = 10;
   }else{
      $ticket = 15;
   };
   
   echo"The ticket price is \${$ticket}";
?>