<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Check Boxes</title>
</head>
<body>
            <form action="15_checkBoxes.php" method="post">
                 <input type="checkbox" name="pizza" value="pizza">Pizza<br>
                 <input type="checkbox" name="hamburger" value="hamburger">Hamburger<br>
                 <input type="checkbox" name="hotdog" value="hotdog">Hotdog<br>
                 <input type="checkbox" name="taco" value="taco">Taco<br>
                 <input type="submit" name="submit">
            </form>
            <hr><hr>

            <form action="15_checkBoxes.php" method="post">
                 <input type="checkbox" name="foods[]" value="pizza">Pizza<br>
                 <input type="checkbox" name="foods[]" value="hamburger">Hamburger<br>
                 <input type="checkbox" name="foods[]" value="hotdog">Hotdog<br>
                 <input type="checkbox" name="foods[]" value="taco">Taco<br>
                 <input type="submit" name="submit2">
            </form>
            <hr><hr><hr>
</body>
</html>
<?php
//////////  you can place all of these check boxes in array
      if(isset($_POST["submit2"])){
            
            $foods = $_POST["foods"];
            
            foreach($foods as $foods){
                  echo $foods  . "<br>";
            }
      };

///////////////////// check to see if checkbox is set or empty
      if(isset($_POST["submit"])){
            
            if(isset($_POST["pizza"])){
                  echo"I like💗 Pizza🍕<br>";
            }
            if(isset($_POST["hamburger"])){
                  echo"I like💗 Hamburger🍔<br>";
            }
            if(isset($_POST["hotdog"])){
                  echo"I like💗 Hotdog🌭<br>";
            }
            if(isset($_POST["taco"])){
                  echo"I like💗 Taco🌮<br>";
            }


            if(empty($_POST["pizza"])){
                  echo"I DON'T like Pizza🍕<br>";
            }
            if(empty($_POST["hamburger"])){
                  echo"I DON'T like Hamburger🍔<br>";
            }
            if(empty($_POST["hotdog"])){
                  echo"I DON'T like Hotdog🌭<br>";
            }
            if(empty($_POST["taco"])){
                  echo"I DON'T like Taco🌮<br>";
            }
      }

?>