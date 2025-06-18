<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ginjo Kebele - ID Generator!</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    /* Custom Styles */
    body {
      font-family: Arial, sans-serif;
    }

    .hero-section {
      background: linear-gradient(to right, #1e3a5f, #3a6073);
      color: white;
      padding: 50px 0;
    }

    .hero-section h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .hero-section p {
      font-size: 1.2rem;
    }

    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    footer {
      background-color: #1e3a5f;
      color: white;
    }

    footer a {
      text-decoration: none;
      color: #f8f9fa;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <!-- Hero Section -->
  <header class="shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
          <i class="fas fa-id-card"></i> Ginjo Kebele
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Signup.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#how-it-works">How It Works</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section class="hero-section text-center">
    <div class="container">
      <h1>Welcome to Ginjo Kebele ID Generator</h1>
      <p>
        Easily create and manage IDs for your community with our simple and
        efficient system.
      </p>
      <a href="IDuserRegistration.php" class="btn btn-warning btn-lg mt-3">Get Started</a>
    </div>
  </section>
  <!-- Features Section -->
  <section id="features" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Our Features</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card feature-card text-center py-4">
            <i class="fas fa-id-card fa-3x text-primary mb-3"></i>
            <h5 class="card-title">Easy ID Generation</h5>
            <p class="card-text">
              Quick and hassle-free process to generate IDs for residents.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card feature-card text-center py-4">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5 class="card-title">Verification System</h5>
            <p class="card-text">
              Efficient verification process to ensure data accuracy.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card feature-card text-center py-4">
            <i class="fas fa-database fa-3x text-warning mb-3"></i>
            <h5 class="card-title">Secure Data Storage</h5>
            <p class="card-text">
              All ID data is securely stored and easily retrievable.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- How It Works Section -->
  <section id="how-it-works" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5">How It Works</h2>
      <div class="row">
        <div class="col-md-4 text-center">
          <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
          <h5>Step 1: Register</h5>
          <p>Enter resident details to start the ID generation process.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
          <h5>Step 2: Submit</h5>
          <p>Submit the form and verify the details for accuracy.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-id-badge fa-3x text-warning mb-3"></i>
          <h5>Step 3: Generate ID</h5>
          <p>Generate and print the ID for the resident.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Contact Section -->
  <!--   <section id="contact" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Contact Us</h2>
      <form>
        <div class="row g-3 w-50 m-auto">
          <div class="col-md-12">
            <input
              type="text"
              class="form-control"
              placeholder="Name"
              required />
          </div>
          <div class="col-md-12">
            <input
              type="email"
              class="form-control"
              placeholder="Email"
              required />
          </div>
        </div>
        <div class="mt-3 w-50 m-auto">
          <textarea
            class="form-control"
            rows="5"
            placeholder="Message"
            required></textarea>
        </div>
        <div class="mt-3 text-center">
          <button type="submit" class="btn btn-primary btn-lg">
            Send Message
          </button>
        </div>
      </form>
    </div>
  </section> -->

  <!-- Footer -->
  <?php
  include("Footer.php");
  ?>
  <footer class="py-4">
    <div class="container text-center">
      <p>&copy; 2025 Ginjo Kebele. All Rights Reserved.</p>
      <p>
        <a href="#" class="me-3"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="me-3"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
      </p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>