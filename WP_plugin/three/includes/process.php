<?php
require_once 'config.php';

// Create or Update User
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $family = $_POST['family'];
    $phone = $_POST['phone'];

    try {
        if (empty($id)) {
            // Create new user
            $stmt = $pdo->prepare("INSERT INTO axe (name, family, phone) VALUES (?, ?, ?)");
            $stmt->execute([$name, $family, $phone]);
            $_SESSION['message'] = "User created successfully!";
        } else {
            // Update existing user
            $stmt = $pdo->prepare("UPDATE axe SET name = ?, family = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $family, $phone, $id]);
            $_SESSION['message'] = "User updated successfully!";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: user-ui.php");
    exit();
}

// Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM axe WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['message'] = "User deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: user-ui.php");
    exit();
}

// Redirect if no action matched
header("Location: user-ui.php");
exit();
?>