<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Radio button</title>
</head>
<body>
            <form action="14_radioButton.php" method="post">
               <input type="radio" name="credit_card" value="Visa">Visa<br>
               <input type="radio" name="credit_card" value="Mastercard">Mastercard<br>
               <input type="radio" name="credit_card" value="American Express">American Express<br>
               <input type="submit" name="confirm" value="confirm">
            </form>
            <hr>
            <form action="14_radioButton.php" method="post">
               <input type="radio" name="food_card" value="pizza">Pizza<br>
               <input type="radio" name="food_card" value="pasta">Pasta<br>
               <input type="radio" name="food_card" value="soda">Soda<br>
               <input type="submit" name="pick" value="confirm">
            </form>
            <hr>
</body>
</html>
<?php
         //  food section
         if(isset($_POST["pick"])){

            $food_card = null;

            if(isset($_POST["food_card"])){ // select a value from radio button
                  $food_card = $_POST["food_card"];// assign value to local variable
            }

            switch($food_card){
                   case "pizza":
                     echo"You select pizza";
                     break;
                  case "pasta":
                     echo"pasta is really good chose";
                     break;
                  case "soda":
                     echo"soda is good with other male";
                     break;
                  default:
                     echo"Please make selection i'am starving";
            }

         }


         //  credit card section

         if(isset($_POST["confirm"])){

            $credit_card = null;
               
            if(isset($_POST["credit_card"])){
               $credit_card = $_POST["credit_card"];
               // echo $credit_card;    
            }/* else{
               echo"Please make a selection!";
            } */

            if($credit_card == "Visa"){
               echo"You selected Visa";
            }elseif($credit_card == "Mastercard"){
               echo"You selected Mastercard";
            }elseif($credit_card == "American Express"){
               echo"You selected American Express";
            }else{
               echo"Please make a selection!";
            }
            
         }

?>