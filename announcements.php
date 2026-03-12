<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

// Fetch notices
$query = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Announcements | CSJM Boys Hostel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: #eef2f7;
    font-family: 'Poppins', sans-serif;
}

/* MAIN CONTENT */
.main-content {
    margin-left: 250px;
    padding: 40px 35px;
}

/* SECTION TITLE */
.section-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 25px;
}

/* NOTICE CARD */
.notice-card {
    background: white;
    padding: 22px;
    border-radius: 16px;
    margin-bottom: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    border-left: 6px solid #2563eb;
    transition: all 0.25s ease;
}

.notice-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 26px rgba(0,0,0,0.15);
}

/* TITLE */
.notice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* CATEGORY BADGES */
.badge-category {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    color: #fff;
    text-transform: capitalize;
}

.badge-general { background:#2563eb; }
.badge-urgent { background:#dc2626; }
.badge-fee { background:#16a34a; }
.badge-rules { background:#7c3aed; }
.badge-holiday { background:#f59e0b; }

/* DATE */
.notice-date {
    font-size: 13px;
    color: #64748b;
}

/* MESSAGE */
.notice-message {
    font-size: 15px;
    margin-top: 12px;
    color: #334155;
    line-height: 1.6;
}

/* TIMELINE SEPARATOR */
.timeline-title {
    margin: 35px 0 15px;
    font-weight: 600;
    font-size: 18px;
    color: #475569;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>👨‍🎓 CSJM Hostel</h4>
    <a href="user_dashboard.php">🏠 Dashboard</a>
    <a href="my_room.php">🏘 My Room</a>
    <a href="my_application.php">🧾 My Application</a>
    <a href="leave_request.php">🧾 Apply Leave</a>
    <a href="maintenance.php">🧰 Maintenance</a>
    <a href="announcements.php" class="active">📢 Announcements</a>
    <a href="enquiry_status.php">📨 View Enquiry Status</a>
    <a href="profile.php">⚙️ Profile</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="section-title">📢 Announcements & Notices</div>

    <?php
    if (mysqli_num_rows($result) > 0) {

        $today = date("Y-m-d");

        echo "<div class='timeline-title'>Today</div>";

        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {

            $date = date("Y-m-d", strtotime($row['created_at']));
            $category = strtolower($row['category']);
            $badgeClass = "badge-" . $category;

            // If not today, move to older section once.
            if ($date != $today) {
                echo "<div class='timeline-title'>Earlier Notices</div>";
                $today = "-1"; // only display the title once
            }

            echo "
            <div class='notice-card'>

                <div class='notice-header'>
                    <h5><i class='fa-solid fa-bullhorn me-2'></i>{$row['title']}</h5>
                    <span class='badge-category {$badgeClass}'>{$row['category']}</span>
                </div>

                <div class='notice-date'>
                    <i class='fa-regular fa-calendar-days me-1'></i> 
                    " . date("d M Y, h:i A", strtotime($row['created_at'])) . "
                </div>

                <div class='notice-message'>{$row['message']}</div>

            </div>";
        }

    } else {
        echo "<div class='alert alert-secondary'>No announcements yet.</div>";
    }
    ?>
</div>

</body>
</html>
