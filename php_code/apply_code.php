<?php
// Database connection
include('connection.php');

// Get form data
$name = $_POST['name'];
$enroll = $_POST['enroll'];
$course = $_POST['course'];
$year = $_POST['year'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$guardianContact = $_POST['guardianContact'];
$address = $_POST['address'];

// File upload section
$photo_name = $_FILES['photo']['name'];
$photo_tmp = $_FILES['photo']['tmp_name'];
$photo_error = $_FILES['photo']['error'];
$photo_size = $_FILES['photo']['size'];

$upload_folder = "../uploads/";

// Create folder if it doesn't exist
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0777, true);
}

// Generate unique filename (example: rollnumber_173139.png)
$ext = pathinfo($photo_name, PATHINFO_EXTENSION);
$new_name = $enroll . "_" . time() . "." . $ext;
$photo_path = $upload_folder . $new_name;

if ($photo_error === 0) {
    if (move_uploaded_file($photo_tmp, $photo_path)) {
        // Insert into database
        $sql = "INSERT INTO student_applications (name, enroll, course, year, email, mobile, guardian_contact, address, photo)
                VALUES ('$name', '$enroll', '$course', '$year', '$email', '$mobile', '$guardianContact', '$address', '$photo_path')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Application submitted successfully with photo!'); window.location='../index.php';</script>";
        } else {
            echo "Database Insert Error: " . mysqli_error($conn);
        }
    } else {
        echo "⚠️ File Move Error: Could not move uploaded file. Check folder permissions.";
    }
} else {
    echo "⚠️ Upload Error: " . $photo_error . "<br>Try again with a smaller file.";
}

mysqli_close($conn);
?>
