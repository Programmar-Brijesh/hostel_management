<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSJM - BOYS HOSTEL</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="images/hostellogo.png" sizes="32x32">
</head>

<body>
    <!-- Navbar Start -->
    <nav style="background-color: #0D2B59;" class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img style="margin-left: 50px;" src="images/hostellogo.png" alt="Hostel Logo" height="60" class="me-2">
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-hover" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-hover" href="about.php">About Hostel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-hover" href="rooms.php">Rooms & Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-hover" href="fee_structure.php">Fee Structure</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-hover" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2 text-bold" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- main content start -->
    <!-- Fee Structure Section Start -->
<section class="fee-structure container my-5 animate-section">
    <h2 class="mb-4 animate-item">Fee Structure</h2>
    <p class="animate-item">
        At <strong>CSJM Boys Hostel</strong>, we maintain a transparent and structured fee policy to ensure smooth administration and convenience for all students. The fee is divided into **room charges, food charges, and monthly mess fees**.
    </p>

    <div class="row g-4 mt-3">
        <!-- Room Fee -->
        <div class="col-md-4 animate-item">
            <div class="fee-card p-3 border rounded text-center h-100">
                <i class="bi bi-house-door-fill display-4 text-primary mb-2"></i>
                <h5>Room Fee</h5>
                <p><strong>₹1,300</strong> per year</p>
                <p>Payable via <strong>DD form</strong> during admission.</p>
            </div>
        </div>

        <!-- Food Fee -->
        <div class="col-md-4 animate-item">
            <div class="fee-card p-3 border rounded text-center h-100">
                <i class="bi bi-cup-straw display-4 text-primary mb-2"></i>
                <h5>Food Fee</h5>
                <p><strong>₹6,000</strong> together</p>
                <p>Payable directly to the warden for meals, plus <strong>one month extra as sukoti</strong>.</p>
            </div>
        </div>

        <!-- Monthly Mess Fee -->
        <div class="col-md-4 animate-item">
            <div class="fee-card p-3 border rounded text-center h-100">
                <i class="bi bi-calendar-fill display-4 text-primary mb-2"></i>
                <h5>Monthly Mess Fee</h5>
                <p><strong>₹3,000</strong> per month</p>
                <p>Payable at the beginning of every month for ongoing meal services.</p>
            </div>
        </div>
    </div>

    <div class="mt-4 animate-item">
        <p class="text-muted">
            <em>Note:</em> All fees are subject to hostel rules and may be revised by the administration. Students are advised to pay the fees on time to avoid inconvenience.
        </p>
    </div>
</section>

    <!-- main content end -->

    <div class="row">
        <!-- Footer Start -->
        <footer class="bg-dark text-light pt-5 pb-3">
            <div class="container">
                <div class="row">
                    <!-- About Section -->
                    <div class="col-md-4 mb-4">
                        <h5>About CSJM Boys Hostel</h5>
                        <p>
                            CSJM Government Polytechnic Ambedkar Nagar Boys Hostel provides a safe and comfortable
                            living environment for students with modern amenities and dedicated staff support.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-4 mb-4">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php" class="text-light text-decoration-none">Home</a></li>
                            <li><a href="apply.php" class="text-light text-decoration-none">Apply Online</a></li>
                            <li><a href="rules.php" class="text-light text-decoration-none">Rules & Regulations</a>
                            </li>
                            <li><a href="contact.php" class="text-light text-decoration-none">Contact Us</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-md-4 mb-4">
                        <h5>Contact Us</h5>
                        <p>
                            <i class="bi bi-geo-alt-fill"></i> Ambedkar Nagar, Uttar Pradesh, India<br>
                            <i class="bi bi-telephone-fill"></i> +91 9876543210<br>
                            <i class="bi bi-envelope-fill"></i> info@csjmhostel.edu.in
                        </p>
                        <!-- Social Icons -->
                        <div class="mt-2">
                            <a href="#" class="text-light me-3"><i class="fa-brands fa-square-facebook"></i></a>
                            <a href="#" class="text-light me-3"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="text-light me-3"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="text-light"><i class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <hr class="border-light">

                <!-- Copyright -->
                <div class="text-center">
                    <p class="mb-0">&copy; 2025 CSJM Government Polytechnic Ambedkar Nagar Boys Hostel. All Rights
                        Reserved.</p>
                </div>
            </div>
        </footer>
        <!-- Footer End -->
    </div>

    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>