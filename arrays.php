<?php
      $x = array();
      $y = [];

      var_dump($x);
      echo'<br>';
      print_r($x);
      echo'<hr>';
      var_dump($y);
      echo'<br>';
      print_r($y);
      echo'<hr>';
      // we got three type of array
      
      // 1=> indexed array
      echo"indexed array ::<br>";
      
      $car = array("bmw", "benz", "jeep", "chevy" , 12, 15, 12.5);
      
      var_dump($car);
      echo"<br>";
      print_r($car);
      echo"<br>";
      echo"I'am in love with {$car[3]}";
      echo"<br>";
      echo $car[6];
      echo"<hr>";

      // 2=> associative  array
      echo"associative array ::<br>";

      $capital = array("iran" => "tehran",
                       "japan" => "tokyo",
                       "germany" => "berlin",
                       "england" => "london");
      var_dump($capital);
      echo"<br>";
      print_r($capital);
      echo"<br>";
      echo $capital["japan"] . " :: is the capital of the japan";
      echo"<hr>";

      $ages = ["ghazal" => 23, "erfan" => 28, "john" => 15, "maryam" => 33, 34 , 45,"ghazal" => 780];
      print_r($ages); 
      echo"<br>";
      echo $ages["ghazal"];
      echo"<br>";
      echo $ages[0];

?>