<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/* ------------------------------------------
    FETCH ALL REPORT COUNTS FROM DATABASE
------------------------------------------- */

// STUDENT REPORTS
$total_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM student_applications"))[0];
$approved_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM student_applications WHERE status='Approved'"))[0];
$rejected_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM student_applications WHERE status='Rejected'"))[0];
$allotted_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM student_applications WHERE status='Hostel Allotted'"))[0];
$pending_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM student_applications WHERE status='Pending'"))[0];

// ROOM REPORT
$total_rooms = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM room_data"))[0];
$total_beds = $total_rooms * 4;

$occupied_beds = mysqli_fetch_row(mysqli_query($conn, "
    SELECT 
    (COUNT(student1) + COUNT(student2) + COUNT(student3) + COUNT(student4)) AS filled
    FROM room_data
"))[0];

$available_beds = $total_beds - $occupied_beds;

// LEAVE REPORT
$total_leaves = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM leave_requests"))[0];
$approved_leaves = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM leave_requests WHERE status='Approved'"))[0];
$rejected_leaves = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM leave_requests WHERE status='Rejected'"))[0];
$pending_leaves = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM leave_requests WHERE status='Pending'"))[0];

// MAINTENANCE REPORT
$total_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests"))[0];
$pending_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='Pending'"))[0];
$inprogress_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='In Progress'"))[0];
$resolved_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='Resolved'"))[0];
$approved_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='Approved'"))[0];
$rejected_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='Rejected'"))[0];
$completed_maint = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM maintenance_requests WHERE status='Completed'"))[0];

// FEES REPORT
$total_fees = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM fees"))[0];
$paid_fees = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM fees WHERE status='Paid'"))[0];
$pending_fees = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM fees WHERE status='Pending'"))[0];
$overdue_fees = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM fees WHERE status='Overdue'"))[0];

// ENQUIRY REPORT
$total_enquiry = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enquiry"))[0];
$pending_enquiry = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enquiry WHERE status='Pending'"))[0];
$resolved_enquiry = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enquiry WHERE status='Resolved'"))[0];

// NOTIFICATIONS COUNT
$total_notices = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM notifications"))[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reports | Admin Dashboard</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f1f5f9; }
.sidebar { background:#111827; min-height:100vh; color:white; }
.sidebar a { color:#cbd5e1; padding:12px 20px; display:block; border-radius:8px; text-decoration:none; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:white; }

.topbar { background:white; padding:12px 25px; box-shadow:0px 2px 8px rgba(0,0,0,0.08); }

.stat-card {
    background:white; 
    padding:22px; 
    border-radius:12px; 
    text-align:center;
    box-shadow:0px 4px 10px rgba(0,0,0,0.1);
}
.stat-card h3 { font-size:32px; margin:0; font-weight:700; }
.stat-card p { margin:8px 0 0; color:#555; }

.section-title {
    font-weight:700; 
    color:#1e3a8a; 
    margin-top:30px; 
    margin-bottom:15px;
}
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
        <a href="fees.php"><i class="fa-solid fa-money-bill me-2"></i>Fees</a>
        <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
        <a href="reports.php" class="active"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
        <a href="admin_profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
        <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>

    </div>

    <!-- Main Content -->
    <div class="col-md-10">

        <div class="topbar d-flex justify-content-between align-items-center">
            <h4>Reports & Analytics</h4>
            <div>Welcome, <?= $_SESSION['admin_name'] ?? "Admin"; ?> 👋</div>
        </div>

        <div class="container mt-4">

            <!-- STUDENTS -->
            <h5 class="section-title">👨‍🎓 Student Reports</h5>
            <div class="row g-3">
                <div class="col-md-2"><div class="stat-card"><h3><?= $total_students ?></h3><p>Total Students</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $pending_students ?></h3><p>Pending</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $approved_students ?></h3><p>Approved</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $rejected_students ?></h3><p>Rejected</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $allotted_students ?></h3><p>Hostel Allotted</p></div></div>
            </div>

            <!-- ROOMS -->
            <h5 class="section-title">🏠 Room & Bed Report</h5>
            <div class="row g-3">
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_rooms ?></h3><p>Total Rooms</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_beds ?></h3><p>Total Beds</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $occupied_beds ?></h3><p>Occupied Beds</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $available_beds ?></h3><p>Available Beds</p></div></div>
            </div>

            <!-- LEAVE REQUESTS -->
            <h5 class="section-title">🛄 Leave Requests Report</h5>
            <div class="row g-3">
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_leaves ?></h3><p>Total Requests</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $approved_leaves ?></h3><p>Approved</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $pending_leaves ?></h3><p>Pending</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $rejected_leaves ?></h3><p>Rejected</p></div></div>
            </div>

            <!-- MAINTENANCE -->
            <h5 class="section-title">🛠 Maintenance Requests</h5>
            <div class="row g-3">
                <div class="col-md-2"><div class="stat-card"><h3><?= $total_maint ?></h3><p>Total</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $pending_maint ?></h3><p>Pending</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $inprogress_maint ?></h3><p>In Progress</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $approved_maint ?></h3><p>Approved</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $rejected_maint ?></h3><p>Rejected</p></div></div>
                <div class="col-md-2"><div class="stat-card"><h3><?= $completed_maint ?></h3><p>Completed</p></div></div>
            </div>

            <!-- FEES -->
            <h5 class="section-title">💰 Fees Report</h5>
            <div class="row g-3">
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_fees ?></h3><p>Total Records</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $paid_fees ?></h3><p>Paid</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $pending_fees ?></h3><p>Pending</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $overdue_fees ?></h3><p>Overdue</p></div></div>
            </div>

            <!-- ENQUIRY -->
            <h5 class="section-title">📩 Enquiry Report</h5>
            <div class="row g-3 mb-5">
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_enquiry ?></h3><p>Total Enquiries</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $pending_enquiry ?></h3><p>Pending</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $resolved_enquiry ?></h3><p>Resolved</p></div></div>
                <div class="col-md-3"><div class="stat-card"><h3><?= $total_notices ?></h3><p>Total Notices</p></div></div>
            </div>

        </div>

    </div>

</div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
