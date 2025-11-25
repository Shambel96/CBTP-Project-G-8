<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Css/header-style.css" rel="stylesheet">
    <!-- Custom CSS -->

</head>

<body>
    <header class="header container-fluid text-white">
        <div class="container px-0">
            <div class="row align-items-center py-2 g-0">
                <!-- Logo Section -->
                <div class="col-6 col-md-4 logo-container ps-3 ps-md-0">
                    <img
                        class="logo rounded-4 img-fluid"
                        src="images/sample_image/28.04.2025_23.30.08_REC.png"
                        alt="Logo"
                        onerror="this.src='https://via.placeholder.com/150x60?text=Logo+Here'" />
                </div>

                <!-- Navigation Section -->
                <nav class="col-6 col-md-8 navbar navbar-expand-lg pe-3 pe-md-0">
                    <div class="container-fluid p-0">
                        <!-- Navbar Toggler (Right-Aligned) -->
                        <button
                            class="navbar-toggler ms-auto"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarNav"
                            aria-controls="navbarNav"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                            style="float: right;">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link active text-white">Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a
                                        href="#"
                                        class="nav-link dropdown-toggle text-white"
                                        id="servicesDropdown"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Services
                                    </a>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="servicesDropdown">
                                        <li>
                                            <a href="ID_homePage.Php" target="_blank" class="dropdown-item">Get Residence ID</a>
                                        </li>
                                        <li>
                                            <a href="Certificate_index.php" target="_blank" class="dropdown-item">Birth Certificate</a>
                                        </li>
                                        <li>
                                            <a href="Certificate_index.php" target="_blank" class="dropdown-item">Death Certificate</a>
                                        </li>
                                        <li>
                                            <a href="Certificate_index.php" target="_blank" class="dropdown-item">Marriage Certificate</a>
                                        </li>
                                        <li><a href="#" class="dropdown-item">Others</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="contact.php"
                                        target="_blank" class="nav-link text-white">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#faq-section" class="nav-link text-white">FAQs</a>
                                </li>
                            </ul>

                            <!-- Buttons -->
                            <div class="d-flex flex-column flex-lg-row ms-lg-3 align-items-center">
                                <?php if (isset($_SESSION['id'])): ?>
                                    <!-- User is logged in: show profile icon and link -->
                                    <a href="UserProfile/User_Profile.php" class="btn btn-outline-light fw-bold d-flex align-items-center" style="font-size:1.1rem;">
                                        <i class="fa fa-user-circle me-2" style="font-size:1.5rem;"></i> Profile
                                    </a>
                                <?php else: ?>
                                    <!-- Not logged in: show Login and Sign Up buttons -->
                                    <button class="btn btn-warning me-lg-2 mb-2 mb-lg-0 fw-bold">
                                        <a href="signin.php" class="text-decoration-none text-dark">Login</a>
                                    </button>
                                    <button class="btn btn-warning fw-bold">
                                        <a href="Signup.php" class="text-decoration-none text-dark">Sign Up</a>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active nav item based on current page
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                    // Remove active class from other links
                    navLinks.forEach(otherLink => {
                        if (otherLink !== link) {
                            otherLink.classList.remove('active');
                        }
                    });
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                    openDropdowns.forEach(dropdown => {
                        dropdown.classList.remove('show');
                    });
                }
            });

            // Mobile menu behavior
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navItems = document.querySelectorAll('.nav-item');

            navItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    // For mobile, close the whole menu when clicking a link
                    if (window.innerWidth < 992 && !e.target.classList.contains('dropdown-toggle')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }

                    // For desktop, prevent closing when clicking dropdown toggle
                    if (e.target.classList.contains('dropdown-toggle')) {
                        e.preventDefault();
                        const dropdown = e.target.closest('.dropdown');
                        const menu = dropdown.querySelector('.dropdown-menu');
                        menu.classList.toggle('show');
                    }
                });
            });

            // Handle logo error
            const logo = document.querySelector('.logo');
            logo.addEventListener('error', function() {
                this.src = 'https://via.placeholder.com/150x60?text=Logo+Here';
            });
        });
    </script>
</body>

</html>