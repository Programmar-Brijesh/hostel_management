<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- main content start -->
    <!-- Contact Section Start -->
    <section id="contact" class="contact container my-5 animate-section">
        <h2 class="mb-4 animate-item">Contact Us</h2>
        <p class="animate-item">
            Have any questions or need assistance regarding <strong>college Boys Hostel</strong>?
            Reach out to us using the information below or send us a message directly through our contact form.
            Our team is always ready to assist you.
        </p>

        <div class="row g-4 mt-3">
            <!-- Contact Info -->
            <div class="col-md-4 animate-item">
                <div class="contact-info p-4 border rounded h-100">
                    <h5>Hostel Office</h5>
                    <p><strong>Address:</strong> college Government Polytechnic, Ambedkar Nagar, Uttar Pradesh, India</p>
                    <p><strong>Phone:</strong> +91-XXXXXXXXXX</p>
                    <p><strong>Email:</strong> hostel@gmail</p>
                    <p><strong>Office Hours:</strong> Mon - Fri, 9:00 AM - 5:00 PM</p>
                </div>
            </div>

            <!-- Emergency Contacts -->
            <div class="col-md-4 animate-item">
                <div class="emergency-contact p-4 border rounded h-100">
                    <h5>Emergency Contacts</h5>
                    <p><strong>Principal:</strong> +91-XXXXXXXXXX</p>
                    <p><strong> Warden:</strong> +91-XXXXXXXXXX</p>
                    <p><strong>Security:</strong> +91-XXXXXXXXXX</p>
                    <p><strong>Medical Help:</strong> +91-XXXXXXXXXX</p>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="col-md-4 animate-item">
                <div class="social-links p-4 border rounded h-100 text-center">
                    <h5>Follow Us</h5>
                    <a href="#" class="me-3"><i class="fa-brands fa-facebook fs-3"></i></a>
                    <a href="#" class="me-3"><i class="fa-brands fa-instagram fs-3"></i></a>
                    <a href="#" class="me-3"><i class="fa-brands fa-twitter fs-3"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube fs-3"></i></a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row g-4 mt-5">
            <div class="col-md-12 animate-item">
                <div class="contact-form p-4 border rounded">
                    <h5>Send Us a Message</h5>

                    <form action="php_code/save_enquiry.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="your@email.com" required>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4"
                                placeholder="Your message..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>

                </div>
            </div>
        </div>


        <!-- Location Map -->
        <div class="mt-5 animate-item">
            <h5>Our Location</h5>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="350" style="border:0;"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Sticky Quick Enquiry Button -->
    <a href="#contact"
        class="quick-enquiry-btn position-fixed bottom-0 end-0 m-4 p-3 bg-primary text-white rounded-circle shadow-lg"
        style="z-index:9999; font-size:1.5rem; text-decoration:none;">
        <i class="bi bi-envelope-fill"></i>
    </a>

    <!-- main content end -->

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
                            <i class="bi bi-envelope-fill"></i> info@collegehostel.edu.in
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