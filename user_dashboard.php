<?php
session_start();
include("db.php");

// Check login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Disable caching for logged-in pages
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['email'];

// Fetch user info
$userQuery = "SELECT * FROM users WHERE email='$user_email'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Fetch application info
$appQuery = "SELECT * FROM student_applications WHERE email='$user_email'";
$appResult = mysqli_query($conn, $appQuery);
$application = mysqli_fetch_assoc($appResult);

// Fetch enquiry info
$enquiryQuery = "SELECT * FROM enquiry WHERE email='$user_email' ORDER BY created_at DESC LIMIT 1";
$enquiryResult = mysqli_query($conn, $enquiryQuery);
$enquiry = mysqli_fetch_assoc($enquiryResult);

// Fetch announcements (if table exists)
$announcements = [];
$checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'announcements'");
if (mysqli_num_rows($checkTable) > 0) {
    $annQuery = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 3";
    $annResult = mysqli_query($conn, $annQuery);
    while ($row = mysqli_fetch_assoc($annResult)) {
        $announcements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - CSJM Boys Hostel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Poppins', sans-serif;
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

    <a href="user_dashboard.php" class="active">🏠 Dashboard</a>
    <a href="my_room.php">🏘 My Room</a>
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
    <h3 class="mb-4">Welcome, <?php echo htmlspecialchars($user['name']); ?> 👋</h3>

    <div class="row g-4">

        <!-- Application Status -->
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="card-title">Application Status</h5>
                <p class="mt-2">
                    <?php
                    if ($application) {
                        echo "<span class='badge bg-success'>Submitted</span>";
                    } else {
                        echo "<span class='badge bg-warning text-dark'>Not Applied</span>";
                    }
                    ?>
                </p>
            </div>
        </div>

        <!-- Room No -->
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="card-title">Room No</h5>
                <p class="mt-2">
                    <span class="fw-bold text-primary">
                        <?php echo $application['room_no'] ?? 'Not Allotted'; ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Course -->
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="card-title">Course</h5>
                <p class="mt-2 text-secondary">
                    <?php echo $application['course'] ?? 'N/A'; ?>
                </p>
            </div>
        </div>

        <!-- Enquiry -->
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5 class="card-title">Last Enquiry</h5>
                <p class="mt-2">
                    <?php
                    if ($enquiry) {
                        echo "<span class='badge bg-info'>".htmlspecialchars($enquiry['subject'])."</span>";
                    } else {
                        echo "<span class='text-muted'>No Enquiry Yet</span>";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Enquiry Details -->
    <div class="mt-5">
        <h4 class="mb-3">📨 Enquiry Status</h4>
        <div class="card p-3">
            <?php
            if ($enquiry) {
                echo "
                <p><strong>Subject:</strong> {$enquiry['subject']}</p>
                <p><strong>Message:</strong> {$enquiry['message']}</p>
                <p><small class='text-muted'>Sent on: {$enquiry['created_at']}</small></p>
                ";
            } else {
                echo "<p class='text-muted'>You haven’t submitted any enquiry yet.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Announcements -->
    <?php if (!empty($announcements)) { ?>
    <div class="mt-5">
        <h4 class="mb-3">📢 Latest Announcements</h4>
        <div class="card p-3">
            <?php
            foreach ($announcements as $a) {
                echo "<div class='mb-3'>
                        <strong>{$a['title']}</strong>
                        <br><small class='text-muted'>{$a['date']}</small>
                        <p>{$a['message']}</p>
                      </div><hr>";
            }
            ?>
        </div>
    </div>
    <?php } ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
