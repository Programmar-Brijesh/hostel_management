<?php
include("db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if email exists in signup table
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) == 0) {
        echo "This email is not registered.";
        exit;
    }

    // Create reset token (no hashing, as you requested)
    $token = uniqid() . time();
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Store token
    mysqli_query($conn, "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires')");

    // Create reset link
    $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset.php?token=$token&email=$email";
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '##@gmail.com';     // your Gmail
        $mail->Password = 'app password';       // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'CSJM Boys Hostel');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "
            <h3>Reset Your Password</h3>
            <p>Click the link below to reset your password:</p>
            <a href='$reset_link'>Reset Password</a>
            <p>This link expires in 1 hour.</p>
        ";

        $mail->send();
        echo "A reset link has been sent to your email.";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
?>
