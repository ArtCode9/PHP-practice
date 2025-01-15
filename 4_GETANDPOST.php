<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>GET and POST</title>
</head>
<body>

      <!--🟠 <form action="GETANDPOST.php" method="get">
            <label>username:</label><br>
            <input type="text" name="username"><br>
            <label>password</label><br>
            <input type="password" name="password"><br>
            <input type="submit" value="Log in">
      </form><br><br>

      <form action="GETANDPOST.php" method="post">
            <label>username:</label><br>
            <input type="text" name="username2"><br>
            <label>password</label><br>
            <input type="password" name="password2"><br>
            <input type="submit" value="Log in">
      </form> -->
      <!-- ===================================== -->
      <form action="GETANDPOST.php" method="post">
            <label>quantity: </label><br>
            <input type="text" name="quantity"><br>
            <input type="submit" value="total">
      </form>
      

</body>
</html>
   <!-- part 4 -->
<?php
      // 🟠 $_GET, $_POST = special var used to collect data from an HTML form
      // data is sent to the file in the action attribute of <form></form>
      //       <form action="some_file.php" method="get"></form>

      // $_GET = Data is appended to the url 
      //          NOT SECURE
      //          char limit
      //          bookmark is possible w/ values
      //          GET requests can be cached
      //          Better for a search page
  
      // echo "{$_GET["username"]} <br>";
      // echo "{$_GET["password"]} <br>";

      // $_POST = Data is packaged inside the body of the http request
      //          MORE SECURE
      //          no data limit
      //          Cannot bookmark
      //          GET requests are not cached
      //          Better for submitting credentials

      // echo "{$_POST["username2"]} <br>";
      // echo "{$_POST["password2"]} <br>";

      $item = "pizza";
      $price = 5.99;
      $quantity = $_POST["quantity"];
      $total = null;

      $total = $quantity * $price;

      echo "You have ordered {$quantity} x {$item}'s <br>";
      echo "Your total is :  \${$total}";
?>