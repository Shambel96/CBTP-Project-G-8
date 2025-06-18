<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - Administration Project</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .contact-header {
      background: linear-gradient(to right, #1e3a5f, #3a6073);
      color: white;
      padding: 10px 0 50px;
    }

    .contact-header h1 {
      font-size: 2.5rem;
      font-weight: bold;
    }

    .form-control,
    .btn {
      border-radius: 5px;
    }

    .contact-info i {
      font-size: 1.5rem;
      color: #1e3a5f;
    }

    .contact-info {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-info h5 {
      font-weight: bold;
      color: #1e3a5f;
    }

    footer {
      background: #1e3a5f;
      color: white;
      padding: 10px 0;
      text-align: center;
      margin-top: 40px;
    }

    .homeContact {
      float: left;
      padding-left: 10px;
    }

    .about-floatright {
      float: right;
      padding-right: 20px;
    }

    @media (max-width: 576px) {

      .homeContact,
      .about-floatright {
        float: none;
        display: block;
        text-align: center;
        padding: 0;
      }

      .contact-header .row {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <!-- Header Section -->
  <header class="contact-header text-center">
    <div class="container">
      <div class="row">
        <div class="col-6 text-start">
          <a
            href="index.php"
            class="text-decoration-none text-white homeContact">HOME</a>
        </div>
        <div class="col-6 text-end">
          <a
            href="about.html"
            class="text-decoration-none text-white about-floatright">ABOUT</a>
        </div>
      </div>
      <h1 class="mt-4">Contact Us</h1>
      <p>We are here to help you with your administrative queries.</p>
    </div>
  </header>

  <!-- Contact Section -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <!-- Contact Information -->
        <div class="col-md-4">
          <div class="contact-info text-center">
            <i class="fas fa-map-marker-alt"></i>
            <h5 class="mt-3">Our Address</h5>
            <p>123 Administration Street, Small Town, Country</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-info text-center">
            <i class="fas fa-phone-alt"></i>
            <h5 class="mt-3">Call Us</h5>
            <p>+123 456 7890</p>
            <p>+987 654 3210</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-info text-center">
            <i class="fas fa-envelope"></i>
            <h5 class="mt-3">Email Us</h5>
            <p>info@administration.com</p>
            <p>support@administration.com</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Send Us a Message</h2>
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success text-center">
              Thank you! Your message has been submitted.
            </div>
          <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
            <div class="alert alert-danger text-center">
              Sorry, there was a problem submitting your message. Please try again.
            </div>
          <?php endif; ?>
          <form
            action="contact_process.php"
            method="POST"
            class="p-4 shadow rounded bg-white"
            style="max-width: 600px; margin: auto">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="contactName" class="form-label"><i class="fa fa-user"></i> Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="contactName"
                  name="contactName"
                  placeholder="Enter your name"
                  required />
              </div>
              <div class="col-md-6">
                <label for="contactEmail" class="form-label"><i class="fa fa-envelope"></i> Email (optional)</label>
                <input
                  type="email"
                  class="form-control"
                  id="contactEmail"
                  name="contactEmail"
                  placeholder="Enter your email" />
              </div>
            </div>
            <div class="mt-3">
              <label for="contactPhone" class="form-label"><i class="fa fa-phone"></i> Phone (optional)</label>
              <input
                type="text"
                class="form-control"
                id="contactPhone"
                name="contactPhone"
                placeholder="Enter your phone number" />
            </div>
            <div class="mt-3">
              <label for="contactSubject" class="form-label"><i class="fa fa-tag"></i> Subject</label>
              <input
                type="text"
                class="form-control"
                id="contactSubject"
                name="contactSubject"
                placeholder="Subject"
                required />
            </div>
            <div class="mt-3">
              <label for="contactMessage" class="form-label"><i class="fa fa-comment-dots"></i> Message</label>
              <textarea
                class="form-control"
                id="contactMessage"
                name="contactMessage"
                rows="5"
                placeholder="Type your message here..."
                required></textarea>
            </div>
            <div class="mt-4 text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fa fa-paper-plane"></i> Send Message
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Ginjo. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>