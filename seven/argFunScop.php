<?php

   echo"Argument Referenced and Function Scope<br>";
   echo"<hr style='border:9px solid violet'>";

   // argument by value
   function test($art = null){

         return $art *= $art;
   }

   echo $num = 5;
   echo"<br>";
   echo test($num);

   echo"<hr style='border:9px solid lightblue'>";
   // argument by reference
   // when are parameter have right before this >>>  &  
   // the value of $cal is the result value inside the function
   function test1(&$num = null){
      return $num *= $num;
   };

   echo $cal = 5;
   echo"<br>";
   echo test1($cal);
   echo"<br>";
   echo $cal;
   
   echo"<hr style='border:9px solid firebrick'>";
   echo"Variables Scope::<br>";
   
   //ex.1
   function hello(){
      $Msg = "Hello world";
      return $Msg;
   };

   echo hello();
   // echo $Msg;  <<<< can not access outside the function
   echo"<hr style='border:3px solid firebrick'>";


   //ex.2
   $msg2 = "Hello world from outside<br>";
   function hello2(){
      //return $msg2;
   };
   //echo hello2();  <<<<<< can not access from outside the function
   echo $msg2;

   echo"<hr style='border:3px solid gold'>";
   // set global var for use everywhere

   $dd ="Hello global var talking<br>";
   
   function globFun(){
       global $dd;
      return $dd;
   }
   echo globFun();
   echo $dd;
   $dd = "BYE BYE";
   echo $dd;


   echo"<hr style='border:9px solid black'>";

   echo"Dynamic Function call<br>";
   function sayHello($name = null){
      return "hello $name<br>";  
   }

   echo sayHello();
   $q = "sayHello";
   echo $q("art");

?>