<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $age = intval($_POST["age"]);

    // Validate required fields
    if (!empty($name) && !empty($email)) {
        // Format as CSV
        $entry = "$name,$email,$age\n";

        // Write to file
        file_put_contents("data.txt", $entry, FILE_APPEND);

        // Confirmation message
        echo "<h2>Submission Successful!</h2>";
        echo "<p>Thank you, $name. Your data has been saved.</p>";
    } else {
        echo "<h2>Error: Missing required fields.</h2>";
    }
} else {
    echo "<h2>Invalid Request Method</h2>";
}
?>