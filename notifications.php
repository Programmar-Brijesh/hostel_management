<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/* ------------------------------
   ADD NEW NOTICE
------------------------------ */
if (isset($_POST['add_notice'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    mysqli_query($conn, "INSERT INTO notifications (title, message, category) 
                         VALUES ('$title', '$message', '$category')");

    echo "<script>alert('Notification posted successfully!'); window.location='notifications.php';</script>";
    exit();
}

/* ------------------------------
   DELETE NOTICE
------------------------------ */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM notifications WHERE id=$id");

    echo "<script>alert('Notification deleted'); window.location='notifications.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Notifications | Admin Dashboard</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f8f9fa; }
.sidebar { background:#111827; min-height:100vh; color:#fff; }
.sidebar a { color:#cbd5e1; padding:12px 20px; display:block; border-radius:8px; text-decoration:none; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:#fff; }

.topbar { background:white; padding:12px 25px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }

.card-custom { 
    background:white; 
    padding:20px; 
    border-radius:12px; 
    box-shadow:0px 3px 8px rgba(0,0,0,0.15);
}

.badge-category {
    padding:6px 10px;
    border-radius:6px;
    font-size:13px;
    text-transform:capitalize;
}

.badge-general { background:#2563eb; color:white; }
.badge-urgent { background:#dc2626; color:white; }
.badge-fee { background:#16a34a; color:white; }
.badge-rules { background:#7c3aed; color:white; }
.badge-holiday { background:#f59e0b; color:white; }
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
        <a href="notifications.php" class="active"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
        <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
        <a href="admin_profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
        <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10">

        <div class="topbar d-flex justify-content-between align-items-center">
            <h4>Notifications Manager</h4>
            <div>Welcome, <?= $_SESSION['admin_name'] ?? "Admin"; ?> 👋</div>
        </div>

        <div class="container mt-4">

            <!-- Add Notice Section -->
            <div class="card-custom mb-4">

                <h5><i class="fa-solid fa-pen-to-square me-2"></i>Create New Notice</h5>

                <form method="POST" class="mt-3">
                    <div class="mb-3">
                        <label class="form-label">Notice Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="Enter notice title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notice Message</label>
                        <textarea name="message" class="form-control" rows="4" required placeholder="Write the notice here"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control" required>
                            <option value="general">General</option>
                            <option value="urgent">Urgent</option>
                            <option value="fee">Fee Notice</option>
                            <option value="rules">Hostel Rules</option>
                            <option value="holiday">Holiday</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" name="add_notice">
                        <i class="fa-solid fa-paper-plane me-2"></i>Publish Notice
                    </button>
                </form>

            </div>

            <!-- Notices List -->
            <div class="card-custom">

                <h5><i class="fa-solid fa-bell me-2"></i>All Notices</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $notices = mysqli_query($conn, "SELECT * FROM notifications ORDER BY id DESC");

                        if (mysqli_num_rows($notices) > 0) {
                            while ($row = mysqli_fetch_assoc($notices)) {

                                // Category badge color
                                $badgeClass = "badge-" . strtolower($row['category']);

                                echo "
                                <tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['message']}</td>
                                    <td><span class='badge-category {$badgeClass}'>{$row['category']}</span></td>
                                    <td>{$row['created_at']}</td>

                                    <td>
                                        <a href='notifications.php?delete={$row['id']}' 
                                           class='btn btn-danger btn-sm'
                                           onclick='return confirm(\"Delete this notice?\")'>
                                           <i class='fa-solid fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted'>No notices found.</td></tr>";
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
