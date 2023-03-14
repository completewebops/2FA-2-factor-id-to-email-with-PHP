<?php
// Include the database configuration file
require_once 'config.php';

// Include the SendGrid PHP library
require_once 'vendor/autoload.php';

// Check if the email address has been submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Generate a verification code and store it in the database
    $verification_code = rand(100000, 999999);
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $query = "INSERT INTO user (email, verification_code, expires_at) VALUES ('$email', '$verification_code', '$expires_at')";
    mysqli_query($conn, $query);

    // Send the verification code to the user's email address using SendGrid
    $from = new \SendGrid\Mail\From("fromsomeone@somewhere.com", "User Validation App");
    $subject = "Verification Code for User Validation App";
    $to = new \SendGrid\Mail\To($email);
    $body = "Your verification code is: " . $verification_code;
    $content = new \SendGrid\Mail\HtmlContent($body);
    $mail = new \SendGrid\Mail\Mail($from, $to, $subject, null, $content);
    $apiKey = 'Your Sendgrind API key goes between these quotes';
    $sendgrid = new \SendGrid($apiKey);
    $response = $sendgrid->send($mail);

    // Print the response object to the screen for debugging
    print_r($response);

    // Redirect the user to the verification page
    header("Location: verify_code.php");
    exit();
}
?>
