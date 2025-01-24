<?php
      // incrementing and decrementing Operators

      // incrementing
      $x = 10;
      echo"incrementing<br>";
      echo $x;
      echo"<hr>";
      echo ++$x; // pre incrementing
      echo"<hr>";
      echo $x++; // post incrementing
      echo"<hr>";

      echo $x;
      echo"<hr>";

      // decrementing
      echo"decrementing";
      echo"<hr>";
      $y = 5;

      echo $y;
      echo"<hr>";
      echo --$y;  // pre
      echo"<hr>";
      echo $y--;  // post
      echo"<hr>";
      echo $y;
      echo"<hr>";
      echo"<hr>";
      echo"<hr>";
// ///////////////////////////////////////////
      // string operator
      $k = 'Hello';
      $i = 'world';
      $z = '!';

      echo $k . $i . $z; // Concatenation
      echo"<hr>";
      
      $k .= $i .= $z;  // Concatenation assignment
      echo $k;
      echo"<hr><br>";

      // Spaceship Operator introduce in php 7::   <=>   (return  -1 0 1  )

      $p = 10;
      $v = 10;
      $j = 6;
      echo"Spaceship Operator<br>";

      $t = $p <=> $v;
      echo $t;
      echo"<hr>";
      $t2 = $p <=> $j;
      echo $t2;
      echo"<hr>";
      $t3 = $j <=> $p;
      echo $t3;

      echo "<br><hr>";
      echo "x" <=> "y";
      echo "<br>";
      echo "y" <=> "x";

?>