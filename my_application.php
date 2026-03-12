<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['email'];

// Fetch application
$query = "SELECT * FROM student_applications WHERE email='$user_email'";
$result = mysqli_query($conn, $query);
$app = mysqli_fetch_assoc($result);

// Fix photo path
$photo = str_replace("../", "", $app['photo']);
if (!file_exists($photo)) {
    $photo = "uploads/default.png";
}

// Set Status Badge
$status = $app['status'];

if ($status === "Approved") {
    $badge = '<span class="badge bg-success px-3 py-2">🟢 Approved</span>';
} elseif ($status === "Rejected") {
    $badge = '<span class="badge bg-danger px-3 py-2">🔴 Rejected</span>';
} else {
    $badge = '<span class="badge bg-warning text-dark px-3 py-2">🟡 Pending</span>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Application - CSJM Boys Hostel</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar.css">

<style>
body { background: #f4f7fa;
font-family: 'Poppins', sans-serif;
}

.card {
    border: none; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.detail-text {
    margin: 0; color: #555; word-wrap: break-word;
}
.profile-photo-small {
    width: 150px; height: 150px; border-radius: 10px; object-fit: cover;
    border: 3px solid #0d6efd; cursor: pointer;
}
.modal-img-large {
    width: 100%; border-radius: 10px;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>👨‍🎓 CSJM Hostel</h4>
    <a href="user_dashboard.php">🏠 Dashboard</a>
    <a href="my_room.php">🏘 My Room</a>
    <a href="my_application.php" class="active">🧾 My Application</a>
    <a href="leave_request.php">🧾 Apply Leave</a>
    <a href="maintenance.php">🧰 Maintenance</a>
    <a href="announcements.php">📢 Announcements</a>
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main -->
<div class="main-content">

<h3 class="mb-4">🧾 My Application</h3>

<?php if ($app) { ?>

<div class="card p-4">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Application Details</h4>
    </div>

    <!-- Top Info -->
    <div class="row g-3 mb-4">

        <!-- Photo -->
        <div class="text-center mt-3">
        <img src="<?php echo $photo; ?>" 
             class="profile-photo-small shadow"
             data-bs-toggle="modal" data-bs-target="#photoModal">
        </div>

        <div class="col-md-4">
            <strong>👤 Full Name:</strong>
            <p class="detail-text"><?php echo $app['name']; ?></p>
        </div>

        <div class="col-md-4">
            <strong>📧 Email:</strong>
            <p class="detail-text"><?php echo $app['email']; ?></p>
        </div>

        <div class="col-md-4">
            <strong>📘 Enrollment No:</strong>
            <p class="detail-text"><?php echo $app['enroll']; ?></p>
        </div>
    </div>

    <!-- Course Details -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <strong>📚 Course:</strong>
            <p class="detail-text"><?php echo $app['course']; ?></p>
        </div>

        <div class="col-md-4">
            <strong>🎓 Year:</strong>
            <p class="detail-text"><?php echo $app['year']; ?></p>
        </div>

        <div class="col-md-4">
            <strong>📞 Mobile:</strong>
            <p class="detail-text"><?php echo $app['mobile']; ?></p>
        </div>
    </div>

    <!-- Other Details -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <strong>👨‍👦 Guardian Contact:</strong>
            <p class="detail-text"><?php echo $app['guardian_contact']; ?></p>
        </div>

        <div class="col-md-8">
            <strong>🏠 Address:</strong>
            <p class="detail-text"><?php echo $app['address']; ?></p>
        </div>
    </div>
    
</div>

<?php } else { ?>
<div class="alert alert-warning mt-4">
    ⚠ You haven’t submitted any hostel application yet.
</div>
<?php } ?>

</div>

<!-- Modal for Large Photo -->
<div class="modal fade" id="photoModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-2">
      <img src="<?php echo $photo; ?>" class="modal-img-large">
    </div>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
