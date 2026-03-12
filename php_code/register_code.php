<?php
include('connection.php');
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $enroll = trim($_POST['enroll']);

    // --- Basic Validation ---
    if (empty($name) || empty($email) || empty($password)) {
        echo "<script>alert('Please fill all required fields'); window.history.back();</script>";
        exit();
    }

    // --- Check if email already exists ---
    $checkQuery = "SELECT * FROM users WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Email already registered! Please login.'); window.location.href='../login.php';</script>";
        exit();
    }

    // ---- Generate verification token ----
    $token = bin2hex(random_bytes(16));

    // --- Insert user (unverified) ---
    $insertQuery = "INSERT INTO users (name, email, password, enroll, verify_token, is_verified)
                    VALUES ('$name', '$email', '$password', '$enroll', '$token', 0)";

    if (mysqli_query($conn, $insertQuery)) {

        // -------- Prepare PHPMailer --------
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "brijeshverma8896@gmail.com";   // your gmail
        $mail->Password = "dydy phba cwff jwmu";          // your app password
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("brijeshverma8896@gmail.com", "CSJM Hostel");
        $mail->addAddress($email);

        // -------- Auto Detect Project Base URL (Fixes 404) --------
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];

        /* Example:
           Request URI = /php1/Hostel Management/php_code/register_code.php
           dirname(dirname()) → /php1/Hostel Management
        */
        $rootPath = dirname(dirname($_SERVER['REQUEST_URI']));

        // Final verification link
        $verifyLink = $protocol . $host . $rootPath . "/verify.php?token=$token";

        // -------- Email Template --------
        $mail->isHTML(true);
        $mail->Subject = "Verify Your Email - CSJM Hostel";
        $year = date("Y");

        $mail->Body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body { margin:0; padding:0; background:#f2f2f2; font-family:Arial, sans-serif; }
        .card { max-width:550px; margin:30px auto; background:#ffffff; border-radius:10px; 
                overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .header { background:#007bff; padding:20px; text-align:center; color:#fff; font-size:22px; }
        .content { padding:25px; color:#333; }
        .btn { background:#007bff; padding:12px 25px; color:#fff; text-decoration:none; 
               font-weight:600; border-radius:6px; display:inline-block; }
        .footer { background:#f0f0f0; padding:15px; text-align:center; font-size:12px; color:#888; }
        .muted { color:#666; font-size:14px; line-height:1.6; }
        .link { word-break:break-all; color:#444; font-size:14px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">CSJM Boys Hostel</div>

        <div class="content">
            <h2>Hello {$name},</h2>

            <p class="muted">
                Thank you for registering at <strong>CSJM Boys Hostel</strong>.<br>
                Please verify your email to activate your account.
            </p>

            <div style="text-align:center; margin:30px 0;">
                <a href="{$verifyLink}" class="btn">Verify Email</a>
            </div>

            <p class="muted">If the button does not work, use this link:</p>

            <p class="link">{$verifyLink}</p>

            <p class="muted">
                If you did not request this, please ignore this message.
            </p>

            <p style="margin-top:30px;">
                Regards,<br>
                <strong>CSJM Hostel Team</strong>
            </p>
        </div>

        <div class="footer">© {$year} CSJM Hostel — All Rights Reserved.</div>
    </div>
</body>
</html>
HTML;

        // -------- Send Email --------
        $mail->send();

        echo "<script>alert('Account created! Please verify your email before login.'); window.location.href='../login.php';</script>";
    } 
    else {
        echo "<script>alert('Error: Unable to create account.'); window.history.back();</script>";
    }

} 
else {
    header("Location: ../login.php");
    exit();
}
?>
