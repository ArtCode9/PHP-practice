<?php
echo"Operators section::<br>";
echo"<hr style='border:9px solid #E75480'>";

// Arithmetic operators
   $x = 10;
   $y = 5;
   echo"Arithmetic operators<br>";
   echo($x + $y)." = addition<br>";
   echo($x - $y)." = minus<br>";
   echo($x * $y)."  = multi<br>";
   echo($x / $y)." = divide<br>";
   echo($x % $y)." = %<br>";

   echo"<hr style='border:9px solid darkgreen'>";
//  Assignment operators
   echo"Assignment operators<br>";
   $k = 50;
   echo$k ."<br>";
   $k += 5;
   echo$k ."<br>";
   $k -= 15;
   echo$k ."<br>";
   $k *= 10;
   echo$k ."<br>";
   $k /= 7;
   echo$k ."<br>";
   $k %= 7;
   echo$k ."<br>";

   echo"<hr style='border:9px solid darkseagreen'>";
// comparison operator
   echo"comparison operator<br>";
   $i = 20;
   $j = 30;
   $m = 25;
   $d = "25";
   
   var_dump($i, $j, $d);
   echo"<br>";
   var_dump($i === $j);
   echo"<br>";
   var_dump($m == $d);
   echo"<br>";
   var_dump($m === $d);
   echo"<br>";
   var_dump($d != $i);
   echo"<br>";
   var_dump($d <> $i);
   echo"<br>";
   var_dump($m !== $d);
   echo"<br>";
   var_dump($i > $j);
   echo"<br>";
   var_dump($i < $j);
   echo"<br>";
   var_dump($i >= $j);
   echo"<br>";
   var_dump($i <= $j);

   echo"<hr style='border:9px solid cornflowerblue'>";
?>