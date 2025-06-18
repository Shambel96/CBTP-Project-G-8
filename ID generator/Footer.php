<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <title>Document</title>
  <style>
    @media (max-width: 900px) {
      footer>div[style*="display: flex"] {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0 !important;
      }

      footer>div>div {
        min-width: 220px !important;
        width: 100% !important;
        text-align: center !important;
      }
    }

    footer a:hover {
      color: #4cc9f0 !important;
    }
  </style>
</head>

<body>
  <footer
    style="
        background: linear-gradient(135deg, #212529 80%, #3f37c9 100%);
        color: #f8f9fa;
        padding: 40px 0 0 0;
      ">
    <div
      style="
          max-width: 1100px;
          margin: 0 auto;
          display: flex;
          flex-wrap: wrap;
          justify-content: space-between;
          gap: 30px;
        ">
      <!-- About Section -->
      <div style="flex: 1 1 220px; min-width: 200px; margin-bottom: 20px">
        <h4
          style="font-size: 1.2rem; margin-bottom: 12px; letter-spacing: 1px">
          Ginjo Administration
        </h4>
        <p style="font-size: 0.95rem; line-height: 1.6">
          Digital ID & Certificates provides secure, fast, and reliable
          digital identity and certificate management for everyone.
        </p>
      </div>
      <!-- Quick Links -->
      <div style="flex: 1 1 150px; min-width: 150px; margin-bottom: 20px">
        <h4 style="font-size: 1.2rem; margin-bottom: 12px">Quick Links</h4>
        <ul style="list-style: none; padding: 0; font-size: 0.95rem">
          <li>
            <a
              href="#services"
              style="
                  color: #f8f9fa;
                  text-decoration: none;
                  transition: color 0.2s;
                ">Our Services</a>
          </li>
          <li>
            <a
              href="#about"
              style="
                  color: #f8f9fa;
                  text-decoration: none;
                  transition: color 0.2s;
                ">About Us</a>
          </li>
          <li>
            <a
              href="#contact"
              style="
                  color: #f8f9fa;
                  text-decoration: none;
                  transition: color 0.2s;
                ">Contact</a>
          </li>
          <li>
            <a
              href="#faq"
              style="
                  color: #f8f9fa;
                  text-decoration: none;
                  transition: color 0.2s;
                ">FAQs</a>
          </li>
        </ul>
      </div>
      <!-- Social Media -->
      <div style="flex: 1 1 150px; min-width: 150px; margin-bottom: 20px">
        <h4 style="font-size: 1.2rem; margin-bottom: 12px">Follow Us</h4>
        <div style="display: flex; gap: 16px">
          <a
            href="https://facebook.com"
            target="_blank"
            style="color: #1877f3; font-size: 1.7rem"><i class="fab fa-facebook"></i></a>
          <a
            href="https://twitter.com"
            target="_blank"
            style="color: #1da1f2; font-size: 1.7rem"><i class="fab fa-twitter"></i></a>
          <a
            href="https://instagram.com"
            target="_blank"
            style="color: #e4405f; font-size: 1.7rem"><i class="fab fa-instagram"></i></a>
          <a
            href="https://linkedin.com"
            target="_blank"
            style="color: #0a66c2; font-size: 1.7rem"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
      <!-- Contact -->
      <div style="flex: 1 1 200px; min-width: 180px; margin-bottom: 20px">
        <h4 style="font-size: 1.2rem; margin-bottom: 12px">Contact</h4>
        <p style="font-size: 0.95rem; margin-bottom: 7px">
          <i class="fas fa-envelope me-2"></i>
          <a
            href="mailto:support@example.com"
            style="color: #f8f9fa; text-decoration: none">support@example.com</a>
        </p>
        <p style="font-size: 0.95rem; margin-bottom: 7px">
          <i class="fas fa-phone me-2"></i>
          +123 456 7890
        </p>
        <p style="font-size: 0.95rem">
          <i class="fas fa-map-marker-alt me-2"></i>
          Ginjo, Jimma, Ethiopia
        </p>
      </div>
    </div>
    <div
      style="
          text-align: center;
          margin-top: 30px;
          font-size: 0.92rem;
          border-top: 1px solid #6c757d;
          padding: 18px 0 10px 0;
        ">
      &copy; 2025 Ginjo Administration. All rights reserved.
    </div>
  </footer>
  <!-- Font Awesome CDN for icons -->
  <script
    src="https://kit.fontawesome.com/a076d05399.js"
    crossorigin="anonymous"></script>
</body>

</html>