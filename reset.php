<?php
include("db.php");

$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if (!$token || !$email) {
    die("<h3 style='text-align:center;margin-top:50px;color:red;'>Invalid link!</h3>");
}

$result = mysqli_query($conn, "SELECT * FROM password_resets WHERE email='$email' AND token='$token'");
$row = mysqli_fetch_assoc($result);

if (!$row || strtotime($row['expires_at']) < time()) {
    die("<h3 style='text-align:center;margin-top:50px;color:red;'>Link expired or invalid!</h3>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="col-md-6 mx-auto">
    <div class="card p-4 shadow">
      <h3 class="text-center mb-3">Reset Password</h3>
      <form method="POST" action="reset_handler.php">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <div class="mb-3">
          <label>New Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Update Password</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
