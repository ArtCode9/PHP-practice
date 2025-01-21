# Add and Delete Data in MySQL with PHP

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $data = $_POST['data'];
    $sql = "INSERT INTO axeart (email) VALUES ('$data')";
    $conn->query($sql);
}

// Delete Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM axeart WHERE id='$id'";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add and Delete Data</title>
</head>
<body>

<h2>Add Data</h2>
<form method="post">
    <input type="text" name="data" required>
    <button type="submit" name="add">Add</button>
</form>

<h2>Delete Data</h2>
<form method="post">
    <input type="number" name="id" required>
    <button type="submit" name="delete">Delete</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
