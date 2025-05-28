<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        echo "<h2>Thank you, $name!</h2>";
        echo "<p>We have received your message:</p>";
        echo "<blockquote>$message</blockquote>";
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>
