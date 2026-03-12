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
    <!-- Rooms & Amenities Section Start -->
    <section class="rooms-amenities container my-5 animate-section">
        <h2 class="mb-4 animate-item">Rooms & Amenities</h2>
        <p class="animate-item">
            CSJM Boys Hostel offers **well-furnished, comfortable rooms** designed to provide students with a safe and
            productive environment. Every room is equipped with essential furniture, proper lighting, ventilation, and
            storage facilities to ensure convenience and comfort.
        </p>

        <div class="row g-4 mt-3">
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-house-door-fill display-4 text-primary mb-2"></i>
                    <h5>Spacious Rooms</h5>
                    <p>Single or shared occupancy rooms with comfortable beds, study tables, and wardrobes.</p>
                </div>
            </div>
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-cup-straw display-4 text-primary mb-2"></i>
                    <h5>Mess & Dining</h5>
                    <p>Nutritious meals served in a hygienic dining area with options for all dietary needs.</p>
                </div>
            </div>
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-shield-lock-fill display-4 text-primary mb-2"></i>
                    <h5>24/7 Security</h5>
                    <p>Safe living environment with CCTV surveillance and dedicated security personnel.</p>
                </div>
            </div>
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-lightbulb-fill display-4 text-primary mb-2"></i>
                    <h5>Study & Common Areas</h5>
                    <p>Quiet study rooms, recreation halls, and indoor activity spaces for a balanced life.</p>
                </div>
            </div>
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-wifi display-4 text-primary mb-2"></i>
                    <h5>Wi-Fi Connectivity</h5>
                    <p>Reliable internet connectivity to support academic and personal needs.</p>
                </div>
            </div>
            <div class="col-md-4 animate-item">
                <div class="amenity-card p-3 border rounded text-center h-100">
                    <i class="bi bi-droplet display-4 text-primary mb-2"></i>
                    <h5>Clean Washrooms</h5>
                    <p>Regularly maintained and hygienic washrooms with hot/cold water facilities.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Rooms & Amenities Section End -->

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