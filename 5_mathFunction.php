<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Math related Function</title>
</head>
<body>
            <form action="5_mathFunction.php" method="post">
                  <label>x:</label>
                  <input type="text" name="x"><br>
                  <label>y:</label>
                  <input type="text" name="y"><br>
                  <label>z:</label>
                  <input type="text" name="z"><br>
                  <input type="submit" value="total">
            </form>   
</body>
</html>
<!-- part 5 -->
<?php
      $x = $_POST["x"];
      $y = $_POST["y"];
      $z = $_POST["z"];
      $total = null;
      
      //  absolute value function >> return positive number
      // $total = abs($x); 

      //  round function
      // $total = round($x);
      
      //  round down function >>>> floor
      // $total = floor($x);
      
      //  round up function >>>>>  ceil
      // $total = ceil($x);
     
      //  power function >>>> pow (need two parameter)
      // $total = pow($x, $y);
      
      // square root function >>>>>>>   sqrt
      // $total = sqrt($x);
     
      // max and min function
      // $total = max($x, $y, $z);
      // $total = min($x, $y, $z);

      // pi function
      // $total = pi();

      // random function  >>>>> rand (if it's empty make random number)
      //                             (but can set between two value)
      // $total = rand();
      // $total = rand(1, 6);

      echo $total;
?>