<?php

   $user = array(
      "ali" => [
                 "role" => "admin",
                 "age" => 16,
                 "email" => "ali@gmail.com"
               ],
      "erfan" => [
                   "role" => "admin",
                   "age" => 27,
                   "email" => "erfan@gmail.com"
                 ],
      "sara" => [
                  "role" => "editor",
                  "age" => 19,
                  "email" => "sara@gmail.com"
                ]
   );

$usersCo = json_decode(json_encode($user));
var_dump($usersCo);
echo"<hr>";

if($usersCo->ali->role == "author" && $usersCo->ali->age == 16){
      echo"ali is verify to be at team<br>";
      if($usersCo->sara->age >= $usersCo->ali->age && $usersCo->sara->role == "editor"){
         echo"you are in team with sara<br>";
      }else{
         echo"waiting for manager to manage your duty<br>";
      }
}elseif ($usersCo->ali->role == "admin" && $usersCo->ali->age >= 16){
   echo"dear {$user["ali"]["email"]} you are qualify to be an admin<br>";
   if($usersCo->sara->role == $usersCo->ali->role){
      echo"ali and sara both the admin of the saling page<br>";
   }else if($usersCo->erfan->role == $usersCo->ali->role){
      echo"ali and erfan both the admin of the saling page<br>";
   }else{
      echo"you are not in admin with anybody";
   }
}
echo"<hr>";




?>