<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sanitize & validate</title>
   <style>
         body{
            text-align: center;
            padding: 14px;
            margin: 8px;
         }
   </style>
</head>
<body>
            <form action="17_sanitizeAndValidate.php" method="post">
                     username:<br>
                     <input type="text" name="username"><br>
                     age:<br>
                     <input type="text" name="age"><br>
                     email:<br>
                     <input type="text" name="email"><br>
                     <input type="submit" name="login" value="login"><br>
            </form>
</body>
</html>
<?php 
      if(isset($_POST["login"])){
            // validate::
            $age = filter_input(INPUT_POST, "age", FILTER_VALIDATE_INT);

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            if(empty($email)){
               echo "that email wasn't valid";
            }else{
               echo "You'r email is: {$email}";
            }

            //   Sanitize::
            // $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

            // $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);

            // $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

            // echo "Your email is {$email}";
      };



?>