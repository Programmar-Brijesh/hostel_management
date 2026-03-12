<?php
session_start();
include("db.php");

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['email'];

// Fetch user info from DB
$query = "SELECT * FROM student_applications WHERE email='$user_email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// ---------------------- PROFILE UPDATE ----------------------
if (isset($_POST['update_profile'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $guardian_contact = mysqli_real_escape_string($conn, $_POST['guardian_contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update = "UPDATE student_applications 
               SET name='$name', course='$course', year='$year',
                   mobile='$mobile', guardian_contact='$guardian_contact', address='$address'
               WHERE email='$user_email'";

    if (mysqli_query($conn, $update)) {
        $msg = "Profile updated successfully!";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
    } else {
        $msg = "Error updating profile!";
    }
}

// ---------------------- PASSWORD CHANGE ----------------------
if (isset($_POST['change_password'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];

    $check = "SELECT * FROM users WHERE email='$user_email' AND password='$old_pass'";
    $check_result = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_result) > 0) {
        mysqli_query($conn, "UPDATE users SET password='$new_pass' WHERE email='$user_email'");
        $msg = "Password changed successfully!";
    } else {
        $msg = "Old password is incorrect!";
    }
}

// ---------------------- PROFILE PHOTO PATH ----------------------
$photo = str_replace("../", "", $user['photo']);

if (empty($photo) || !file_exists($photo)) {
    $photo = "uploads/default.png";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile - CSJM Boys Hostel</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar.css">

<style>
body { background: #f4f7fa;
font-family: 'Poppins', sans-serif;
}


.main-content { margin-left: 250px; padding: 30px; }

.card { border: none; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }

.profile-img {
    width: 130px; height: 130px; border-radius: 50%;
    border: 4px solid #0056b3; object-fit: cover; margin-bottom: 15px;
}
.detail-text {
    color: #555; word-wrap: break-word; white-space: normal; margin: 0;
}
.edit-form { display: none; }
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
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php" class="active">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">

<h3 class="mb-4">⚙️ My Profile</h3>

<?php if (isset($msg)) { ?>
    <div class="alert alert-info"><?php echo $msg; ?></div>
<?php } ?>


<!-- VIEW CARD -->
<div class="card profile-card mb-4" id="profileCard" style="padding:30px;">

    <img src="<?php echo $photo; ?>" class="profile-img">

    <h4 class="fw-bold"><?php echo $user['name']; ?></h4>
    <p class="text-muted mb-4"><?php echo $user['email']; ?></p>

    <div class="container">
        <div class="row g-3 text-start justify-content-center">

            <div class="col-md-4">
                <strong>📘 Enrollment No:</strong>
                <p class="detail-text"><?php echo $user['enroll']; ?></p>
            </div>

            <div class="col-md-4">
                <strong>📚 Course:</strong>
                <p class="detail-text"><?php echo $user['course']; ?></p>
            </div>

            <div class="col-md-4">
                <strong>🎓 Year:</strong>
                <p class="detail-text"><?php echo $user['year']; ?></p>
            </div>

            <div class="col-md-4">
                <strong>📞 Mobile:</strong>
                <p class="detail-text"><?php echo $user['mobile']; ?></p>
            </div>

            <div class="col-md-4">
                <strong>👨‍👩‍👦 Guardian Contact:</strong>
                <p class="detail-text"><?php echo $user['guardian_contact']; ?></p>
            </div>

            <div class="col-md-4">
                <strong>🏠 Address:</strong>
                <p class="detail-text"><?php echo $user['address']; ?></p>
            </div>

        </div>
    </div>

    <button class="btn btn-primary mt-3" id="editBtn">✏️ Edit Profile</button>
</div>


<!-- EDIT FORM -->
<div class="card p-4 edit-form" id="editForm">
    <h5 class="card-title text-center">Update Profile</h5>

    <img src="<?php echo $photo; ?>" class="profile-img">

    <form method="POST">
        <div class="row g-3 mt-3">

            <div class="col-md-4">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Email (readonly)</label>
                <input type="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label">Enrollment No (readonly)</label>
                <input type="text" class="form-control" value="<?php echo $user['enroll']; ?>" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label">Course</label>
                <input type="text" name="course" class="form-control" value="<?php echo $user['course']; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Year</label>
                <input type="text" name="year" class="form-control" value="<?php echo $user['year']; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile']; ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Guardian Contact</label>
                <input type="text" name="guardian_contact" class="form-control" value="<?php echo $user['guardian_contact']; ?>">
            </div>

            <div class="col-md-8">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"><?php echo $user['address']; ?></textarea>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" name="update_profile" class="btn btn-success mt-2">💾 Save Changes</button>
                <button type="button" class="btn btn-secondary mt-2" id="cancelEdit">❌ Cancel</button>
            </div>
        </div>
    </form>
</div>


<!-- Change Password -->
<div class="card p-4 mt-4">
    <h5 class="card-title mb-3">Change Password</h5>

    <form method="POST">
        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Old Password</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" name="change_password" class="btn btn-primary mt-2">🔑 Change Password</button>
            </div>

        </div>
    </form>
</div>

</div> <!-- main-content -->

<script src="js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('editBtn').onclick = () => {
    document.getElementById('profileCard').style.display = 'none';
    document.getElementById('editForm').style.display = 'block';
};

document.getElementById('cancelEdit').onclick = () => {
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('profileCard').style.display = 'block';
};
</script>

</body>
</html>
