<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password != $confirm) {
        die("<h3 style='text-align:center;margin-top:50px;color:red;'>Passwords do not match!</h3>");
    }

    $check = mysqli_query($conn, "SELECT * FROM password_resets WHERE email='$email' AND token='$token'");
    $row = mysqli_fetch_assoc($check);

    if (!$row || strtotime($row['expires_at']) < time()) {
        die("<h3 style='text-align:center;margin-top:50px;color:red;'>Invalid or expired token!</h3>");
    }

    // Update user password (no hashing)
    mysqli_query($conn, "UPDATE users SET password='$password' WHERE email='$email'");
    mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");

    echo "<h3 style='text-align:center;margin-top:50px;color:green;'>Password reset successfully!</h3>
          <p style='text-align:center;'><a href='login.php'>Go to Login</a></p>";
}
?>
