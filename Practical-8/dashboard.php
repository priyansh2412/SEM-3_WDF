<?php
require 'db_config.php';

try {
    $stmt = $conn->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 5");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Latest Events</h2><ul>";
    foreach ($events as $event) {
        echo "<li>" . htmlspecialchars($event['title']) . " on " . $event['event_date'] . "</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "Error loading events: " . $e->getMessage();
}
?>