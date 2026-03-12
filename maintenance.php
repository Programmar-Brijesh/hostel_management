<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['email'];

/* -----------------------------
    Insert Maintenance Request
------------------------------*/
if (isset($_POST['submit_request'])) {
    $room_no     = mysqli_real_escape_string($conn, $_POST['room_no']);
    $issue_type  = mysqli_real_escape_string($conn, $_POST['issue_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $insert = "INSERT INTO maintenance_requests (email, room_no, issue_type, description) 
               VALUES ('$user_email', '$room_no', '$issue_type', '$description')";
    mysqli_query($conn, $insert);

    $msg = "Maintenance request submitted successfully!";
}

/* -----------------------------
    Fetch User Requests
------------------------------*/
$query  = "SELECT * FROM maintenance_requests WHERE email='$user_email' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

/* -----------------------------
    Function: Status Colors
------------------------------*/
function statusColor($status) {
    return match($status) {
        'Pending'     => 'warning text-dark',
        'Approved'    => 'primary',
        'Rejected'    => 'danger',
        'Completed'   => 'success',
        'Resolved'    => 'info',
        default       => 'secondary'
    };
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Maintenance - CSJM Boys Hostel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <a href="my_room.php">🏘 My Room</a>
    <a href="my_application.php">🧾 My Application</a>
    <a href="leave_request.php">🧾 Apply Leave</a>
    <a href="maintenance.php" class="active">🧰 Maintenance</a>
    <a href="announcements.php">📢 Announcements</a>
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">

    <h3 class="mb-4">🧰 Maintenance Requests</h3>

    <?php if (isset($msg)) { ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php } ?>

    <!-- Maintenance Request Form -->
    <div class="card p-4 mb-4">
        <h5 class="card-title mb-3">Submit a Maintenance Request</h5>

        <form method="POST">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Room No.</label>
                    <input type="text" name="room_no" class="form-control" placeholder="Enter your room number" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Issue Type</label>
                    <select name="issue_type" class="form-select" required>
                        <option value="">-- Select Issue --</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Describe the issue" required></textarea>
                </div>

                <div class="col-md-12 text-end">
                    <button type="submit" name="submit_request" class="btn btn-primary mt-2">
                        Submit Request
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Maintenance History -->
    <div class="card p-4">
        <h5 class="card-title mb-3">Your Maintenance Requests</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Room No</th>
                        <th>Issue Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Requested On</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['room_no'] ?></td>
                            <td><?= $row['issue_type'] ?></td>
                            <td><?= $row['description'] ?></td>

                            <td>
                                <span class="badge bg-<?= statusColor($row['status']) ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>

                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No maintenance requests found.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
