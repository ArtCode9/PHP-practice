<?php
    
/* 
Plugin Name: My First Plugin
Plugin URI:  https://example.com
Description: This is my first plugin.
Author: art code
Author URI: https://example.com
Text Domain: myfirstplugin
Domain Path: /languages/
Version: 1.0.0
*/

//   here we do an execution on site

/* function showname ($nameo){
   echo"My name is {$nameo}";
}
function law ($law){
echo "the {$law} is important for success";
}
showname("Ali Tvanamand");
echo"<br>";
showname("Mehid mehdi mehdi");
echo"<br>";
law("Trying");
 */

 

// this section work on hock concept
/* function doAction(){
   runAct1();
   runAct2();
   runAct3();
}

function runAct1(){
   echo"fun1";
}
function runAct2(){
   echo"fun2";
}
function runAct3(){
   echo"fun3";
}
doAction();
 */


$numbers = array(126, 35, 45, 65, 120);
$tips = [23, 54, 56, 78, 23];


$users = [
         "firstName" => "art",
         "admin" => "true",
         "numbers" => [
            1, 2, 4, 5, 67
         ]
];
$number23 = [
   "num1" => 22,
   "num2" => 23234
];

$avg_with_array = array_sum($numbers) / count($numbers);
$avg_with_tips = array_sum($tips) / count($tips); 



echo"<br>";
echo $avg_with_array;
echo"<br>";
echo $users["firstName"];
echo"<br>";
echo$number23["num2"];
echo"<br>";
echo $users["numbers"][4]; 


?>