<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/*
  Server-side actions (all return plain text responses)
  - update_room  : save student1..student4 for a room
  - add_fourth   : create a persistent 4th slot (student4 = '')
  - remove_fourth: delete the 4th slot (student4 = NULL)
*/

/* ---------- ADD / REMOVE 4th SLOT ---------- */
if (isset($_POST['action']) && isset($_POST['room_id'])) {
    $action = $_POST['action'];
    $room_id = intval($_POST['room_id']);

    if ($action === 'add_fourth') {
        // create persistent 4th slot (empty string)
        mysqli_query($conn, "UPDATE room_data SET student4 = '' WHERE id = $room_id");
        echo "OK";
        exit;
    }

    if ($action === 'remove_fourth') {
        // remove 4th slot (set to NULL)
        mysqli_query($conn, "UPDATE room_data SET student4 = NULL WHERE id = $room_id");
        echo "OK";
        exit;
    }
}

/* ---------- UPDATE ROOM (save inputs) ---------- */
if (isset($_POST['update_room']) && isset($_POST['room_id'])) {
    $id = intval($_POST['room_id']);
    $s1 = isset($_POST['student1']) ? trim($_POST['student1']) : '';
    $s2 = isset($_POST['student2']) ? trim($_POST['student2']) : '';
    $s3 = isset($_POST['student3']) ? trim($_POST['student3']) : '';
    // student4 might not be present in the form (if no slot), handle accordingly:
    $s4 = array_key_exists('student4', $_POST) ? trim($_POST['student4']) : NULL;

    // If $s4 is empty string we store empty string; if NULL then set NULL
    $s1_db = mysqli_real_escape_string($conn, $s1);
    $s2_db = mysqli_real_escape_string($conn, $s2);
    $s3_db = mysqli_real_escape_string($conn, $s3);

    if ($s4 === NULL) {
        mysqli_query($conn, "UPDATE room_data SET
            student1='$s1_db',
            student2='$s2_db',
            student3='$s3_db',
            student4 = NULL
            WHERE id=$id
        ");
    } else {
        $s4_db = mysqli_real_escape_string($conn, $s4);
        mysqli_query($conn, "UPDATE room_data SET
            student1='$s1_db',
            student2='$s2_db',
            student3='$s3_db',
            student4='$s4_db'
            WHERE id=$id
        ");
    }

    echo "OK";
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Rooms | Hostel Admin</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:#f8f9fa; }
.sidebar { background:#111827; min-height:100vh; color:#fff; }
.sidebar a { color:#cbd5e1; padding:12px 20px; display:block; border-radius:8px; text-decoration:none; }
.sidebar a.active, .sidebar a:hover { background:#2563eb; color:white; }

.topbar { background:white; padding:12px 25px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }

.room-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:20px;
}

.room-card {
    background:white;
    border-radius:12px;
    padding:12px;
    box-shadow:0 3px 8px rgba(0,0,0,0.12);
    position:relative;
}

.room-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-bottom:10px;
}

.room-header h5 {
    background:#2563eb;
    color:white;
    padding:6px 10px;
    border-radius:8px;
    margin:0;
    font-size:16px;
}

.controls {
    display:flex;
    gap:6px;
    align-items:center;
}

.update-btn {
    background:#16a34a;
    color:white;
    border:none;
    padding:6px 10px;
    border-radius:6px;
    font-size:13px;
}

.remove-fourth {
    background:#ef4444;
    color:white;
    border:none;
    padding:6px 8px;
    border-radius:6px;
    font-size:12px;
}

.add-btn {
    width:100%;
    border:1px dashed #2563eb;
    padding:8px;
    border-radius:8px;
    color:#2563eb;
    background:white;
}
.add-btn:hover { background:#2563eb; color:white; }

.input-box { margin-bottom:10px; }
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
            <a href="room_data.php" class="active"><i class="fa-solid fa-bed me-2"></i>Rooms</a>
            <a href="leaves.php"><i class="fa-solid fa-plane-departure me-2"></i>Leave Requests</a>
            <a href="maintenance_requests.php"><i class="fa-solid fa-triangle-exclamation me-2"></i>Complaints</a>
            <a href="fees.php"><i class="fa-solid fa-money-bill me-2"></i>Fees</a>
            <a href="notifications.php"><i class="fa-solid fa-bullhorn me-2"></i>Notices</a>
            <a href="reports.php"><i class="fa-solid fa-chart-pie me-2"></i>Reports</a>
            <a href="admin_profile.php"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>
            <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
</div>

<!-- Main -->
<div class="col-md-10">
    <div class="topbar d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Room Management</h4>
        <div>Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?> 👋</div>
    </div>

    <div class="container">
        <h5 class="text-primary text-center mb-3">🏠 Ground Floor (G1–G12)</h5>
        <div class="room-grid" id="groundGrid">
            <?php
            // order by numeric and letter correctly: LENGTH + room_no ensures G1,G2..G10
            $grooms = mysqli_query($conn, "SELECT * FROM room_data WHERE FLOOR='Ground' ORDER BY LENGTH(room_no), room_no ASC");
            while ($r = mysqli_fetch_assoc($grooms)) {
                $has4 = !is_null($r['student4']);
                $formId = 'form'.$r['id'];
            ?>
            <div class="room-card" data-room-id="<?= $r['id'] ?>">
                <div class="room-header">
                    <h5><?= htmlspecialchars($r['room_no']) ?></h5>
                    <div class="controls">
                        <?php if ($has4): ?>
                            <button class="remove-fourth" title="Remove 4th slot" onclick="removeFourth(<?= $r['id'] ?>, '<?= $formId ?>')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        <?php endif; ?>
                        <button class="update-btn" onclick="saveRoom('<?= $formId ?>')">Update</button>
                    </div>
                </div>

                <form id="<?= $formId ?>" onsubmit="return false;">
                    <input type="hidden" name="update_room" value="1">
                    <input type="hidden" name="room_id" value="<?= $r['id'] ?>">

                    <input class="form-control input-box" name="student1" placeholder="Student 1" value="<?= htmlspecialchars($r['student1'] ?? '') ?>">
                    <input class="form-control input-box" name="student2" placeholder="Student 2" value="<?= htmlspecialchars($r['student2'] ?? '') ?>">
                    <input class="form-control input-box" name="student3" placeholder="Student 3" value="<?= htmlspecialchars($r['student3'] ?? '') ?>">

                    <?php if ($has4): ?>
                        <input class="form-control input-box" name="student4" placeholder="Student 4" value="<?= htmlspecialchars($r['student4']) ?>">
                    <?php else: ?>
                        <button type="button" class="add-btn" onclick="addFourth(this, <?= $r['id'] ?>)">+ Add Student</button>
                        <input class="form-control input-box" name="student4" placeholder="Student 4" style="display:none;">
                    <?php endif; ?>
                </form>
            </div>
            <?php } ?>
        </div>

        <h5 class="text-primary text-center mt-4 mb-3">🏢 First Floor (F1–F12)</h5>
        <div class="room-grid" id="firstGrid">
            <?php
            $frooms = mysqli_query($conn, "SELECT * FROM room_data WHERE FLOOR='First' ORDER BY LENGTH(room_no), room_no ASC");
            while ($r = mysqli_fetch_assoc($frooms)) {
                $has4 = !is_null($r['student4']);
                $formId = 'form'.$r['id'];
            ?>
            <div class="room-card" data-room-id="<?= $r['id'] ?>">
                <div class="room-header">
                    <h5><?= htmlspecialchars($r['room_no']) ?></h5>
                    <div class="controls">
                        <?php if ($has4): ?>
                            <button class="remove-fourth" title="Remove 4th slot" onclick="removeFourth(<?= $r['id'] ?>, '<?= $formId ?>')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        <?php endif; ?>
                        <button class="update-btn" onclick="saveRoom('<?= $formId ?>')">Update</button>
                    </div>
                </div>

                <form id="<?= $formId ?>" onsubmit="return false;">
                    <input type="hidden" name="update_room" value="1">
                    <input type="hidden" name="room_id" value="<?= $r['id'] ?>">

                    <input class="form-control input-box" name="student1" placeholder="Student 1" value="<?= htmlspecialchars($r['student1'] ?? '') ?>">
                    <input class="form-control input-box" name="student2" placeholder="Student 2" value="<?= htmlspecialchars($r['student2'] ?? '') ?>">
                    <input class="form-control input-box" name="student3" placeholder="Student 3" value="<?= htmlspecialchars($r['student3'] ?? '') ?>">

                    <?php if ($has4): ?>
                        <input class="form-control input-box" name="student4" placeholder="Student 4" value="<?= htmlspecialchars($r['student4']) ?>">
                    <?php else: ?>
                        <button type="button" class="add-btn" onclick="addFourth(this, <?= $r['id'] ?>)">+ Add Student</button>
                        <input class="form-control input-box" name="student4" placeholder="Student 4" style="display:none;">
                    <?php endif; ?>
                </form>
            </div>
            <?php } ?>
        </div>

    </div>
</div>
</div>
</div>

<script>
/* Add fourth slot -> persist in DB and show input + remove-control */
function addFourth(button, roomId) {
    button.disabled = true;
    const fd = new FormData();
    fd.append('action', 'add_fourth');
    fd.append('room_id', roomId);

    fetch('room_data.php', { method: 'POST', body: fd })
    .then(r => r.text())
    .then(resp => {
        if (resp.trim() === 'OK') {
            // show input and remove add button
            const btn = button;
            const input = btn.nextElementSibling;
            btn.style.display = 'none';
            input.style.display = 'block';

            // add Remove button at top-right (next to Update)
            const card = btn.closest('.room-card');
            const roomIdAttr = card.getAttribute('data-room-id');
            const headerControls = card.querySelector('.controls');

            // only add remove button if not present
            if (!headerControls.querySelector('.remove-fourth')) {
                const rem = document.createElement('button');
                rem.className = 'remove-fourth';
                rem.title = 'Remove 4th slot';
                rem.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
                rem.onclick = function(){ removeFourth(roomId, card.querySelector('form').id); };
                headerControls.insertBefore(rem, headerControls.firstChild);
            }
        } else {
            alert('Failed to create 4th slot.');
            button.disabled = false;
        }
    })
    .catch(() => {
        alert('Network error');
        button.disabled = false;
    });
}

/* Remove fourth slot -> persist remove in DB and update UI */
function removeFourth(roomId, formId) {
    if (!confirm('Remove the 4th slot for this room? This will delete the 4th value.')) return;
    const fd = new FormData();
    fd.append('action', 'remove_fourth');
    fd.append('room_id', roomId);

    fetch('room_data.php', { method:'POST', body: fd })
    .then(r => r.text())
    .then(resp => {
        if (resp.trim() === 'OK') {
            // update UI: remove input and show add button; remove remove-button
            const form = document.getElementById(formId);
            const input4 = form.querySelector('input[name="student4"]');
            if (input4) {
                input4.style.display = 'none';
                input4.value = '';
            }
            // find add button (if none create one before input)
            let addBtn = form.querySelector('.add-btn');
            if (!addBtn) {
                addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'add-btn mb-2';
                addBtn.innerText = '+ Add Student';
                addBtn.onclick = function(){ addFourth(this, roomId); };
                // insert before input4
                if (input4) form.insertBefore(addBtn, input4);
            } else {
                addBtn.style.display = 'block';
            }

            // remove the remove control
            const card = form.closest('.room-card');
            const remBtn = card.querySelector('.remove-fourth');
            if (remBtn) remBtn.remove();
        } else {
            alert('Failed to remove slot.');
        }
    })
    .catch(()=> alert('Network error'));
}

/* Save all inputs for a room (Update button) */
function saveRoom(formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    const fd = new FormData(form);

    fetch('room_data.php', { method:'POST', body: fd })
    .then(r => r.text())
    .then(resp => {
        if (resp.trim() === 'OK') {
            alert('Room saved.');
        } else {
            alert('Save failed.');
            console.log(resp);
        }
    })
    .catch(()=> alert('Network error'));
}
</script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
