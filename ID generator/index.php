<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ginjo Administration Service...</title>
  <link rel="icon" href="images/sample_image/28.04.2025_23.30.08_REC.png" type="image/x-icon">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="Css/bootstrap.css" />
  <link rel="stylesheet" href="Css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    .service-card {
      transition: transform 0.3s, box-shadow 0.3s;
      background: linear-gradient(135deg, #f8fafc 80%, #e9ecef 100%);
      position: relative;
      overflow: hidden;
    }

    .service-card:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 8px 32px rgba(67, 97, 238, 0.15);
      background: linear-gradient(135deg, #e0e7ff 80%, #f8fafc 100%);
    }

    .service-card:hover .service-icon {
      transform: scale(1.2) rotate(-8deg);
    }

    @media (max-width: 767px) {
      .service-card {
        margin-bottom: 1.5rem;
      }
    }

    .service-icon {
      transition: transform 0.3s;
    }

    .logo-container img {
      width: 25%;
    }

    .services-sidebar ul li a:hover {
      border: 1px solid gray;
      padding: 3px;
      margin: 0 5px;
      background-color: blue;
      opacity: 0.8;
      border-radius: 5px;
      color: white;
    }

    .fab {
      font-size: 30px;
    }

    .btn-container-in-hero a button {
      background-color: rgba(255, 165, 0, 0.8);
      font-size: 18px;
      color: white;
      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

      &:hover {
        /* background-color: rgba(255, 165, 0, 1); */
        background-color: #f8f8f8;
        color: black;
      }
    }

    @media screen and (max-width:600px) {
      .btn-container-in-hero a button {
        width: 50%;
        padding: 7px 0;
      }

      .first-section {
        border-bottom-right-radius: 90%;
        border-bottom-left-radius: 80%;
      }
    }

    .services-hover:hover .services-sidebar {
      display: block !important;
      z-index: 10;
    }

    .services-sidebar {
      border-radius: 8px;
      min-width: 180px;
      border: 1px solid #e9ecef;
    }

    .services-sidebar ul li a:hover {
      background-color: #4361ee;
      color: #fff !important;
      border-radius: 5px;
    }

    @media (max-width: 767px) {
      .footer_ginjo img {
        width: 50% !important;
      }

      .services-sidebar {
        left: 0 !important;
        top: 100% !important;
      }
    }

    footer {
      font-family: Georgia, 'Times New Roman', Times, serif;
    }
  </style>
</head>

<body>
  <!-- A -->
  <?php
  include("header.php");
  ?>
  <section class="first-section py-5">
    <div class="insider-wrapper">
      <div class="container text-center py-5">

        <div class="d-none col-4 col-md-6"></div>
        <div class="col-12 col-lg-6">
          <p class="animated-text">
          <h1 class="display-4 fw-bold text-capitalize">welcome to Ginjo!</h1>
          The place where you can find everything in one: Residence ID ,
          birth certificates, death certificates, and marriage certificates and etc..
          </p>
          <div class="btn-container-in-hero">
            <a href="ID_homePage.Php"><button class="p-2 rounded-2">Get Residence ID</button></a>
            <a href="Certificate_index.php"><button class="p-2 rounded-2">Apply for Certificate</button></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="second-section py-5 bg-light">
    <div class="container">
      <div class="row">
        <!-- Image Gallery Section -->
        <div class="col-md-6">
          <div
            id="imageGallery"
            class="carousel slide"
            data-bs-ride="carousel">
            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
              <button
                type="button"
                data-bs-target="#imageGallery"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"></button>
              <button
                type="button"
                data-bs-target="#imageGallery"
                data-bs-slide-to="1"
                aria-label="Slide 2"></button>
              <button
                type="button"
                data-bs-target="#imageGallery"
                data-bs-slide-to="2"
                aria-label="Slide 3"></button>
              <button
                type="button"
                data-bs-target="#imageGallery"
                data-bs-slide-to="3"
                aria-label="Slide 4"></button>
            </div>

            <!-- Carousel Images -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img
                  src="images/sample_image/images.jpg"
                  class="d-block w-100"
                  alt="First Image" />
              </div>
              <div class="carousel-item">6
                <img
                  src="images/sample_image/Map-of-Ginjo-Guduru-kebele-showing-the-pilot-scale-treatment-system-installation-area.png"
                  class="d-block w-100"
                  alt="Second Image" />
              </div>
              <div class="carousel-item">
                <img
                  src="images/sample_image/images.jpg"
                  class="d-block w-100"
                  alt="Third Image" />
              </div>
              <div class="carousel-item">
                <img
                  src="images/sample_image/Map-of-Ginjo-Guduru-kebele-showing-the-pilot-scale-treatment-system-installation-area.png"
                  class="d-block w-100"
                  alt="Fourth Image" />
              </div>
            </div>

            <!-- Carousel Controls -->
            <button
              class="carousel-control-prev"
              type="button"
              data-bs-target="#imageGallery"
              data-bs-slide="prev">
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button
              class="carousel-control-next"
              type="button"
              data-bs-target="#imageGallery"
              data-bs-slide="next">
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        <!-- Project Description Section -->
        <div class="col-md-6">
          <h2 class="mb-4">About Ginjo Kebele</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Repudiandae dicta itaque, iure obcaecati alias tempora
            perferendis, necessitatibus voluptas deleniti aut explicabo ex
            harum optio recusandae non asperiores corporis nemo atque.
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Repudiandae dicta itaque, iure obcaecati alias tempora
            perferendis, necessitatibus voluptas deleniti aut explicabo ex
            harum optio recusandae non asperiores corporis nemo atque.
          </p>
          <div class="read-more-btn btn">
            <!-- <button class="p-2 rounded bg-body-secondary"> -->
            <a href="about.html" class="text-decoration-none"><button
                class="p-2 rounded bg-body-secondary fw-bolder text-dark">
                Read More
              </button></a>
            <!--  </button> -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div>
      <div class="left-wrapper-bcg-image"></div>
    </div>
  </section>
  <section class="third-section py-5 my-3">
    <div class="container">
      <h2 class="text-center fs-2 mb-4">Our Services</h2>
      <div class="row g-4 justify-content-center">
        <!-- Service Card 1 -->
        <div class="col-md-3 col-sm-6">
          <div class="service-card border rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <i class="fa-solid fa-id-card fs-1 mb-3 text-primary service-icon" aria-hidden="true"></i>
            <h3 class="fs-4">ID Generate</h3>
            <p>
              Instantly generate your official Residence ID with our secure and easy-to-use system.
            </p>
          </div>
        </div>
        <!-- Service Card 2 -->
        <div class="col-md-3 col-sm-6">
          <div class="service-card border rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <i class="fa-solid fa-certificate fs-1 mb-3 text-success service-icon" aria-hidden="true"></i>
            <h3 class="fs-4">Birth Certificate</h3>
            <p>
              Apply for and manage birth certificates for yourself or your family members online.
            </p>
          </div>
        </div>
        <!-- Service Card 3 -->
        <div class="col-md-3 col-sm-6">
          <div class="service-card border rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
            <i class="fa-solid fa-ring fs-1 mb-3 text-warning service-icon" aria-hidden="true"></i>
            <h3 class="fs-4">Marriage Certificate</h3>
            <p>
              Secure your marriage certificate quickly and conveniently through our digital platform.
            </p>
          </div>
        </div>
        <!-- Service Card 4 -->
        <div class="col-md-3 col-sm-6">
          <div class="service-card border rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
            <i class="fa-solid fa-cross fs-1 mb-3 text-danger service-icon" aria-hidden="true"></i>
            <h3 class="fs-4">Death Certificate</h3>
            <p>
              Request and track death certificates with ease, ensuring timely and accurate documentation.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="fourth-section" id="faq-section">
    <div class="fourth-div-wrapper container row">
      <div class="col-12 col-md-6"><img src="images/At the office-amico.svg" alt="Workers in Bureau"></div>
      <div class="col-12 col-md-6">
        <h3 class="text-center mt-4 mb-4">Frequently Asked Questions (FAQs)</h3>

        <div class="faq-wrapper">
          <!-- FAQ 1 -->
          <div class="faq-item">
            <button class="faq-button">Who qualifies for each service (Eligibility Criteria)?</button>
            <p class="faq-answer">Eligibility criteria vary by service. For example, to apply for a Residence ID, you must be a resident of the sub-city and provide proof of residency. For birth and marriage certificates, supporting documents like hospital records or a marriage license are required.</p>
          </div>

          <!-- FAQ 2 -->
          <div class="faq-item">
            <button class="faq-button">What documents are needed to apply (Required Documents)?</button>
            <p class="faq-answer">Required documents include a valid photo ID, proof of residency, and specific documents based on the service. For example, birth registration requires hospital records, and marriage registration requires a marriage license.</p>
          </div>

          <!-- FAQ 3 -->
          <div class="faq-item">
            <button class="faq-button">How long does the process take (Processing Time)?</button>
            <p class="faq-answer">Processing times vary by service. Residence IDs usually take 3-5 business days, while certificates (birth, death, marriage) may take 2-7 business days depending on the type of service and document verification.</p>
          </div>

          <!-- FAQ 4 -->
          <div class="faq-item">
            <button class="faq-button">Are there any fees for services (Fees)?</button>
            <p class="faq-answer">Yes, fees apply for some services. For example, a new Residence ID may cost $10, while a certified copy of a certificate (birth, death, marriage) may cost $5. Fees are displayed during the application process.</p>
          </div>

          <!-- FAQ 5 -->
          <div class="faq-item">
            <button class="faq-button">How do I register for a new Residence ID?</button>
            <p class="faq-answer">To register for a new Residence ID, go to the "Residence ID Application" section of the website, fill out your personal details, upload the required documents, and submit your application.</p>
          </div>

          <!-- FAQ 6 -->
          <div class="faq-item">
            <button class="faq-button">How can I renew or replace a lost Residence ID?</button>
            <p class="faq-answer">To renew or replace a lost Residence ID, visit the "Renewal and Replacement" section, provide your existing ID details or lost ID information, and submit the required documents.</p>
          </div>

          <!-- FAQ 7 -->
          <div class="faq-item">
            <button class="faq-button">How do I register a new birth?</button>
            <p class="faq-answer">To register a new birth, go to the "Birth Certificate" section, fill in the child’s details, and provide supporting documents like the parent's ID and hospital records.</p>
          </div>

          <!-- FAQ 8 -->
          <div class="faq-item">
            <button class="faq-button">How can I request a certified copy of a marriage certificate?</button>
            <p class="faq-answer">To request a certified copy of a marriage certificate, go to the "Marriage Certificate" section, provide the marriage details, and pay the applicable fee.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer-part starting here  -->
  <footer class="bg-dark text-white py-4 position-relative" style="border-top: 4px solid #4361ee; background: linear-gradient(135deg, #212529 80%, #3f37c9 100%);">
    <div class="container-fluid">
      <div class="row">
        <!-- Brand Section -->
        <div class="footer_ginjo col-md-3 text-center mb-4 mb-md-0 pt-5">
          <a href="#" class="text-white text-decoration-none">
            <img class="w-25 rounded-4" src="images/sample_image/28.04.2025_23.31.03_REC.png" alt="Ginjo Logo">
          </a>
        </div>
        <!-- Quick Links Section -->
        <div class="col-md-3 mb-4 mb-md-0 lh-5 position-relative">
          <h5 class="fw-bold">Quick Links</h5>
          <ul class="list-unstyled lh-3">
            <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li><a href="about.php" class="text-white text-decoration-none">About</a></li>
            <li class="position-relative services-hover-footer" style="cursor: pointer">
              <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                Services
                <i class="fa-solid fa-angle-right ms-2"></i>
              </a>
              <!-- Sidebar for Services (footer) -->
              <div class="services-sidebar-footer position-absolute bg-light text-dark shadow" style="display:none; min-width:200px; left:40%; top:0; z-index:100;">
                <ul class="list-unstyled m-0">
                  <li>
                    <a href="ID_homePage.Php" target="_blank" class="d-block py-2 px-3 text-decoration-none">
                      <i class="fa-solid fa-id-card me-2 text-primary"></i>ID
                    </a>
                  </li>
                  <li>
                    <a href="Certificate_index.php" target="_blank" class="d-block py-2 px-3 text-decoration-none">
                      <i class="fa-solid fa-certificate me-2 text-success"></i>Birth Certificate
                    </a>
                  </li>
                  <li>
                    <a href="Certificate_index.php" target="_blank" class="d-block py-2 px-3 text-decoration-none">
                      <i class="fa-solid fa-cross me-2 text-danger"></i>Death Certificate
                    </a>
                  </li>
                  <li>
                    <a href="Certificate_index.php" target="_blank" class="d-block py-2 px-3 text-decoration-none">
                      <i class="fa-solid fa-ring me-2 text-warning"></i>Marriage Certificate
                    </a>
                  </li>
                  <li>
                    <a href="#" target="_blank" class="d-block py-2 px-3 text-decoration-none">
                      <i class="fa-solid fa-ellipsis-h me-2 text-secondary"></i>Others
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li><a href="Map_ginjo.php" target="_blank" class="text-white text-decoration-none">Map of Ginjo</a></li>
          </ul>
        </div>
        <!-- Support Section -->
        <div class="col-md-3 mb-4 mb-md-0">
          <h5 class="fw-bold">Support</h5>
          <ul class="list-unstyled lh-3">
            <li><a href="#" target="_blank" class="text-white text-decoration-none">Privacy Policy</a></li>
            <li><a href="#" target="_blank" class="text-white text-decoration-none">Terms of Service</a></li>
          </ul>
        </div>
        <!-- About us Section -->
        <div class="col-md-3 lh-5">
          <h5 class="fw-bold">Contacts</h5>
          <ul class="list-unstyled lh-3">
            <li>
              <i class="fa-solid fa-location-dot"></i>
              <a href="#" class="text-white text-decoration-none"> Jimma, Oromia, Ethiopia</a>
            </li>
            <li>
              <i class="fa-solid fa-phone"></i>
              <a href="tel:+1234567890" class="text-white text-decoration-none"> +251-987-987-998</a>
            </li>
            <li>
              <i class="fa-solid fa-envelope"></i><a href="mailto:ginjoadministration@gmail.com" class="text-white text-decoration-none"> Ginjoadmin@gmail.com</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Footer Bottom Section -->
      <div class="row mt-4">
        <div class="col-12 text-end mb-2">
          <h5 class="fw-bold">Socials!</h5>
          <div>
            <a href="#" class="text-decoration-none text-white me-3"><i class="fab fa-facebook fa-2x" style="color: #1877f3;"></i></a>
            <a href="#" class="text-decoration-none text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
            <a href="#" class="text-decoration-none text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="#" class="text-decoration-none text-white me-3"><i class="fab fa-telegram fa-2x"></i></a>
          </div>
        </div>
        <hr class="bg-light" />
        <div class="col text-center">
          <p class="mb-0">&copy; 2025 Ginjo Administration. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script>
    // JavaScript to toggle FAQ answers dynamically
    document.addEventListener("DOMContentLoaded", function() {
      const faqButtons = document.querySelectorAll(".faq-button");

      faqButtons.forEach((button) => {
        button.addEventListener("click", function() {
          const answer = this.nextElementSibling;

          // Toggle answer visibility
          if (answer.style.display === "none" || !answer.style.display) {
            answer.style.display = "block";
          } else {
            answer.style.display = "none";
          }
        });
      });
    });

    // Animate cards with delay on scroll into view
    document.addEventListener("DOMContentLoaded", function() {
      const cards = document.querySelectorAll('.service-card');
      cards.forEach((card, idx) => {
        card.style.opacity = 0;
        card.style.transform = "translateY(40px)";
      });

      function animateCards() {
        cards.forEach((card, idx) => {
          const rect = card.getBoundingClientRect();
          if (rect.top < window.innerHeight - 50) {
            setTimeout(() => {
              card.classList.add('animate__fadeInUp');
              card.style.opacity = 1;
              card.style.transform = "none";
            }, idx * 120);
          }
        });
      }
      window.addEventListener('scroll', animateCards);
      animateCards();
    });

    document.addEventListener('DOMContentLoaded', function() {
      const hoverFooter = document.querySelector('.services-hover-footer');
      const sidebarFooter = document.querySelector('.services-sidebar-footer');
      if (hoverFooter && sidebarFooter) {
        hoverFooter.addEventListener('mouseenter', () => {
          sidebarFooter.style.display = 'block';
        });
        hoverFooter.addEventListener('mouseleave', () => {
          sidebarFooter.style.display = 'none';
        });
      }
    });
  </script>
</body>

</html>
<!-- <section>
  <p class="small thanks justify w-900 padding-left">
    *Thanks for the illustration:
    <a
      class="link colorful-letter"
      href="https://storyset.com/work"
      target="_blank"
      >work illustrations</a
    >
    by Storyset
  </p>
  <p class="small thanks justify w-900 padding-left">
    *Thanks for the icons:
    <span
      ><a
        class="link colorful-letter"
        href="https://www.iconfinder.com/Flatart"
        target="_blank"
        >flatart,
      </a></span
    >
    <span
      ><a
        class="link colorful-letter"
        href="https://www.iconfinder.com/font-awesome"
        target="_blank"
        >font awesome,
      </a></span
    >
    <span
      ><a
        class="link colorful-letter"
        href="https://www.iconfinder.com/fluent-designsystem"
        target="_blank"
        >microsoft,
      </a></span
    >
    <span
      ><a
        class="link colorful-letter"
        href="https://www.iconfinder.com/Chanut-is"
        target="_blank"
        >chanut is indurstries,
      </a></span
    >
    <span
      ><a
        class="link colorful-letter"
        href="https://www.iconfinder.com/Kalashnyk"
        target="_blank"
        >kalash
      </a></span
    >
    on Iconfinder
  </p>
</section> -->