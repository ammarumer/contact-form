<?php
session_start(); // needed to use $_SESSION
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Composer autoload
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
            $mail->Host = 'smtp.mailersend.net';
            //$mail->Host = 'smtp.elasticemail.com';
            //$mail->Host = 'smtp.resend.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'MS_kyXSre@test-68zxl27pz5e4j905.mlsender.net'; // same as the email you verified
            //$mail->Username = 'resend'; // same as the email you verified
           // $mail->Password = 'F237F1FB209013DB20B70706E8B632D8D218';             // from API Key step
            $mail->Password = 'mssp.gNSZTDH.0r83ql3vk1zgzw1j.KtoJBYO';             // from API Key step
            //$mail->Password = 're_7NLw4uco_86T7kLG9YgMxXbBsCfiaoy7b';             // from API Key step
            $mail->SMTPSecure = 'tls';
            //$mail->Port = 587;
            $mail->Port = 587;
//            // Email content
           $mail->setFrom('MS_kyXSre@test-68zxl27pz5e4j905.mlsender.net', 'Contact Form');
//            $mail->addAddress('ammaumer007@gmail.com'); // receiver
//            $mail->Subject = 'New Contact Form Submission';
//            $mail->Body    = "Name: $name\nEmail: $email\nMessage:\n$message";

            //$mail->send();

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


//        // Redirect to thank you page
//        header("Location: thank-you.php");
//        exit;
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

