<?php
      session_start();

      if(!isset($_SESSION['counter'])){
            echo " not set<br>";
            $_SESSION['counter'] = 1;
            echo $_SESSION['counter'];
      }else{
         echo "set<br>";
         $_SESSION['counter'] += 1;
      }
      
      $msg = "You have visited this page" . $_SESSION['counter'];
      echo $msg;
?>