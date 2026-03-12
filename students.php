<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/* -----------------------------
   APPROVE / REJECT APPLICATION
--------------------------------*/
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "approve") {
        mysqli_query($conn, "UPDATE student_applications SET status='Approved' WHERE id=$id");
    }
    else if ($action == "reject") {
        mysqli_query($conn, "UPDATE student_applications SET status='Rejected' WHERE id=$id");
    }

    header("Location: students.php");
    exit();
}

/* -----------------------------
   DELETE STUDENT APPLICATION
--------------------------------*/
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM student_applications WHERE id=$id");
    header("Location: students.php");
    exit();
}

/* -----------------------------
   HOSTEL ALLOTMENT (AJAX)
--------------------------------*/
if (isset($_POST['allot_room'])) {

    $student_id = intval($_POST['student_id']);
    $room_no = trim($_POST['room_no']);

    // Fetch student name
    $s_q = mysqli_query($conn, "SELECT name FROM student_applications WHERE id=$student_id");
    $s = mysqli_fetch_assoc($s_q);
    $student_name = $s['name'];

    // Check room exists
    $room_q = mysqli_query($conn, "SELECT * FROM room_data WHERE room_no='$room_no'");
    if (mysqli_num_rows($room_q) == 0) {
        echo "ROOM_NOT_FOUND";
        exit;
    }

    $room = mysqli_fetch_assoc($room_q);

    // Find empty slot
    $slot = "";
    for ($i = 1; $i <= 4; $i++) {
        if (empty($room["student$i"])) {
            $slot = "student$i";
            break;
        }
    }

    if ($slot == "") {
        echo "ROOM_FULL";
        exit;
    }

    // Update room_data table
    mysqli_query($conn, "UPDATE room_data SET $slot='$student_name' WHERE room_no='$room_no'");

    // Update student application
    mysqli_query($conn, "UPDATE student_applications SET 
        room_no='$room_no',
        status='Hostel Allotted',
        allot_date=NOW()
    WHERE id=$student_id");

    echo "SUCCESS";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Students | Hostel Admin</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f8f9fa; }
.sidebar { background:#111827; min-height:100vh; color:#fff; }
.sidebar a { color:#cbd5e1; padding:12px 20px; display:block; border-radius:8px; text-decoration:none; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:white; }
.topbar { background:#fff; padding:12px 25px; box-shadow:0 2px 5px rgba(0,0,0,0.05); }
</style>
</head>
<body>

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->
<div class="col-md-2 sidebar p-3">
    <h4 class="text-center mb-4">🏠 Hostel Admin</h4>
    <a href="admin_dashboard.php"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
    <a href="students.php" class="active"><i class="fa-solid fa-users me-2"></i>Students</a>
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
        <h4>Manage Student Applications</h4>
        <div>Welcome, <?= $_SESSION['admin_name'] ?? "Admin"; ?> 👋</div>
    </div>

    <div class="container mt-4">
        <div class="card shadow-sm p-3">
            <h5 class="mb-3"><i class="fa-solid fa-users text-primary me-1"></i>All Applications</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Room No</th>
                            <th>Action</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
$q = mysqli_query($conn, "SELECT * FROM student_applications ORDER BY id DESC");

while ($s = mysqli_fetch_assoc($q)) {

    $badge = match ($s['status']) {
        "Pending" => "warning",
        "Approved" => "success",
        "Rejected" => "danger",
        "Hostel Allotted" => "primary",
        default => "secondary"
    };
?>

<tr>
    <td><?= $s['id'] ?></td>
    <td><?= $s['name'] ?></td>
    <td><?= $s['email'] ?></td>
    <td><?= $s['mobile'] ?></td>
    <td><?= $s['course'] ?></td>
    <td><span class="badge bg-<?= $badge ?>"><?= $s['status'] ?></span></td>
    <td><?= $s['room_no'] ?: "-" ?></td>

    <td>
        <?php if ($s['status'] == "Pending") { ?>
            <a href="students.php?action=approve&id=<?= $s['id'] ?>" class="btn btn-success btn-sm">Approve</a>
            <a href="students.php?action=reject&id=<?= $s['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
        <?php } elseif ($s['status'] == "Approved") { ?>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#allot<?= $s['id'] ?>">
                Allot Room
            </button>
        <?php } else { ?>
            <span class="text-muted">No Action</span>
        <?php } ?>
    </td>

    <td>
        <a onclick="return confirm('Delete this record?')" 
           href="students.php?delete_id=<?= $s['id'] ?>" 
           class="btn btn-outline-danger btn-sm">
           <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>

<!-- ALLOT MODAL -->
<div class="modal fade" id="allot<?= $s['id'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Allot Room to <?= $s['name'] ?></h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form onsubmit="return allotRoom(this);">

                    <input type="hidden" name="allot_room" value="1">
                    <input type="hidden" name="student_id" value="<?= $s['id'] ?>">

                    <label class="form-label">Enter Room Number</label>
                    <input type="text" name="room_no" class="form-control mb-3" required>

                    <button type="submit" class="btn btn-primary w-100">
                        Confirm Allotment
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<?php } ?>  <!-- END WHILE LOOP -->

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>

<script>
// Allot room WITHOUT page refresh
function allotRoom(form) {
    let fd = new FormData(form);

    fetch("students.php", { method:"POST", body:fd })
    .then(r => r.text())
    .then(res => {
        if (res.trim() === "ROOM_NOT_FOUND") alert("⚠ Room does not exist!");
        else if (res.trim() === "ROOM_FULL") alert("⚠ Room is already full!");
        else if (res.trim() === "SUCCESS") location.reload();
    });

    return false;
}
</script>

</body>
</html>
