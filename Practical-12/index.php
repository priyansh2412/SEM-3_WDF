<?php
$dsn = "mysql:host=localhost;dbname=eventdb;charset=utf8mb4";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Add event
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO events (title, description, date, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['date'], $_POST['status']]);
    $msg = "Event added successfully!";
}

// Update event
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE events SET title=?, description=?, date=?, status=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['date'], $_POST['status'], $_POST['id']]);
    $msg = "Event updated successfully!";
}

// Delete event
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $msg = "Event deleted successfully!";
}

// Fetch events
$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE title LIKE ?");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM events");
}
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Manager</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        form { margin-bottom: 20px; }
        .msg { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Event Manager</h2>

    <?php if (isset($msg)): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Add/Update Form -->
    <form method="POST">
        <input type="hidden" name="id" value="<?= $_GET['edit_id'] ?? '' ?>">
        <input type="text" name="title" placeholder="Title" required value="<?= $_GET['edit_title'] ?? '' ?>">
        <input type="text" name="description" placeholder="Description" value="<?= $_GET['edit_desc'] ?? '' ?>">
        <input type="date" name="date" required value="<?= $_GET['edit_date'] ?? '' ?>">
        <select name="status">
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select>
        <button type="submit" name="<?= isset($_GET['edit_id']) ? 'update' : 'add' ?>">
            <?= isset($_GET['edit_id']) ? 'Update Event' : 'Add Event' ?>
        </button>
    </form>

    <!-- Search Form -->
    <form method="GET">
        <input type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Event Table -->
    <table>
        <tr><th>ID</th><th>Title</th><th>Description</th><th>Date</th><th>Status</th><th>Actions</th></tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event['id'] ?></td>
            <td><?= htmlspecialchars($event['title']) ?></td>
            <td><?= htmlspecialchars($event['description']) ?></td>
            <td><?= $event['date'] ?></td>
            <td><?= $event['status'] ?></td>
            <td>
                <a href="?edit_id=<?= $event['id'] ?>&edit_title=<?= urlencode($event['title']) ?>&edit_desc=<?= urlencode($event['description']) ?>&edit_date=<?= $event['date'] ?>">Edit</a> |
                <a href="?delete=<?= $event['id'] ?>" onclick="return confirm('Delete this event?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>