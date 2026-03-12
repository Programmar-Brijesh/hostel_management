<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Disable caching for logged-in pages
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['email'];

// Fetch student and room info
$query = "SELECT * FROM student_applications WHERE email='$user_email'";
$result = mysqli_query($conn, $query);
$application = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Room - CSJM Boys Hostel</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar.css">
<style>
body {
    background-color: #f4f7fa;
    font-family: 'Poppins', sans-serif;
}
.main-content {
    margin-left: 250px;
    padding: 30px;
}
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
.card-title {
    font-size: 18px;
    font-weight: 600;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>👨‍🎓 CSJM Hostel</h4>
    <a href="user_dashboard.php">🏠 Dashboard</a>
    <a href="my_room.php" class="active">🏘 My Room</a>
    <a href="my_application.php">🧾 My Application</a>
    <a href="leave_request.php">🧾 Apply Leave</a>
    <a href="maintenance.php">🧰 Maintenance</a>
    <a href="announcements.php">📢 Announcements</a>
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">🏘 My Room Details</h3>

    <?php if ($application && !empty($application['room_no'])) { ?>
    <div class="card p-4">
        <div class="row mb-3">
            <div class="col-md-4">
                <h5 class="card-title">Room Number:</h5>
                <p class="fw-bold text-primary"><?php echo $application['room_no']; ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="card-title">Block:</h5>
                <p><?php echo $application['block'] ?? 'A'; ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="card-title">Floor:</h5>
                <p><?php echo $application['floor'] ?? '1st'; ?></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h5 class="card-title">Bed Type:</h5>
                <p><?php echo $application['bed_type'] ?? 'Single Bed'; ?></p>
            </div>
            <div class="col-md-6">
                <h5 class="card-title">Room Status:</h5>
                <span class="badge bg-success">Occupied</span>
            </div>
        </div>

        <hr>
        <div class="mt-3">
            <h5 class="card-title">Roommates:</h5>
            <ul>
                <li><?php echo $application['name']; ?> (You)</li>
                <li>—</li>
                <li>—</li>
            </ul>
        </div>
    </div>

    <?php } else { ?>
    <div class="alert alert-warning">
        You have not been allotted any room yet. Please wait for hostel management to assign your room.
    </div>
    <?php } ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
