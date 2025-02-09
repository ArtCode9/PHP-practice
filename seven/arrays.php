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
      echo"<hr>";
      echo"<hr>";

      // 3=> Multidimensional arrays
      echo"Multidimensional arrays ::<br>";

      $gamer = array(
            [
               "name" => "erfan",
               "email" => "erfan@gmail.com",
               "username" => "erfan123"
            ],
            [
               "name" => "goli",
               "email" => "goli@gmail.com",
               "username" => "goli123"
            ],
            [
               "name" => "doe",
               "email" => "doe@gmail.com",
               "username" => "doe123"
            ]
      );
      var_dump($gamer);
      echo"<br>";
      echo"<hr>";
      print_r($gamer);
      echo"<hr>";
      print_r($gamer[1]);
      echo"<hr>";
      print_r($gamer[1]["name"]);
      echo"<br>";
      echo $gamer[1]["name"];
      echo"<hr>";

      echo"set index myself in multidimensional::<br>";
      $noob = array(
           "1" => [
               "name" => "erfan",
               "email" => "erfan@gmail.com",
               "username" => "erfan123"
            ],
            "2" => [
               "name" => "goli",
               "email" => "goli@gmail.com",
               "username" => "goli123"
            ],
            "3" => [
               "name" => "doe",
               "email" => "doe@gmail.com",
               "username" => "doe123"
            ]
      );
      var_dump($noob);
      echo"<br>";
      echo"<hr>";
      print_r($noob);
      echo"<hr>";
      print_r($noob[3]);
      echo"<hr>";
      print_r($noob[3]["name"]);
      echo"<br>";
      echo $noob[3]["name"];
      echo"<hr>";
      echo"<p style='color:green;font-size:22px;'> welcome {$noob[3]["name"]}</p><br>";
      echo"welcome {$noob[3]["name"]}<br>";
      echo'welcome {$noob[3]["name"]}';
      echo"<hr>";

?>