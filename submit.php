<?php
session_start(); // needed to use $_SESSION
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Composer autoload
$config = require 'config.php'; // Load credentials

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

        // Send Email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();

            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password']; // not your Gmail login!
            $mail->SMTPSecure = 'tls';
            $mail->Port = $config['port'];

            // === Email to Admin ===
            $mail->setFrom($config['from_email'], 'Contact Form');
            $mail->addAddress($config['from_email']); // receiver
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Name: $name\nEmail: $email\nMessage:\n$message";
            $mail->send();

            // === Confirmation Email to Visitor ===
            $mail->clearAllRecipients();
            $mail->addAddress($email); // Visitor's email
            $mail->Subject = 'Thanks for contacting us!';
            $mail->Body    = "Hi $name,\n\nThanks for reaching out! We'll respond shortly.\n\nYou wrote:\n$message";
            $mail->send();


            header("Location: thank-you.php");
            exit;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Mailer Error: " . $mail->ErrorInfo . "</p>";
        }

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

