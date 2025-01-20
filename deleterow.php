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



// SQL to delete a record
$sql = "DELETE FROM axeart WHERE id = 9";
$stmt = $conn->prepare($sql);
// $stmt->bind_param("id", $id);

// Set the id of the record to be deleted
$id = 9;

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
