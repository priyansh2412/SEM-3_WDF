<?php
require 'db_config.php';

$id = $_POST['id'];
$title = $_POST['title'];
$date = $_POST['date'];

try {
    $stmt = $conn->prepare("UPDATE events SET title = ?, event_date = ? WHERE id = ?");
    $stmt->execute([$title, $date, $id]);
    echo "Event updated!";
} catch (PDOException $e) {
    echo "Update failed: " . $e->getMessage();
}
?>