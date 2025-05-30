<?php
session_start(); // needed to use $_SESSION
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign inputs
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Initialize error array
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    // Validate message
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are no errors, continue
    if (empty($errors)) {
        // Optionally: log the data to a file or DB here
        // Data to be saved
        $data = [$name, $email, $message, date('Y-m-d H:i:s')];

        // File path
        $file = 'submissions.csv';

        // Open the file for appending
        $handle = fopen($file, 'a');
        if ($handle) {
            fputcsv($handle, $data);  // Write the data to the CSV
            fclose($handle);
        } else {
            echo "<p style='color:red;'>Failed to write to file.</p>";
            exit;
        }
        // Store it in the session temporarily
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['message'] = $message;
        // Redirect to thank you page
        header("Location: thank-you.php");
        exit;
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<p><a href='index.html'>Go back</a></p>";
    }
} else {
    // Not a POST request
    header("Location: index.html");
    exit;
}
?>

