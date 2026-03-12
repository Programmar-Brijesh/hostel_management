<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Official college Boys Hostel Management System for registered hostel students. Secure login, room details, attendance, leave requests and hostel notices.">
    <meta name="robots" content="index, follow">
    <meta name="author" content="college Boys Hostel">

    <title>college - BOYS HOSTEL</title>
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

    <div class="container-fluid">
        <!-- slider Start -->
        <div class="row">
            <div class="col-sm-12 mx-auto m-0 p-0">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/3.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/2.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/3.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/4.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/5.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="images/6.jpg" height="600px" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- slider end -->

        <!-- notice Start -->
        <div class="row mt-1">
            <div class="col-sm-1 notice-bg m-0"><strong style="margin-left: 15px;"><i class="fa-solid fa-bullhorn"
                        style="color: #ffffff;"></i> &nbsp; NOTICE</strong></div>
            <div class="col-sm-11 notice-object">
                <marquee behavior="" direction="left">HELLO EVERYONE ! THIS WEBSITE IS DEVELOPED BY BRIJESH VERMA.
                </marquee>
            </div>
        </div>
        <!-- notice end -->

        <!-- apply now start-->
        <div class="row">
            <div class="col-sm-6">
                <!-- Eligibility Section -->
                <section id="eligibility" class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="eligibility-card animate-section" role="region"
                                aria-labelledby="eligibility-heading">
                                <!-- Header -->
                                <div class="d-flex align-items-start justify-content-between mb-3 animate-item">
                                    <div>
                                        <h2 id="eligibility-heading" class="h4 mb-1" style="color:var(--college-navy);">
                                            Eligibility — Who Can Apply?</h2>
                                        <p class="mb-0" style="color:var(--text-dark);">
                                            Clear guidelines on who is eligible to apply for accommodation at
                                            <strong>college Government Polytechnic Ambedkar Nagar</strong>.
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge badge-priority px-3 py-2" style="border-radius: .5rem;">Apply
                                            Now</span>
                                    </div>
                                </div>

                                <!-- Eligible Applicants -->
                                <div class="mb-3 animate-item">
                                    <h3 class="h6" style="color:var(--college-navy);">Eligible Applicants</h3>
                                    <ul class="list-unstyled mb-0" aria-describedby="eligible-desc" id="eligible-desc"
                                        style="color:var(--text-dark);">
                                        <li class="mb-2">
                                            <span class="check">✔️</span>
                                            <strong>All officially enrolled students</strong> of <em>college Government
                                                Polytechnic Ambedkar Nagar</em>.
                                        </li>
                                        <li class="mb-2">
                                            <span class="check">✔️</span>
                                            <strong>Students from all academic years and courses</strong> — subject to
                                            room availability.
                                        </li>
                                        <li>
                                            <span class="check">✔️</span>
                                            <strong>Good academic & disciplinary standing required</strong>
                                            (applications from students with unresolved disciplinary issues may be
                                            reviewed).
                                        </li>
                                    </ul>
                                </div>

                                <!-- Priority -->
                                <div class="animate-item">
                                    <h3 class="h6" style="color:var(--college-navy);">Priority Criteria</h3>
                                    <p class="mb-2" style="color:var(--text-dark);">In case of limited seats, priority
                                        will be considered in the following order:</p>

                                    <ul class="list-group priority-list" style="color:var(--text-dark);">
                                        <li class="list-group-item d-flex align-items-start">
                                            <div class="me-3"><span class="badge badge-priority">1</span></div>
                                            <div>
                                                <strong>First-Year Students</strong><br>
                                                <small>To help new entrants settle smoothly into campus life.</small>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <div class="me-3"><span class="badge badge-priority">2</span></div>
                                            <div>
                                                <strong>Outstation Students</strong><br>
                                                <small>Students who live far from campus or require accommodation due to
                                                    distance.</small>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <div class="me-3"><span class="badge badge-priority">3</span></div>
                                            <div>
                                                <strong>Meritorious Students</strong><br>
                                                <small>Consideration based on academic performance and conduct
                                                    records.</small>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <div class="me-3"><span class="badge badge-priority">4</span></div>
                                            <div>
                                                <strong>Special Cases</strong><br>
                                                <small>Students with verified financial need, medical reasons, or other
                                                    exceptional circumstances (subject to warden approval).</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Note -->
                                <div class="mt-3 text-muted animate-item" style="font-size:.95rem;">
                                    <em>Note:</em> Final allotment is subject to room availability and verification of
                                    submitted documents. The hostel office reserves the right to decide in borderline
                                    cases.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- elegibility End -->

            </div>
            <!-- form start  -->
            <div class="col-sm-6">
                <div class="form-container">
                    <h2 class="mb-4 text-center">Apply for college Boys Hostel</h2>
                    <form action="php_code/apply_code.php" method="POST" enctype="multipart/form-data">
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name"
                                required>
                        </div>

                        <!-- Enrollment / Roll Number -->
                        <div class="mb-3">
                            <label for="enroll" class="form-label">Enrollment / Roll Number</label>
                            <input type="text" name="enroll" class="form-control" id="enroll"
                                placeholder="Enter your enrollment or roll number" required>
                        </div>

                        <!-- Course & Year (one line) -->
                        <div class="mb-3 d-flex gap-3">
                            <div class="flex-fill">
                                <label for="course" class="form-label">Course</label>
                                <input type="text" name="course" class="form-control" id="course" placeholder="Enter Course" required>
                            </div>
                            <div style="width: 120px;">
                                <label for="year" class="form-label">Year</label>
                                <input type="text" name="year" class="form-control" id="year" placeholder="Year" required>
                            </div>
                        </div>

                        <!-- Email & Mobile Number (one line) -->
                        <div class="mb-3 d-flex gap-3">
                            <div class="flex-fill">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                            </div>
                            <div style="width: 180px;">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="tel" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile" required>
                            </div>
                        </div>

                        <!-- Parent/Guardian Contact -->
                        <div class="mb-3">
                            <label for="guardianContact" class="form-label">Parent/Guardian Contact</label>
                            <input type="tel" name="guardianContact" class="form-control" id="guardianContact"
                                placeholder="Enter parent/guardian contact number" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea style="resize: none; height: 20px;" name="address" class="form-control" id="address" rows="2"
                                placeholder="Enter your address" required></textarea>
                        </div>

                        <!-- Upload Documents -->
                        <div class="mb-3">
                            <label class="form-label">Upload Photo</label>
                            <input type="file" name="photo" class="form-control mb-2" required> <!-- Photo -->
                        </div>

                        <!-- Checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agree" required>
                            <label class="form-check-label" for="agree">I agree to hostel rules & regulations</label>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Apply Now</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- form End -->
        </div>
        <!-- apply now end -->

        <div class="row">
            <!-- Footer Start -->
            <footer class="bg-dark text-light pt-5 pb-3">
                <div class="container">
                    <div class="row">
                        <!-- About Section -->
                        <div class="col-md-4 mb-4">
                            <h5>About college Boys Hostel</h5>
                            <p>
                                college Government Polytechnic Ambedkar Nagar Boys Hostel provides a safe and comfortable
                                living environment for students with modern amenities and dedicated staff support.
                            </p>
                        </div>

                        <!-- Quick Links -->
                        <div class="col-md-4 mb-4">
                            <h5>Quick Links</h5>
                            <ul class="list-unstyled">
                                <li><a href="index.php" class="text-light text-decoration-none">Home</a></li>
                                <li><a href="/index.php" class="text-light text-decoration-none">Apply Online</a></li>
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
                                <i class="bi bi-telephone-fill"></i> +91 8896199423<br>
                                <i class="bi bi-envelope-fill"></i> brijeshverma8896@gmail.com
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
                        <p class="mb-0">&copy; 2025 college Government Polytechnic Ambedkar Nagar Boys Hostel. All Rights
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