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

// 🧩 Fetch user's name (for saving in enquiry)
$nameQuery = "SELECT name FROM users WHERE email='$user_email'";
$nameResult = mysqli_query($conn, $nameQuery);
$userData = mysqli_fetch_assoc($nameResult);
$full_name = $userData['name'] ?? 'Unknown';

// 🗑 Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $deleteQuery = "DELETE FROM enquiry WHERE id='$delete_id' AND email='$user_email'";
    if (mysqli_query($conn, $deleteQuery)) {
        $msg = "Enquiry deleted successfully!";
    } else {
        $msg = "Error deleting enquiry. Try again.";
    }
}

// 📨 Handle New Enquiry Submission
if (isset($_POST['submit_enquiry'])) {
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert = "INSERT INTO enquiry (full_name, email, subject, message)
               VALUES ('$full_name', '$user_email', '$subject', '$message')";
    mysqli_query($conn, $insert);
    $msg = "Your enquiry has been sent successfully!";
}

// Fetch all user enquiries
$query = "SELECT * FROM enquiry WHERE email='$user_email' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enquiry Status - CSJM Boys Hostel</title>
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
    <a href="maintenance.php">🧰 Maintenance</a>
    <a href="announcements.php">📢 Announcements</a>
    <a href="enquiry_status.php" class="active">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">📨 Enquiry Status</h3>

    <?php if (isset($msg)) { ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php } ?>

    <!-- Enquiry Form -->
    <div class="card p-4 mb-4">
        <h5 class="card-title mb-3">Submit New Enquiry</h5>
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="Enter enquiry subject" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Write your enquiry message" required></textarea>
                </div>
                <div class="col-md-12 text-end">
                    <button type="submit" name="submit_enquiry" class="btn btn-primary mt-2">Send Enquiry</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Enquiry List -->
    <div class="card p-4">
        <h5 class="card-title mb-3">Your Enquiries</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['subject']}</td>
                                <td>{$row['message']}</td>
                                <td><span class='badge bg-warning text-dark'>Pending</span></td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='enquiry_status.php?delete_id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this enquiry?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted'>No enquiries found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
