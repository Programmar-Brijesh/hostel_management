<?php
include("db.php");

if (isset($_GET['token'])) {

    $token = $_GET['token'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE verify_token='$token' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {

        mysqli_query($conn, "UPDATE users SET is_verified=1, verify_token=NULL WHERE verify_token='$token'");

        echo "<script>alert('Email verified successfully! You can now login.'); window.location.href='login.php';</script>";

    } else {
        echo "Invalid or expired token!";
    }
}
?>
