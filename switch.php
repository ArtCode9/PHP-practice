<?php

   echo"hello switch";
   echo"<hr>";

   $dayPick = 1;
   $loan = 3000;

   switch($dayPick){
      case 1:
              echo"You pick one day for your dept<br>";
              if($loan < 1000){
                 echo"you must reback your loan $$loan with one part";
              }elseif($loan > 1000){
                 echo"you must reback your loan $$loan with three part as sonn possible";
              }else{
                 echo"you must pay strict mood and your account was closed";
              }
              break;
      case 2:
              echo"You pick two day for your dept<br>";
              break;
      case 3:
              echo"You pick three day for your dept<br>";
              break;
      case 4:
              echo"You pick four day for your dept<br>";
              break;
      case 5:
              echo"You pick five day for your dept<br>";
              break;
      default:
         echo"you pay your dept<br>";
   };
   echo"<hr>";

?>