<?php
      $array = array(1,2,3,4,5,6);

      print_r($array);
      echo"<hr><hr>";

      foreach($array as $value){
            echo $value . "😎" ."<hr>";
      }
      echo "<br>";
      echo "<hr>";

      $array2 = array(1,2,3,4,5,6);

      foreach($array2 as $value2){
            if($value2 == 5) continue;
            echo $value2 . "😘" ."<hr>";
      };
// ///////////////////////////////////////
      $users = array(
            "ali" => [
                  "role" => "author",
                  "age"  => 17,
                  "email" => "ali@gmail.com"
            ],
            "erfan" => [
                  "role" => "admin",
                  "age"  => 28,
                  "email" => "erfan@gmail.com"
            ],
            "sara" => [
                  "role" => "editor",
                  "age"  => 22,
                  "email" => "sara@gmail.com"
            ]
      );
      foreach($users as $key => $value){
            echo "👹$key : ({$value["role"]}) <br>";
            echo "$key : ({$value["age"]}) <br>";
            echo "$key : ({$value["email"]}) <hr>";
      };
      echo"<hr>";
      foreach($users as $user){
            echo"🤢{$user["role"]}<br>";
            echo"{$user["age"]}<br>";
            echo"{$user["email"]}<br>";
      };
// /////////////////////////////////////////////////
$heros = array(
      "1" => [
            "name" => "ali",
            "role" => "author",
            "age"  => 17,
            "email" => "ali@gmail.com"
      ],
      "2" => [
            "name" => "erfan",
            "role" => "admin",
            "age"  => 28,
            "email" => "erfan@gmail.com"
      ],
      "3" => [
            "name" => "sara",
            "role" => "editor",
            "age"  => 22,
            "email" => "sara@gmail.com"
      ]
);
echo"<hr>";
foreach($heros as $ho => $va){
      echo"🤑$ho : role : {$va["role"]} age : 
           {$va["age"]} email : {$va["email"]}<br>";
};

echo"<hr>";

foreach($heros as $com){
      echo " Welcome : {$com["name"]} :: {$com["role"]}<hr>";      
};









?> 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PHP play</title>
</head>
<body>




</body>
</html>
<?php 

?>