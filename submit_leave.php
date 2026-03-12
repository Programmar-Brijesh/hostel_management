<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch name & room number from student_applications
$getInfo = "SELECT name, room_no FROM student_applications WHERE email='$email'";
$resultInfo = mysqli_query($conn, $getInfo);
$userInfo = mysqli_fetch_assoc($resultInfo);

// If no record found
if (!$userInfo) {
    echo "<script>alert('Error: No application found for this user.'); 
          window.location='leave_request.php';</script>";
    exit();
}

$name = $userInfo['name'];
$room_no = $userInfo['room_no'];

// Escape user input
$reason = mysqli_real_escape_string($conn, $_POST['reason']);
$start = $_POST['start_date'];
$end = $_POST['end_date'];

// Insert into leave_requests table
$sql = "INSERT INTO leave_requests (email, name, room_no, reason, from_date, to_date)
        VALUES ('$email', '$name', '$room_no', '$reason', '$start', '$end')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Leave request submitted successfully!'); 
          window.location='leave_request.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
