<?php
echo"Anonymous Function<br>";
echo"<hr style='border:2px solid red'>";

$sum =  function(int $a=null, int $b = null) : int {
      return $a + $b;
};

echo $sum(2,67);

echo"<hr style='border:2px solid gold'>";
echo"Callback Function:<br>";

function name(string $string = null) {
   // return strtoupper($string); 

   $result = array(
      'upper' => strtoupper($string),
      'lower' => strtolower($string)
   );
   return $result;

};

// echo name("art");
print_r(name("art"));
echo"<br>";
 
// for access to one key in array
$strVar = name("artisa");
echo $strVar['upper'];

echo"<hr style='border:2px solid pink'>";
echo"Do all this with anonymous Function Callable<br>";

 function string(string $strin = null ,$callback = null){
      
      $result = array(
         'upper' => strtoupper($strin),
         'lower' => strtolower($strin)
      );
      
      if(is_callable($callback))
      {
         echo"callable<br>";
         call_user_func($callback, $result);
      }else{
         echo"NOT callable<br>";
      };
 };

string('artisa', function($name){
         echo"🦎🦎🦎🦎🦎🦎";
         print_r($name);
});
echo"<hr style='border:2px solid pink'>";
string("hello program", function($name){
   echo $name['upper'];
   echo"<br>";
});

string("HeLlO program", function($name){
   echo $name['lower'];
   echo"<br>";
});
?>