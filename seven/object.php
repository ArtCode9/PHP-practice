<?php

$users = array(
      "1" => [
               "name" => [
                           "firstName" => "art",
                           "lastName" => "Tavan"
                         ],
               "email" => "art@gmail.com",
               "username" => "art772"
             ],
      "2" => [
               "name" => "kimia",
               "email" => "kiki@gmail.com",
               "username" => "kiki85"
             ],
);

// direct change array to object
$userToObject = (object) $users;

print_r($userToObject);
echo"<hr>";

// direct change object to array
$userToArray = (array) $userToObject;

print_r($userToArray);
echo"<hr>";


// create new object
$car = new stdClass;
$car -> name = "audi";
$car -> model = 2020;
$car -> gear = "auto";

print_r($car);
echo"<hr>";
print_r($car->model);
print_r($car->name);
echo"<hr>";

// this is call by refrence and override property
$car2 = $car;
$car2 -> name = "BENZ";

echo($car -> name). "<br>";
print_r($car2 -> name);
echo"<hr>";
// how clone object to perevent override
$car3 = clone $car2;
$car3 -> name = "Chevy";

echo $car3 -> name;

echo"<hr>";
echo"<hr>";

$int = 50;
$age = $int;
echo$age . "<br>";
$age = 17;
echo$age . "<br>";
echo$int . "<br>";


?>