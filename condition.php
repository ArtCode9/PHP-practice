<?php
      $num = 100;

      if($num == 100){
         echo"$num is equal 100";
      }else{
         echo "$num is not equal 100";
      };
echo"<hr>";

      $num1 = 32;
      $num2 = 23;
      $str = "ali";

      if($num1 == 32 && $num2 == 23 || $str == "art"){
         echo "true";
      }else{
         echo "false";
      }
echo"<hr>";

      if($num1 == 32){
         echo"num1 is connected<br>";
            if($num2 == 23){
               echo"num2 is connected<br>";
            }else{
               echo"num2 is not there";
            }

      }else{
         echo"num1 is not there";
      };
echo"<hr>";


   $users = (object) array(
      "ali" => (object)[
                  "role" => "author",
                  "age"  => 17,
                  "email" => "ali@gmail.com"
               ],
      "erfan" => (object)[
                  "role" => "admin",
                  "age" => 28,
                  "email" => "erfan@gmail.com"
                 ],
      "sara" => (object)[
                     "role" => "editor",
                     "age" => 22,
                     "email" => "sara@gmail.com"
                ]
   );

   // convert array to object
// $usersObject = (object) $users;
var_dump($users);
echo"<br>";

if($users->ali->role == "admin"){
      echo"welcome dear admin";
}else{
   echo"Your not admin ";
}







?>