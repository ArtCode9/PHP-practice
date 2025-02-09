<?php
$users = array(
  
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
print_r($users);
echo"<hr>";

// array to json

$jsonStr = json_encode($users);
echo"👹array to json:::<br>";
echo $jsonStr;
echo"<hr>";

// json to array assoc
$jsonArr = json_decode($jsonStr, 1);
echo"🤠 json to array assoc:::<br>";
print_r($jsonArr);
echo"<hr>";

// json to stdClass object
$jsonArr2 = json_decode($jsonStr);
echo"🥶 json to array object:::<br>";
print_r($jsonArr2);
echo"<hr>"; 
echo"<hr>"; 
echo"<br><br>";
/////////////////////////////////////////////////////////////
$booker = array(
  
   "1" => [
       "name" => "kaka",
       "email" => "kaka@gmail.com",
       "username" => "kaka123"
    ],
    "2" => [
       "name" => [
                     "firstName" => "feranchesco",
                     "lastName" => "toti"
                 ],
       "email" => "toti@gmail.com",
       "username" => "toti123"
    ],
    "3" => [
       "name" => "jil",
       "email" => "jil@gmail.com",
       "username" => "jil123"
    ]

);
print_r($booker);
echo"<hr>";

// array to json
$bookerStr = json_encode($booker);
echo"convert array to json tag:::<br>";
echo $bookerStr;
echo"<hr>";
echo $booker["2"]["name"]["firstName"];
echo"<hr>";
echo $booker["2"]["name"]["lastName"];
echo "<hr>";
// echo ($booker->{2}->name->lastName)   it's not work why??

// direct change array to object
$usertoObject = (object) $booker;
echo"direct convert to object::<br>";
print_r($usertoObject);

?>