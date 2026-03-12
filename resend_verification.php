<?php
session_start();
include("php_code/connection.php");

// If user submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "<script>alert('Please enter your email'); window.history.back();</script>";
        exit();
    }

    // Check if user exists
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Email not found! Please register first.'); window.location.href='register.php';</script>";
        exit();
    }

    $user = mysqli_fetch_assoc($result);

    // Already verified?
    if ($user['is_verified'] == 1) {
        echo "<script>alert('Your email is already verified!'); window.location.href='login.php';</script>";
        exit();
    }

    // ---------- 2-MINUTE RESEND COOLDOWN ----------
    $currentTime = time();
    $lastSent = $user['last_resend_time'];
    $cooldown = 120; // 2 minutes

    if ($currentTime - $lastSent < $cooldown) {
        $remaining = $cooldown - ($currentTime - $lastSent);
        echo "<script>alert('Please wait {$remaining} seconds before resending again.'); window.location.href='login.php';</script>";
        exit();
    }
    // ------------------------------------------------

    // Use existing token, or create new if missing
    if (empty($user['verify_token'])) {
        $token = bin2hex(random_bytes(16));
        mysqli_query($conn, "UPDATE users SET verify_token='$token' WHERE email='$email'");
    } else {
        $token = $user['verify_token'];
    }

    // Prepare PHPMailer again
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "youremail@gmail.com";
    $mail->Password = "app password";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("youremail@gmail.com", "CSJM Hostel");
    $mail->addAddress($email);

    // Build verify URL dynamically
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];

    // Root folder path auto-detect
    $rootPath = dirname($_SERVER['REQUEST_URI']);
    $verifyLink = $protocol . $host . "/php1/Hostel%20Management/verify.php?token=$token";

    // Email Body
    $year = date("Y");
    $mail->isHTML(true);
    $mail->Subject = "Resend Verification Email - CSJM Hostel";

    $mail->Body = <<<HTML
<!DOCTYPE html>
<html>
<body>
    <h2>Verify Your Email</h2>
    <p>Hello {$user['name']},</p>
    <p>Click the button below to verify your email:</p>
    <p><a href="{$verifyLink}" style="padding:10px 15px; background:#007bff; color:white; text-decoration:none;">Verify Email</a></p>
    <p>If the button does not work, use this link: <br> {$verifyLink}</p>
    <br>
    <p>© {$year} CSJM Hostel Team</p>
</body>
</html>
HTML;

    $mail->send();

    // ---------- Update last resend timestamp ----------
    $now = time();
    mysqli_query($conn, "UPDATE users SET last_resend_time='$now' WHERE email='$email'");
    // --------------------------------------------------

    echo "<script>alert('Verification email has been resent! Check your inbox.'); window.location.href='login.php';</script>";
    exit();
}
?>

<!-- HTML Form for entering email -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Verification Email | CSJM Boys Hostel</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        /* Background Image */
        body {
            margin: 0;
            padding: 0;
            background: url('images/bg.png') no-repeat center center fixed;
            background-size: cover;
            font-family: "Poppins", sans-serif;
        }

        /* Blur Overlay */
        .blur-overlay {
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            width: 100%;
            backdrop-filter: blur(7px);
        }

        /* Navbar */
        .navbar {
            background: rgba(13, 110, 253, 0.85) !important;
            backdrop-filter: blur(10px);
        }

        .navbar-brand img {
            width: 45px;
            height: 45px;
            margin-right: 10px;
            border-radius: 50%;
        }

        /* Card */
        .resend-card {
            max-width: 480px;
            margin: 120px auto;
            padding: 35px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.20);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            color: #fff;
        }

        .resend-card h2 {
            font-weight: 600;
            text-align: center;
            color: #fff;
        }

        .resend-card p {
            text-align: center;
            font-size: 14px;
            color: #eee;
        }

        /* Inputs */
        .form-control {
            background: rgba(255,255,255,0.6);
            border: none;
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: none;
            border: 1px solid #0d6efd;
        }

        /* Button */
        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: #084dbf;
        }

        footer {
            text-align: center;
            margin-top: 15px;
            color: #fff;
        }

        footer a {
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- Blur overlay -->
    <div class="blur-overlay"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark position-relative">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="your-logo.png" alt="Hostel Logo">
                <span class="fw-bold">CSJM Boys Hostel</span>
            </a>

            <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Card -->
    <div class="container position-relative">
        <div class="resend-card">
            <h2 class="text-dark" >Resend Verification Email</h2>
            <p class="text-dark" >Enter your registered email and we will send you the verification link again.</p>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-dark">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                </div>

                <button type="submit" class="btn btn-primary w-100">Send Again</button>
            </form>
        </div>

        <footer>
            Back to <a href="login.php">Login</a>
        </footer>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

