<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Switch</title>
</head>
<body>
   
</body>
</html>
<?php

      // $grade = "FAD";

      // switch($grade){
      //       case "A":
      //          echo"You did great";
      //          break; // we need break to get out off the switch
      //       case "B":
      //          echo"You did good";
      //          break;
      //       case "C":
      //          echo"You did okay";
      //          break;
      //       case "D":
      //          echo"You did poorly";
      //          break;
      //       case "F":
      //          echo"You failed";
      //          break;
      //       default:
      //          echo"{$grade} is not valid";
      // };
//////////////////////////////////////////////////
      $date = date("l");
      
      // $date = "pizza";

      switch($date){
         case "Monday":
            echo"I love Monday";
            break;
         case "Tuesday":
            echo"this is Tuesday";
            break;
         case "Wednesday":
            echo"i love Wednesday";
            break;
         case "Thursday":
            echo"this is Thursday";
            break;
         case "Friday":
            echo"i want to rest";
            break;
         case "Saturday":
            echo"time to party";
            break;
         default:
         echo"{$date} is not day!!";
      };
?>