<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/* -----------------------------
   HANDLE FEE ACTIONS
------------------------------ */
if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "mark_paid") {
        mysqli_query($conn, "UPDATE fees SET status='Paid' WHERE id=$id");
    }
    elseif ($action == "mark_pending") {
        mysqli_query($conn, "UPDATE fees SET status='Pending' WHERE id=$id");
    }
    elseif ($action == "mark_overdue") {
        mysqli_query($conn, "UPDATE fees SET status='Overdue' WHERE id=$id");
    }
    elseif ($action == "delete") {
        mysqli_query($conn, "DELETE FROM fees WHERE id=$id");
    }

    echo "<script>alert('Fee status updated'); window.location='fees.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fees Management | Admin Dashboard</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f8f9fa; }
.sidebar { background:#111827; min-height:100vh; color:white; }
.sidebar a { color:#cbd5e1; display:block; padding:12px 20px; border-radius:8px; text-decoration:none; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:white; }
.topbar { background:white; padding:12px 25px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }

.card-custom {
    border-radius:12px;
    box-shadow:0px 3px 8px rgba(0,0,0,0.1);
}

.status-badge {
    padding:6px 10px;
    border-radius:6px;
    color:white;
    font-size:14px;
}
.bg-paid { background:#16a34a; }
.bg-pending { background:#facc15; color:black; }
.bg-overdue { background:#dc2626; }
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
        <a href="maintenance_requests.php"><i class="fa-solid fa-triangle-exclamation me-2"></i>Complaints</a>
        <a href="fees.php" class="active"><i class="fa-solid fa-money-bill me-2"></i>Fee</i></a>
        <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
        <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
        <a href="profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
        <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>

    </div>

    <!-- Main -->
    <div class="col-md-10">

        <div class="topbar d-flex justify-content-between align-items-center">
            <h4>Fees Management</h4>
            <div>Welcome, <?= $_SESSION['admin_name'] ?? "Admin"; ?> 👋</div>
        </div>

        <div class="container mt-4">

            <!-- Pending & Overdue -->
            <h5 class="text-primary mb-3"><i class="fa-solid fa-hourglass-half me-2"></i>Pending & Overdue Fees</h5>

            <div class="card card-custom p-3 mb-4">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Room No</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $fees = mysqli_query($conn, "
                            SELECT * FROM fees 
                            WHERE status='Pending' OR status='Overdue' 
                            ORDER BY id DESC
                        ");

                        if (mysqli_num_rows($fees) > 0) {
                            while ($row = mysqli_fetch_assoc($fees)) {

                                $badge = $row['status'] == "Overdue" ? "bg-overdue" : "bg-pending";

                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['student_name']}</td>
                                    <td>{$row['room_no']}</td>
                                    <td>₹{$row['amount']}</td>
                                    <td>{$row['due_date']}</td>
                                    <td><span class='status-badge {$badge}'>{$row['status']}</span></td>

                                    <td>
                                        <a href='fees.php?action=mark_paid&id={$row['id']}' class='btn btn-success btn-sm me-1'>
                                            Mark Paid
                                        </a>
                                        <a href='fees.php?action=mark_overdue&id={$row['id']}' class='btn btn-warning btn-sm me-1'>
                                            Mark Overdue
                                        </a>
                                        <a href='fees.php?action=delete&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this record?\")'>
                                            Delete
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted'>No pending or overdue fees.</td></tr>";
                        }
                        ?>
                        </tbody>

                    </table>
                </div>

            </div>


            <!-- Paid Fees History -->
            <h5 class="text-secondary mb-3"><i class="fa-solid fa-circle-check me-2"></i>Payment History</h5>

            <div class="card card-custom p-3">
                <div class="table-responsive">

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Room No</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Date Paid</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $history = mysqli_query($conn, "
                            SELECT * FROM fees WHERE status='Paid' ORDER BY id DESC
                        ");

                        if (mysqli_num_rows($history) > 0) {
                            while ($row = mysqli_fetch_assoc($history)) {

                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['student_name']}</td>
                                    <td>{$row['room_no']}</td>
                                    <td>₹{$row['amount']}</td>
                                    <td>{$row['due_date']}</td>
                                    <td><span class='status-badge bg-paid'>Paid</span></td>
                                    <td>{$row['created_at']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted'>No payment history yet.</td></tr>";
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
