
<?php
    echo"Helooooooo";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Form</title>
</head>
<body>
    <form action="submit.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

        <label>Gender:</label><br>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label><br><br>

        <label for="hobbies">Hobbies:</label><br>
        <input type="checkbox" id="reading" name="hobbies[]" value="reading">
        <label for="reading">Reading</label><br>
        <input type="checkbox" id="traveling" name="hobbies[]" value="traveling">
        <label for="traveling">Traveling</label><br>
        <input type="checkbox" id="gaming" name="hobbies[]" value="gaming">
        <label for="gaming">Gaming</label><br><br>

        <input type="submit" value="Submit">
    </form>

   </body>
</html>

