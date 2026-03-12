<?php
session_start();
include('connection.php'); // connect to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // --- Validation ---
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password'); window.history.back();</script>";
        exit();
    }

    // --- Check in user table only ---
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // 🔥 ADD THIS VERIFICATION CHECK HERE
        if ($row['is_verified'] == 0) {
            echo "<script>alert('Please verify your email first! Check your inbox.'); window.history.back();</script>";
            exit();
        }

        // --- If verified → login ---
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['name'];
        $_SESSION['last_resend_time'] = $row['last_resend_time'];


        // redirect to user dashboard
        header("Location: ../user_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password!'); window.history.back();</script>";
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
