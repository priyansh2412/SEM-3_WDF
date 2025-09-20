<?php
// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $age = intval($_POST["age"]);

    // Validate required fields
    if (!empty($name) && !empty($email)) {
        // Store data in a file
        $data = "$name, $email, $age\n";
        file_put_contents("registrations.txt", $data, FILE_APPEND);

        // Success response
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Thank you, $name. Your data has been saved.</p>";
    } else {
        // Error response
        echo "<h2>Error: Missing required fields.</h2>";
    }
} else {
    echo "<h2>Invalid Request Method</h2>";
}
?>