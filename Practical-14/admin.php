<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=adminpanel", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Simulate login (replace with real login logic)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'admin'; // or 'user'
}

// Restrict access
if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Delete user
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $msg = "User deleted.";
}

// Update status
if (isset($_GET['toggle'])) {
    $stmt = $pdo->prepare("UPDATE users SET status = IF(status='active','inactive','active') WHERE id=?");
    $stmt->execute([$_GET['toggle']]);
    $msg = "User status updated.";
}

// Fetch users
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .msg { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <?php if (isset($msg)) echo "<div class='msg'>$msg</div>"; ?>

    <table>
        <tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Role</th><th>Actions</th></tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['status'] ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <?php if ($user['role'] !== 'admin'): ?>
                    <a href="?toggle=<?= $user['id'] ?>">Toggle Status</a> |
                    <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                <?php else: ?>
                    <em>Admin</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>