<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - CSJM Boys Hostel</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<!-- Professional font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="icon" type="image/png" href="images/hostellogo.png" sizes="32x32">
	<style>
		/* Local override to keep login focused and consistent */
		.login-card {
			max-width: 460px;
			margin: 60px auto;
			padding: 26px;
			border-radius: 10px;
			box-shadow: 0 8px 30px rgba(13, 43, 89, 0.08);
			background: #fff;
		}

		.login-hero {
			background: linear-gradient(180deg, rgba(13,43,89,0.04), rgba(13,43,89,0.02));
			border-radius: 10px;
			padding: 16px;
			text-align: center;
		}

		.small-link {
			font-size: 0.95rem;
		}
	</style>
</head>

<body>
	<!-- Navbar (keep consistent with other pages) -->
	<nav style="background-color: #0D2B59;" class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid">
			<a class="navbar-brand d-flex align-items-center" href="admin_login.php">
				<img style="margin-left: 12px;" src="images/hostellogo.png" alt="Hostel Logo" height="50"
					class="me-2">
				<span class="ms-1">CSJM Boys Hostel</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="navbar-nav align-items-center me-3">
					<li class="nav-item"><a class="nav-link" id="nav-hover" href="index.php">Home</a></li>
					<li class="nav-item"><a class="nav-link" id="nav-hover" href="contact.php">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Main login card -->
	<main class="container">
		<div class="login-card">
			<div class="login-hero mb-3">
				<img src="images/hostellogo.png" alt="logo" height="64">
				<h3 class="mt-2" style="color:var(--csjm-navy);">Member Login</h3>
				<p class="mb-0" style="color:var(--text-dark);">Access your hostel account and applications</p>
			</div>

			<form id="loginForm" action="php_code/login_code.php" method="post"  novalidate>
				<div class="mb-3">
					<label for="loginEmail" class="form-label">Email address</label>
					<input type="email" name="email" class="form-control" id="loginEmail" placeholder="you@college.edu" required>
				</div>

				<div class="mb-3">
					<label for="loginPassword" class="form-label">Password</label>
					<input type="password" name="password" class="form-control" id="loginPassword" placeholder="Enter password" required>
				</div>

				<div class="mb-3 d-flex justify-content-between align-items-center">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="rememberMe">
						<label class="form-check-label small" for="rememberMe">Remember me</label>
					</div>
					<div>
						<a href="#" class="small-link" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot
							password?</a>
					</div>
				</div>

				<div class="d-grid mb-3">
					<button type="submit" class="btn" style="background:var(--csjm-navy); color: #fff;">Login</button>
				</div>

				<div class="text-center">
					<small class="text-muted">Don’t have an account? </small>
					<a href="#" class="ms-1" data-bs-toggle="modal" data-bs-target="#createModal">Create
						Account</a>
				</div>
			</form>
			<p class="text-center" style="margin-top:10px; font-size:14px;">
    Didn’t receive the verification email?  <br>
    <a href="resend_verification.php" style="color:#007bff; font-weight:bold;">
        Resend Email
    </a>
</p>

		</div>
	</main>

	<!-- Create Account Modal -->
	<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createModalLabel">Create Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="createForm" action="php_code/register_code.php" method="POST" novalidate>
						<div class="mb-3">
							<label for="createName" class="form-label">Full name</label>
							<input type="text" name="name" class="form-control" id="createName" required>
						</div>
						<div class="mb-3">
							<label for="createEmail" class="form-label">Email</label>
							<input type="email" name="email" class="form-control" id="createEmail" required>
						</div>
						<div class="mb-3">
							<label for="createPassword" class="form-label">Password</label>
							<input type="password" name="password" class="form-control" id="createPassword" required>
						</div>
						<div class="mb-3">
							<label for="createEnroll" class="form-label">Enrollment / Roll No.</label>
							<input type="text" name="enroll" class="form-control" id="createEnroll">
						</div>
						<div class="d-grid">
							<button type="submit" name="register.php" class="btn btn-primary">Create account</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Forgot Password Modal -->
	<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="forgotModalLabel">Reset Password</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="forgotForm" novalidate>
						<div class="mb-3">
							<label for="forgotEmail" class="form-label">Registered email</label>
							<input type="email" class="form-control" id="forgotEmail" required>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-outline-primary">Send reset link</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $("#forgotForm").submit(function(e) {
    e.preventDefault();

    let email = $("#forgotEmail").val().trim();

    if (email === "") {
      alert("Please enter your registered email!");
      return;
    }

    $.ajax({
      url: "forgot_ajax.php",
      type: "POST",
      data: { email: email },
      success: function(response) {
        alert(response);  // You can replace with a sweet alert
        $("#forgotForm")[0].reset();
        $("#forgotModal").modal('hide');
      },
      error: function() {
        alert("Error sending reset link. Try again!");
      }
    });
  });
});
</script>


	<!-- Footer (simple link back) -->
	<footer class="text-center mt-5 mb-4">
		<a href="index.php" class="text-muted">Back to home</a>
	</footer>

	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>

