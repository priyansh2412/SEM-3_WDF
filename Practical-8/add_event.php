<?php
require 'db_config.php';

$title = $_POST['title'];
$date = $_POST['date'];

try {
    $stmt = $conn->prepare("INSERT INTO events (title, event_date) VALUES (?, ?)");
    $stmt->execute([$title, $date]);
    echo "Event added successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>