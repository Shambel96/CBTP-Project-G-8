<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ginjo Kebele - Certificate Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)),
                url('https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1790&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .btn-primary {
            background-color: var(--secondary);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            margin-bottom: 40px;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary);
        }

        .certificate-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }

        .certificate-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--secondary);
        }

        .birth-card .card-header {
            background-color: #d4edda;
            color: #155724;
        }

        .marriage-card .card-header {
            background-color: #e2e3f3;
            color: #383d7a;
        }

        .death-card .card-header {
            background-color: #f8d7da;
            color: #721c24;
        }

        .card-header {
            border-bottom: none;
            padding: 20px;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .features {
            background-color: var(--light);
            padding: 80px 0;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .feature-box {
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 50px 0 20px;
        }

        .footer-links a {
            color: var(--light);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .footer-links a:hover {
            color: var(--secondary);
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .social-icons a:hover {
            color: var(--secondary);
        }

        .certificate-steps {
            padding: 80px 0;
        }

        .step {
            display: flex;
            margin-bottom: 30px;
            align-items: center;
        }

        .step-number {
            background-color: var(--secondary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 20px;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Oromia.png" alt="Ginjo Kebele" height="40" class="me-2">
                Ginjo Kebele
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#certificates">Certificates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary" href="signin.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Ginjo Kebele Certificate Services</h1>
            <p>Official document services for residents of Ginjo Kebele, Jimma. Apply for birth, marriage, and death certificates online or in person.</p>
            <a href="#certificates" class="btn btn-primary btn-lg">View Certificates</a>
        </div>
    </section>

    <!-- Certificates Section -->
    <section id="certificates" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Our Certificate Services</h2>

            <div class="row">
                <!-- Birth Certificate -->
                <div class="col-md-4">
                    <div class="certificate-card birth-card">
                        <div class="card-header">
                            <i class="fas fa-baby card-icon"></i>
                            <h3>Birth Certificate</h3>
                        </div>
                        <div class="card-body">
                            <p>Official registration of birth for children born in Ginjo Kebele. Required for school enrollment, national ID application, and other legal purposes.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Legal proof of identity</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Required for school admission</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Valid for lifetime</li>
                            </ul>
                            <div class="d-grid mt-4">
                                <a href="ApplicationForm.php" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Marriage Certificate -->
                <div class="col-md-4">
                    <div class="certificate-card marriage-card">
                        <div class="card-header">
                            <i class="fas fa-ring card-icon"></i>
                            <h3>Marriage Certificate</h3>
                        </div>
                        <div class="card-body">
                            <p>Legal documentation of marriage solemnized in Ginjo Kebele. Required for family legal matters, joint accounts, and immigration purposes.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Proof of marital status</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Required for family legal matters</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Valid for lifetime</li>
                            </ul>
                            <div class="d-grid mt-4">
                                <a href="ApplicationForm.php" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Death Certificate -->
                <div class="col-md-4">
                    <div class="certificate-card death-card">
                        <div class="card-header">
                            <i class="fas fa-cross card-icon"></i>
                            <h3>Death Certificate</h3>
                        </div>
                        <div class="card-body">
                            <p>Official record of death for residents of Ginjo Kebele. Required for inheritance matters, insurance claims, and legal proceedings.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Legal proof of death</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Required for inheritance</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Required for insurance claims</li>
                            </ul>
                            <div class="d-grid mt-4">
                                <a href="ApplicationForm.php" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="certificate-steps bg-light">
        <div class="container">
            <h2 class="text-center section-title">How to Get Your Certificate</h2>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div>
                            <h4>Prepare Required Documents</h4>
                            <p>Gather all necessary documents such as identification, proof of residence, and supporting evidence depending on the certificate type.</p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">2</div>
                        <div>
                            <h4>Submit Your Application</h4>
                            <p>Apply online through our portal or visit Ginjo Kebele office in person to submit your application with the required documents.</p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">3</div>
                        <div>
                            <h4>Verification Process</h4>
                            <p>Our staff will verify your information and documents. This typically takes 3-5 working days.</p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">4</div>
                        <div>
                            <h4>Receive Your Certificate</h4>
                            <p>Once approved, you can collect your certificate from our office or receive it digitally via email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-clock feature-icon"></i>
                        <h3>Fast Processing</h3>
                        <p>Our streamlined process ensures you receive your certificates in the shortest time possible.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h3>Secure & Official</h3>
                        <p>All certificates are legally binding and secured with official seals and serial numbers.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-headset feature-icon"></i>
                        <h3>Support Available</h3>
                        <p>Our team is ready to assist you with any questions about the application process.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    include("footer.php");
    ?>
    <!-- Footer -->
    <!--    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Ginjo Kebele</h5>
                    <p>Providing essential administrative services to residents of Ginjo Kebele, Jimma, Oromia.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <div class="footer-links">
                        <a href="#certificates">Certificate Services</a>
                        <a href="#how-it-works">Application Process</a>
                        <a href="#">Fee Schedule</a>
                        <a href="#">FAQs</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Ginjo Kebele Office, Jimma</p>
                    <p><i class="fas fa-phone me-2"></i> +251 47 111 2233</p>
                    <p><i class="fas fa-envelope me-2"></i> info@ginjokebele.gov.et</p>
                    <p><i class="fas fa-clock me-2"></i> Mon-Fri: 8:30 AM - 4:30 PM</p>
                </div>
            </div>
            <hr class="mt-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center pt-3">
                <p class="small">&copy; 2023 Ginjo Kebele Administration. All rights reserved.</p>
            </div>
        </div>
    </footer> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>