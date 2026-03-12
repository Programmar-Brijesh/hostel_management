<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch latest leave request
$query2 = "SELECT * FROM leave_requests WHERE email='$email' ORDER BY id DESC LIMIT 1";
$latest = mysqli_query($conn, $query2);
$last_leave = mysqli_fetch_assoc($latest);
?>

<!DOCTYPE html>
<html>
<head>
<title>Leave Request - CSJM Hostel</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar.css">

<style>
body { background: #f4f7fa;
font-family: 'Poppins', sans-serif;
}

.main-content { margin-left:250px; padding:30px; }
.card { border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.15); }

.status-box {
    border-left: 6px solid #0d6efd;
    background: #eef5ff;
    padding: 15px;
    border-radius: 10px;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>👨‍🎓 CSJM Hostel</h4>
    <a href="user_dashboard.php">🏠 Dashboard</a>
    <a href="my_room.php">🏘 My Room</a>
    <a href="my_application.php">🧾 My Application</a>
    <a href="leave_request.php" class="active">🧾 Apply Leave</a>
    <a href="maintenance.php">🧰 Maintenance</a>
    <a href="announcements.php">📢 Announcements</a>
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main -->
<div class="main-content">

<h3 class="mb-4">📝 Apply for Leave</h3>

<!-- Show Status Box -->
<?php if ($last_leave) { ?>

    <?php
        if ($last_leave['status'] == "Approved") {
            $badge = '<span class="badge bg-success px-3 py-2">🟢 Approved</span>';
        } elseif ($last_leave['status'] == "Rejected") {
            $badge = '<span class="badge bg-danger px-3 py-2">🔴 Rejected</span>';
        } else {
            $badge = '<span class="badge bg-warning text-dark px-3 py-2">🟡 Pending</span>';
        }
    ?>

    <div class="status-box mb-4">
        <h5 class="fw-bold">📊 Latest Leave Request Status</h5>
        <p><strong>Status:</strong> <?php echo $badge; ?></p>
        <p><strong>Reason:</strong> <?php echo $last_leave['reason']; ?></p>
        <p><strong>From:</strong> <?php echo $last_leave['from_date']; ?></p>
        <p><strong>To:</strong> <?php echo $last_leave['to_date']; ?></p>
        <p><strong>Applied On:</strong> <?php echo $last_leave['created_at']; ?></p>
    </div>

<?php } else { ?>

    <div class="alert alert-info">You haven't applied for any leave yet.</div>

<?php } ?>

<!-- Leave Request Form -->
<div class="card p-4">
    <form action="submit_leave.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Leave Reason</label>
            <textarea name="reason" class="form-control" rows="3" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Leave Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Leave End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">📤 Submit Leave Request</button>
    </form>
</div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
