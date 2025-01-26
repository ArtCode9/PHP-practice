<?php

   $user = array(
      "ali" => [
                 "role" => "author",
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
         echo"you are in team with sara";
      }else{
         echo"waiting for manager to manage your duty";
      }
}else{
   echo"review your condition dear {$user["ali"]["email"]}";
}


?>