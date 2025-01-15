<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>forLoop</title>
</head>
<body>
         <form action="9_forLoop.php" method="post">
               <label>Enter a number to count to:</label>
               <input type="text" name="counter">
               <input type="submit" value="start">
         </form>

         <form action="9_forLoop.php" method="post">
               <label>Enter a number to count down:</label>
               <input type="text" name="counter2">
               <input type="submit" value="start2">
         </form>

</body>
</html>
<?php
         $counter = $_POST["counter"];
         $counter2 = $_POST["counter2"];
         
         for($i = 1; $i <= $counter; $i++){
            echo$i."<br>";
         };

         for($j = $counter2; $j > 0; $j--){
            echo$j ."<br>";
         };

      // for loop 

      // for($i = 0; $i <= 6; $i++){
      //       echo"*<br>";
      // }
      
   //    for ($i = 1; $i <= 9; $i++) {
   //       for ($j = 1; $j <= $i; $j++) {
   //           echo "*";
   //       }
   //       echo "<br>";
   //   }
       
   // make tree
   // $height = 5; // You can change the height of the tree here

   // for ($i = 1; $i <= $height; $i++) {
   //    for ($j = $height; $j > $i; $j--) {
   //       echo " ";
   //    }
   //    for ($k = 1; $k <= (2 * $i - 1); $k++) {
   //       echo "*";
   //    }
   //    echo "\n<br>";
   // }

?>