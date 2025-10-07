<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "studentdb";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Insert student
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("INSERT INTO students (name, age, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $age, $email);
    $stmt->execute();
    $stmt->close();
}

// Delete student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
}

// Search
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = $conn->query("SELECT * FROM students WHERE name LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM students");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Manager</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Student Manager</h2>

    <!-- Add Student Form -->
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="add">Add Student</button>
    </form>

    <!-- Search Form -->
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Student Table -->
    <table>
        <tr><th>ID</th><th>Name</th><th>Age</th><th>Email</th><th>Action</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>