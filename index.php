<!-- part 1 -->
<?php
      echo"I love pizza <br>";
      echo"It's really good<br>";
      // comment single line
      /* 
         comment multi line
      */
?>
<!-- part 2 -->
<?php
      // variable = a reusable container that holds data 
      //                string, integer, float, boolean
      //  strings
      $name = "Art Code";
      $food = "pizza";
      $email = "fake@gmail.com";
      // int
      $age = 23;
      $users = 2;
      $quantity = 4;
      // float
      $gpa = 2.5;
      $price = 5.99;
      $tax_rate = 5.1;
      // boolean
      $employed = true;
      $online = false;
      $for_sale = true;

      // display var
      echo $name;
      echo "<br>";
      echo "Hello {$name}<br>";
      echo "You order {$food}<br>";
      echo "Your email is {$email}<br>";
      
      echo "🤡=====================<br>";
      echo "You are {$age} years old<br>";
      echo "there are {$users} users online<br>";
      echo "You would like to buy {$quantity} items<br>";
      
      echo "🤡=====================<br>";
      echo "Your gpa is :: {$gpa}<br>";
      echo "Your pizza is \${$price}<br>"; 
      echo "the sales tax rate is : {$tax_rate}%<br>";
      
      echo "🤡=====================<br>";
      // boolean you don't see the result in web page
      echo "online status: {$online}<br>";// its false so don't display anything
      echo "this item is for sale :: {$for_sale}<br>";
      echo "You are employed result is : {$employed}<br>";

      echo "🤡=====================<br>";
      //  null its mean no value
      $total = null;
      echo "You have ordered {$quantity} x {$food}s <br>";
      $total  = $quantity * $price;
      echo "Your total is: \${$total}<br>";
      echo "🤡=====================<br>";
?>
<!-- part 3 -->
<?php
      //  Arithmetic operators
      //  + - * / ** %
      $x = 10;
      $y = 3;
      $z = null;

      // $z = $x + $y;
      // $z = $x - $y;
      // $z = $x * $y;
      // $z = $x / $y;
      $z = $x ** $y;
      // $z = $x % $y;
      echo $z;
      echo "<br>";
      echo "🤡=====================<br>";
      // Increment / decrement operators
      //  ++ --
      $counter = 0;
      $counter2 = 7;
      $counter3 = 7;
      $counter4 = 7;


      $counter++;
      $counter2--;
      
      $counter3+=2;
      $counter4-=2;
      
      echo "{$counter}<br>";
      echo "{$counter2}<br>";
      echo "{$counter3}<br>";
      echo "{$counter4}<br>";
      // operators Precedence
      // ()
      // **
      // * / %
      // + -
      $totalp =  (1 + (2 - 3) * 4) / (5 ** 6);
      echo "{$totalp}<br>"

?>
<!DOCTYPE html>
<html lang="en">
<head>
      
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      body{
            text-align: center;
            align-items: center;
            font-size: 19px;
            font-weight: bolder;
            font-family: system-ui, -apple-system;
      }
   </style>
</head>
<body>
         <br>
         <button>Order pizza</button>  

</body>
</html>