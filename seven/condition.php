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
}else if($users->ali->role == ""){
   echo"Your not admin ";
}
// create array and work if on it 

$gamers = array(
   "1" => [
            "name" => "ghost",
            "id" => 2235,
            "games" => [
                        "game1" => "COD",
                        "game2" => "pubg",
                        "game3" => "WOW"
                        ]
         ],
   "2" => [
            "name" => "Cjstone",
            "id" => 98532,
            "games" => [
                          "game1" => "COD-warzone",
                          "game2" => "pubg",
                          "game3" => "DOTA2"
                       ]
          ],
);
echo"<hr>";
if($gamers["1"]["id"] == 2235){
   echo"player={$gamers["1"]["name"]} games is ==
   {$gamers["1"]["games"]["game1"]}/
   {$gamers["1"]["games"]["game2"]}/
   {$gamers["1"]["games"]["game3"]}";
}else{
   echo"this id isn not exist";
}

echo"<hr>";

$userWar =  (object) array(
   "ali" => [
               "role" => "author",
               "age"  => 17,
               "email" => "ali@gmail.com"
            ],
   "erfan" => [
               "role" => "admin",
               "age" => 28,
               "email" => "erfan@gmail.com"
              ],
   "sara" => [
                  "role" => "editor",
                  "age" => 22,
                  "email" => "sara@gmail.com"
             ]
);
var_dump($userWar);
echo"<hr>";
// mix object and array in if condition
if($userWar->ali["role"] == "admin"){
   echo"welcome admin to your panel";
}else{
   echo"your not admin";
}
echo"<hr>";
echo"<hr>";

// use json for array in if condition

$hobby = array(
         "h1" => [
               "name" => "videogame",
               "id" => 23567
            ],
         "h2" => [
               "name" => "painting",
               "id" => 2245985
            ],
         "h3" => [
               "name" => "boardgame",
               "id" => 8723
         ]
);
echo"this is my array<br>";
var_dump($hobby);
echo"<hr>";
// convert array to  json
$arrToJson = json_encode($hobby);
echo"convert array to json with json_encode<br>";
var_dump($arrToJson);
echo"<hr>";

// now convert json to php object
echo"now convert json to object<br>";
$jsonToArr = json_decode($arrToJson);
var_dump($jsonToArr);

// short form >> $users = json_decode(json_encode($user));

// now we use if condition with object style not array
if($jsonToArr->h1->id == 23567){
   echo"you enter in videogame hobby";
}else{
   echo"you are not enter to any hobby";
}


?>