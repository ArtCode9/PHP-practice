<?php
   echo"MAGIC CONSTANTS<br>";
   echo"<hr style='border:6px solid red'>";
   // __LINE__
   echo "line number " . __LINE__ ."<br>";
   echo "line number " . __LINE__ ."<br>";
   echo "line number " . __LINE__ ."<br>";
   echo "line number " . __LINE__ ."<br>";
   echo "line number " . __LINE__ ."<br>";
   echo"<hr>";

   // __FILE__
   echo "File Path " . __FILE__ ."<br>";
   echo"<hr>";

   // __DIR__
   echo "File Directory " . __DIR__ ."<br>";
   echo"<hr>";

   // __FUNCTION__
   function test2(){
      echo"File Dir  " . __FUNCTION__."<br><br>";
   };
   test2();
   echo"<hr>";

   // __CLASS__
   class myClass {
         public function testClassName(){
            return __CLASS__;
         }
   }
   $myClass = new myClass();
   echo $myClass->testClassName(). "<br><br>";
   echo"<hr>";

   // __METHOD__
   class myClass1 {
      public function testClassMethod(){
         return __METHOD__ . __CLASS__;
      }
   }
   $myClass1 = new myClass1();
   echo $myClass1->testClassMethod()."<br>";
   echo"<hr>";

   // __NAMESPACE__

?>