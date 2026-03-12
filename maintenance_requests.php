<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/* Handle Actions */
if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "approve") {
        mysqli_query($conn, "UPDATE maintenance_requests SET status='Approved' WHERE id=$id");
    }
    elseif ($action == "reject") {
        mysqli_query($conn, "UPDATE maintenance_requests SET status='Rejected' WHERE id=$id");
    }
    elseif ($action == "complete") {
        mysqli_query($conn, "UPDATE maintenance_requests SET status='Completed' WHERE id=$id");
    }

    echo "<script>alert('Status updated successfully!'); window.location='maintenance_requests.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Maintenance Requests | Admin Dashboard</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f8f9fa; }
.sidebar { background:#111827; min-height:100vh; color:white; }
.sidebar a { color:#cbd5e1; text-decoration:none; display:block; padding:12px 20px; border-radius:8px; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:white; }

.topbar { background:white; padding:12px 25px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
.card-custom { border-radius:12px; box-shadow:0 3px 8px rgba(0,0,0,0.1); }

.status-badge {
    padding:6px 10px; border-radius:6px; color:white; font-size:13px;
}
.bg-approved { background:#16a34a; }
.bg-rejected { background:#dc2626; }
.bg-completed { background:#2563eb; }
.bg-pending { background:#facc15; color:black; }
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->
<div class="col-md-2 sidebar p-3">
    <h4 class="text-center mb-4">🏠 Hostel Admin</h4>

    <a href="admin_dashboard.php"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
    <a href="students.php"><i class="fa-solid fa-users me-2"></i>Students</a>
    <a href="room_data.php"><i class="fa-solid fa-bed me-2"></i>Rooms</a>
    <a href="leaves.php"><i class="fa-solid fa-plane-departure me-2"></i>Leave Requests</a>
    <a href="maintenance_requests.php" class="active"><i class="fa-solid fa-triangle-exclamation me-2"></i>Complaints</a>
    <a href="fees.php"><i class="fa-solid fa-money-bill me-2"></i>Fees</a>
    <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
    <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
    <a href="admin_profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
    <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="col-md-10">

    <div class="topbar d-flex justify-content-between align-items-center">
        <h4>Maintenance Requests</h4>
        <div>Welcome, <?= $_SESSION['admin_name'] ?? "Admin"; ?> 👋</div>
    </div>

    <div class="container mt-4">

        <h5 class="text-primary mb-3"><i class="fa-solid fa-circle-exclamation me-2"></i>Pending Requests</h5>

        <div class="card card-custom p-3 mb-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Issue</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $pending = mysqli_query($conn, "SELECT * FROM maintenance_requests WHERE status='Pending' ORDER BY id DESC");

                    if (mysqli_num_rows($pending) > 0) {
                        while ($row = mysqli_fetch_assoc($pending)) {

                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['room_no']}</td>
                                <td>{$row['issue_type']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='maintenance_requests.php?action=approve&id={$row['id']}' class='btn btn-success btn-sm me-1'>Approve</a>
                                    <a href='maintenance_requests.php?action=reject&id={$row['id']}' class='btn btn-danger btn-sm me-1'>Reject</a>
                                    <a href='maintenance_requests.php?action=complete&id={$row['id']}' class='btn btn-primary btn-sm'>Complete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted'>No pending maintenance requests.</td></tr>";
                    }
                    ?>
                    </tbody>

                </table>
            </div>
        </div>

        <h5 class="text-secondary mb-3"><i class="fa-solid fa-clock-rotate-left me-2"></i>History</h5>

        <div class="card card-custom p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Issue</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $history = mysqli_query($conn, "SELECT * FROM maintenance_requests WHERE status!='Pending' ORDER BY id DESC");

                    if (mysqli_num_rows($history) > 0) {
                        while ($row = mysqli_fetch_assoc($history)) {

                            $badge = match($row['status']) {
                                "Approved" => "bg-approved",
                                "Rejected" => "bg-rejected",
                                "Completed" => "bg-completed",
                                default => "bg-pending"
                            };

                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['room_no']}</td>
                                <td>{$row['issue_type']}</td>
                                <td>{$row['description']}</td>
                                <td><span class='status-badge $badge'>{$row['status']}</span></td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted'>No history found.</td></tr>";
                    }
                    ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

</div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
