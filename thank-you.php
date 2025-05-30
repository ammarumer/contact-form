<?php
session_start();

// Get the name from session and then clear it (optional)
$name = $_SESSION['name'] ?? 'Guest';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['name']); // optional, to avoid reuse
unset($_SESSION['message']); // optional, to avoid reuse
?>

<h2>Thank you, <?php echo $name; ?>!</h2>
<p>We have received your message:</p>
<blockquote><?php echo $message; ?></blockquote>
