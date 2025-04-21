
<?php
  require_once 'config.php';

// Check for edit request
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM axe WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        $_SESSION['error'] = "User not found!";
        header("Location: index.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Management</title>
   <style>
      body { font-family: Arial, Helvetica, sans-serif; margin: 20px;}
      table { width: 100%; border-collapse: collapse;}
      th, td { padding: 9px; text-align: left; border-bottom: 2px solid #ddd;}
      form { margin-bottom: 20px; background: #f9f9f9; padding: 20px;}
      input, button { padding: 8px; margin: 5px 0; }
      button { cursor: pointer;}
   </style>
</head>
<body>
   <h1>User Management</h1>

   <?php if (isset($_SESSION['message'])): ?>
        <div style="color: green; margin: 10px 0;"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red; margin: 10px 0;"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

   <!-- Create/update form -->
   <form action="process.php" method="post">
      <input type="hidden" name="id" value="<?= isset($user['id']) ? $user['id'] : '' ?>">

      <label>Name:</label>
        <input type="text" name="name" required 
               value="<?= isset($user['name']) ? $user['name'] : '' ?>">

      <label>Family:</label>
      <input type="text" name="family" required 
               value="<?= isset($user['family']) ? $user['family'] : '' ?>">
               
      <label>Phone:</label>
      <input type="text" name="phone" required 
               value="<?= isset($user['phone']) ? $user['phone'] : '' ?>">

      <button type="submit" name="save">Save</button>
      <?php if(isset($user['id'])): ?>
            <a href="user-ui.php">Cancel</a>
      <?php endif; ?>
   </form>


   <!-- Users List -->
   <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Family</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM axe ORDER BY id DESC");
            while ($row = $stmt->fetch()):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['family'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td>
                    <a href="user-ui.php?edit=<?= $row['id'] ?>">Edit</a>
                    <a href="process.php?delete=<?= $row['id'] ?>" 
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>




</body>
</html>