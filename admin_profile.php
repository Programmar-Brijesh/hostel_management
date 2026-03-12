<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$admin_email = $_SESSION['admin_email'];

// Fetch admin details
$admin = mysqli_query($conn, "SELECT * FROM admin WHERE email='$admin_email'");
$adminData = mysqli_fetch_assoc($admin);

/* --------------------------------------------
   HANDLE PROFILE UPDATE
--------------------------------------------- */

if (isset($_POST['update_profile'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    // Update
    mysqli_query($conn, "UPDATE admin SET name='$name', mobile='$mobile' WHERE email='$admin_email'");

    echo "<script>alert('Profile updated successfully!'); window.location='admin_profile.php';</script>";
}

/* --------------------------------------------
   HANDLE PASSWORD CHANGE
--------------------------------------------- */

if (isset($_POST['change_password'])) {

    $old = $_POST['oldpass'];
    $new = $_POST['newpass'];

    if ($old == $adminData['password']) {
        mysqli_query($conn, "UPDATE admin SET password='$new' WHERE email='$admin_email'");
        echo "<script>alert('Password updated successfully!'); window.location='admin_profile.php';</script>";
    } else {
        echo "<script>alert('Incorrect old password!');</script>";
    }
}

/* --------------------------------------------
   HANDLE PHOTO CHANGE
--------------------------------------------- */

if (isset($_POST['change_photo'])) {

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    if ($photo != "") {
        $target = "uploads/" . $photo;
        move_uploaded_file($tmp, $target);

        mysqli_query($conn, "UPDATE admin SET photo='$photo' WHERE email='$admin_email'");
        echo "<script>alert('Photo updated!'); window.location='admin_profile.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Profile | Dashboard</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f1f5f9; }

.sidebar {
    position: fixed;
    left: 0; top: 0;
    width: 250px;
    height: 100vh;
    background: #111827;
    padding: 20px;
    overflow-y: auto;
}

.sidebar a {
    color:#cbd5e1; display:block;
    padding:12px 20px; border-radius:8px;
    text-decoration:none;
}

.sidebar a:hover, .sidebar a.active {
    background:#2563eb; color:white;
}

.main-content {
    margin-left:260px;
    padding:30px;
}

.card {
    border:none;
    border-radius:15px;
    box-shadow:0px 4px 10px rgba(0,0,0,0.15);
}
.profile-img {
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #2563eb;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center text-white mb-4">🏠 Hostel Admin</h4>

    <a href="admin_dashboard.php"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
    <a href="students.php"><i class="fa-solid fa-users me-2"></i>Students</a>
    <a href="room_data.php"><i class="fa-solid fa-bed me-2"></i>Rooms</a>
    <a href="leaves.php"><i class="fa-solid fa-plane me-2"></i>Leave Requests</a>
    <a href="maintenance_requests.php"><i class="fa-solid fa-triangle-exclamation me-2"></i>Complaints</a>
    <a href="fees.php"><i class="fa-solid fa-money-bill me-2"></i>Fees</a>
    <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
    <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
    <a href="admin_profile.php" class="active"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>

    <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">

    <div class="card p-4">
        <h3 class="mb-4"><i class="fa-solid fa-user text-primary me-2"></i>Admin Profile</h3>

        <div class="row">
            <div class="col-md-4 text-center">

                <!-- Profile Image -->
                <img src="uploads/<?= $adminData['photo'] ?>" class="profile-img" alt="Admin Photo">

                <form method="POST" enctype="multipart/form-data" class="mt-3">
                    <input type="file" name="photo" class="form-control mb-2" required>
                    <button class="btn btn-primary w-100" name="change_photo">
                        <i class="fa-solid fa-camera me-2"></i>Change Photo
                    </button>
                </form>

            </div>

            <div class="col-md-8">

                <!-- Profile Info -->
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="<?= $adminData['name'] ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (Cannot change)</label>
                        <input type="text" value="<?= $adminData['email'] ?>" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="mobile" value="<?= $adminData['mobile'] ?>" class="form-control">
                    </div>

                    <button class="btn btn-success w-100" name="update_profile">
                        <i class="fa-solid fa-save me-2"></i>Update Profile
                    </button>
                </form>

                <hr>

                <!-- Password Change -->
                <h5>Change Password</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Old Password</label>
                        <input type="password" name="oldpass" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="newpass" class="form-control" required>
                    </div>

                    <button class="btn btn-warning w-100" name="change_password">
                        <i class="fa-solid fa-key me-2"></i>Update Password
                    </button>
                </form>

            </div>
        </div>
    </div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
