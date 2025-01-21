# User Registration Form

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS batman2 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    nickname VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
)";

$conn->query($sql);

// Add user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    //  this work correctly 
    // $sql = "INSERT INTO batman (name, nickname, password, phone_number)
            //  VALUES ('$name', '$nickname', '$password', '$phone_number')";
    // $conn->query($sql);
    

    //  this doesn't work correctly  >>> problem solved with Mr.haghgoo
    try{
    $stmt = $conn->prepare("INSERT INTO batman2 (`name`, `nickname`, `password`, `email`, `phone_number`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss',$name, $nickname, $password, $email, $phone_number);

    // $stmt->execute([$name, $nickname, $password, $phone_number]);
    $stmt->execute();
    $stmt->close();
    } catch(Exception $e){
        echo "Error occurred during db operations: " . $e->getMessage();
    }
}

// Remove user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM Users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>

<h2>User Registration Form</h2>
<form method="post">
    Name: <input type="text" name="name" required><br>
    Nickname: <input type="text" name="nickname" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    Phone Number: <input type="text" name="phone_number" required><br>
    <input type="submit" name="add" value="Add User">
</form>

<h2>Remove User</h2>
<form method="post">
    User ID: <input type="text" name="id" required><br>
    <input type="submit" name="remove" value="Remove User">
</form>

</body>
</html>
