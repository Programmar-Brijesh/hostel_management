<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin_email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Hostel Management</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #001f3f, #00509e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            text-align: center;
        }
        .login-card h3 {
            font-weight: 600;
            margin-bottom: 25px;
            color: #001f3f;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-login {
            background-color: #00509e;
            color: white;
            border-radius: 10px;
            transition: 0.3s;
            font-weight: 500;
        }
        .btn-login:hover {
            background-color: #003f7d;
        }
        .error-message {
            color: #e63946;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .footer-text {
            font-size: 0.85rem;
            color: #555;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3>Admin Login</h3>
    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>
        <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" name="login" class="btn btn-login w-100 mt-2">Login</button>
    </form>
    <div class="footer-text mt-3">
        © <?php echo date("Y"); ?> Hostel Management | Admin Panel
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
