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

      echo "<hr style='border:3px solid yellow'>";
      echo "x" <=> "y";
      echo "<br>";
      echo "y" <=> "x";
      echo'<hr>';
      // logical operator
      
      // && and operator
      $q = 10;
      $w = 20;
      $e = 10;

      if($q == 10 && $w == 20 && $e == 11){
            echo'true';
      }else{
            echo'false';
      }
      echo"<hr style='border:3px solid black'>";

      // || or operator 
      if($q == 10 or $w == 20 || $e == 11){
            echo'🤯true';
      }else{
            echo'🤯false';
      }
      echo"<hr style='border:3px solid gold'>";

      // xor
      if($q == 10 xor $w == 21){
            echo'🤑true';
      }else{
            echo'🤑false';
      }

      echo"<hr style='border:3px solid gold'>";

      // !=  

      if($q !== 12){
            echo'🤢true';
      }else{
            echo'🤢false';
      }

      echo"<hr style='border:3px solid blue'>";

      $x_x = array('r' => 'red', 'b' => 'blue', 'g' => 'green');
      $x_x2 = array('r' => 'red', 'b' => 'blue', 'g' => 'green');
      $o_p = array('o' => 'orange', 'y' => 'yellow', 'p' => 'pink');

      print_r($x_x);
      echo'<br>';
      print_r($o_p);
      echo"<hr style='border:3px solid lightgreen'>";

      // union operator  +
      $o_o = $x_x + $o_p;
      print_r($o_o);

      echo"<hr style='border:3px solid black'>";
      // equality operator both array not have equal element
      $y_y = $x_x == $o_p;
      var_dump($y_y);

      echo"<hr style='border:3px solid green'>";
      echo"<hr style='border:3px solid green'>";
      // === identity
      var_dump($x_x === $x_x2);

      echo"<hr style='border:3px solid orange'>";
      echo"<hr style='border:3px solid orange'>";
      // <> inequality  the behaiver similar to !=
      var_dump($x_x <> $x_x2);
      var_dump($x_x !== $x_x2);


?>