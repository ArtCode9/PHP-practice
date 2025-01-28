<?php
$num = 123;
$num1 = [1, 2];
$str = ["art", "cool"];

$x = 10;
$y = 20;


echo"Super Global Arrays<br>";
echo"<hr style='border:3px solid black'>";
echo"<pre>";
var_dump($GLOBALS);
echo"</pre>";
echo"<hr style='border:3px solid black'>";
echo"<code>";
var_dump($GLOBALS);
echo"</code>";
echo"<hr style='border:3px solid tomato'>";


function sum(){
   // global $y;
   $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
};

sum();
echo $z;
echo"<br>";
echo $x;
echo"<br>";
echo $y;






?> 