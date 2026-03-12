<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Optional: Prevent back-button access after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include("db.php"); // adjust as per your structure
?>
<?php
function statusColor($status) {
    return match($status) {
        'Pending'       => 'warning',   // Yellow
        'Approved'      => 'success',   // Green
        'Rejected'      => 'danger',    // Red
        'Completed'     => 'primary',   // Blue
        'Resolved'      => 'info',      // Light blue
        'In Progress'   => 'secondary', // Gray
        default         => 'dark'
    };
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CSJM Boys Hostel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background: #111827;
            min-height: 100vh;
            color: #fff;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #2563eb;
            color: #fff;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .topbar {
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 12px 25px;
        }

        .topbar .admin-name {
            font-weight: 600;
            color: #1f2937;
        }

        .dashboard-cards .card h5 {
            font-size: 16px;
            color: #6b7280;
        }

        .dashboard-cards .card h3 {
            font-weight: bold;
            color: #111827;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <h4 class="text-center mb-4">🏠 Hostel Admin</h4>
                <a href="admin_dashboard.php" class="active"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
                <a href="students.php"><i class="fa-solid fa-users me-2"></i>Students</a>
                <a href="room_data.php"><i class="fa-solid fa-bed me-2"></i>Rooms</a>
                <a href="leaves.php"><i class="fa-solid fa-plane-departure me-2"></i>Leave Requests</a>
                <a href="maintenance_requests.php"><i class="fa-solid fa-triangle-exclamation me-2"></i>Complaints</a>
                <a href="fees.php"><i class="fa-solid fa-money-bill me-2"></i>Fees</a>
                <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
                <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
                <a href="admin_profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
                <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="topbar d-flex justify-content-between align-items-center">
                    <h4>Dashboard Overview</h4>
                    <div class="admin-name">Welcome,
                        <?php echo $_SESSION['admin_name'] ?? 'Admin'; ?> 👋
                    </div>
                </div>

                <div class="container-fluid mt-4 dashboard-cards">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                                <h5>Total Students</h5>
                                <h3>
                                    <?php
                                $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM student_applications");
                                $row = mysqli_fetch_assoc($query);
                                echo $row['total'] ?? 0;
                                ?>
                                </h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <i class="fa-solid fa-bed fa-2x text-success mb-2"></i>
                                <h5>Occupied Rooms</h5>
                                <h3>
                                    <?php
                                $query = mysqli_query($conn, "SELECT COUNT(DISTINCT room_id) AS occupied FROM student_applications WHERE room_id IS NOT NULL");
                                $row = mysqli_fetch_assoc($query);
                                echo $row['occupied'] ?? 0;
                                ?>
                                </h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <i class="fa-solid fa-triangle-exclamation fa-2x text-warning mb-2"></i>
                                <h5>Pending Complaints</h5>
                                <h3>
                                    <?php
                                $query = mysqli_query($conn, "SELECT COUNT(*) AS pending FROM maintenance_requests WHERE status='Pending'");
                                $row = mysqli_fetch_assoc($query);
                                echo $row['pending'] ?? 0;
                                ?>
                                </h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <i class="fa-solid fa-plane-departure fa-2x text-info mb-2"></i>
                                <h5>Leave Requests</h5>
                                <h3>
                                    <?php
                                $query = mysqli_query($conn, "SELECT COUNT(*) AS leaves FROM leave_requests WHERE status='Pending'");
                                $row = mysqli_fetch_assoc($query);
                                echo $row['leaves'] ?? 0;
                                ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="card p-4">
                                <h5 class="mb-3">Recent Complaints</h5>
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Room No.</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res = mysqli_query($conn, "SELECT email, room_no, issue_type, status FROM maintenance_requests ORDER BY id DESC LIMIT 5");
                                        while ($data = mysqli_fetch_assoc($res)) {
                                            // sanitize values for safety
                                            $email = htmlspecialchars($data['email']);
                                            $room_no = htmlspecialchars($data['room_no']);
                                            $issue = htmlspecialchars($data['issue_type']);
                                            $status = htmlspecialchars($data['status']);
                                            $color = statusColor($data['status']);
                                            ?>
                                            <tr>
                                                <td><?= $email ?></td>
                                                <td><?= $room_no ?></td>
                                                <td><?= $issue ?></td>
                                                <td><span class="badge bg-<?= $color ?>"><?= $status ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-4">
                                <h5 class="mb-3">Recent Leave Requests</h5>
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Reason</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res = mysqli_query($conn, "SELECT name, reason, from_date, to_date, status FROM leave_requests ORDER BY id DESC LIMIT 5");
                                        while ($data = mysqli_fetch_assoc($res)) {
                                            $name = htmlspecialchars($data['name']);
                                            $reason = htmlspecialchars($data['reason']);
                                            $from = htmlspecialchars($data['from_date']);
                                            $to = htmlspecialchars($data['to_date']);
                                            $status = htmlspecialchars($data['status']);
                                            $color = statusColor($data['status']);
                                            ?>
                                            <tr>
                                                <td><?= $name ?></td>
                                                <td><?= $reason ?></td>
                                                <td><?= $from ?></td>
                                                <td><?= $to ?></td>
                                                <td><span class="badge bg-<?= $color ?>"><?= $status ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>