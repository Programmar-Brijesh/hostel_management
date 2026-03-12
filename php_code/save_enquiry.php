<?php
include("connection.php"); // ✅ make sure this file connects to your DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO enquiry (full_name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Thank you for contacting us! Your message has been received.');
                window.location.href='../contact.php';
              </script>";
    } else {
        echo "<script>
                alert('Error submitting your message. Please try again.');
                window.location.href='../contact.php';
              </script>";
    }
}
?>
