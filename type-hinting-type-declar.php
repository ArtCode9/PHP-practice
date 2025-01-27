<?php
      declare(strict_types=1);
//  with this above tag we got strict execution on our code script

      echo"Type hinting and type Declarations<br>";
      echo"<hr style='border:6px solid black'>";

      function sum( int $a = null, int $b = null){
            return $a + $b;
      };

      echo sum(10, 20);
      
      echo"<hr style='border:6px solid silver'>";

      function sum1(int $a = null, int $b = null) :int{
           // this last int outside the() force the function for integer result
            return $a + $b;
      };
      echo sum1(12, 16);  // if we remove strict mode we can use float in this function

      echo"<hr style='border:6px solid blue'>";

      function doLogin(string $a = null, string $b = null) : string{
            return $a . $b;
      };
      
      echo doLogin("Adam", "wild")


?>