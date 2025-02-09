<?php
      echo"Function<br>";
      echo"<hr style='border: 6px solid darkmagenta'>";

      // A function is a block of statement that can be used repeatedly
      // in a program.
      // A function will not execute automatically when a page load
      // A function will be execute by call a to the function
      
      // this is user define function ::: (the other is predefine function)
      //       function funName (argument){
      //             code to be execute;
      //       }

      function printMsg (){
         return "hello function speak";
      };
      echo printMsg();

      echo"<hr style='border: 6px solid coral'>";

      function plusX ($x, $u){
         return ($x + $u);
      };
      $o = 9;
      $o2 = 10;
      echo plusX($o, $o2);
      echo"<br>";
      echo plusX(5, 6);

      echo"<hr style='border: 6px solid mediumpurple'>";
      function emailT ($email){
         return "your email is : {$email}";
      }

      echo emailT("ali7723#gmail.com");
      echo"<hr style='border: 6px solid gold'>";
      
      function verifyE ($email, $password = null){
         return "your email is : {$email} password is :: ({$password})";
      }

      echo verifyE("artcode92gmail.com", 982391);
      echo"<br>";
      echo verifyE("axe292gmail.com");

      echo"<hr style='border: 6px solid orangered'>";

      function plusX2 ($x = 10 , $u = 90 , $z = null){
         return ($x + $u + $z);
      };
      echo plusX2();
      echo"<br>";
      echo plusX2(2, 6);
      echo"<hr style='border: 6px solid palegreen'>";

      echo"function on arrays<br>";

      function sumAll(){
         $args = func_get_args();
         var_dump($args);
         echo"<br>";
         return var_dump(array_sum($args));
      };
      sumAll(1,2,3,4,5);
      echo"<br>";
      sumAll(13,12,43,41,55,43,23,123,213);

      echo"<hr style='border: 6px solid palegreen'>";
      
      // PHP 5.6
      function sumAll2 (...$args){
            return array_sum($args);
      }

      echo sumAll2(4,23,2,3,6,5,454,23,23);

?>