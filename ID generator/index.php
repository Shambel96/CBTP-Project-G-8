<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Landing Page!!!</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="Css/bootstrap.css" />
  <link rel="stylesheet" href="Css/style.css" />

  <style>
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
  </style>
</head>

<body>
  <!-- A -->

  <header class="header container-fluid text-white">
    <div class="container">
      <div class="row align-items-center py-2">
        <!-- Logo Section -->
        <div class="col-4 logo-container">
          <!-- <h1 class="m-0">GINJO</h1> -->
          <img class=" logo  rounded-4" src="images/sample_image/28.04.2025_23.30.08_REC.png" alt="">
        </div>
        <!-- Navigation Section -->
        <nav class="col-8">
          <div class="d-flex justify-content-between align-items-center">
            <ul class="nav">
              <li class="nav-item">
                <a href="#" class="nav-link active text-white">Home</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link text-white">About</a>
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
                <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                  <li><a href="#" class="dropdown-item">ID</a></li>
                  <li>
                    <a href="#" class="dropdown-item">Birth Certificate</a>
                  </li>
                  <li>
                    <a href="#" class="dropdown-item">Death Certificate</a>
                  </li>
                  <li>
                    <a href="#" class="dropdown-item">Marriage Certificate</a>
                  </li>
                  <li><a href="#" class="dropdown-item">Others</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link text-white">Contact</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link text-white">FAQs</a>
              </li>
            </ul>
            <!-- Buttons -->
            <div class="buttons-in-header">
              <button class="btn btn-warning me-2 fw-bold">
                <a href="signin.php" class="text-decoration-none">Login</a>
              </button>
              <button class="btn btn-warning fw-bold">
                <a href="Signup.php" class="text-decoration-none">Sign Up</a>
              </button>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <section class="first-section py-5">
    <div class="insider-wrapper">
      <div class="container text-center py-5">

        <div class="col-6"></div>
        <div class="col-6">
          <p class="animated-text">
          <h1 class="display-4 fw-bold text-capitalize">welcome to Ginjo!</h1>
          The place where you can find everything in one: ID generator,
          birth certificates, death certificates, and marriage certificates.
          </p>
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
              <div class="carousel-item">
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
      <div class="row g-4">
        <!-- Service Card 1 -->
        <div class="col-md-3 col-sm-6">
          <div
            class="service-card border rounded shadow p-4 text-center h-100">
            <i
              class="fa-solid fa-id-card fs-1 mb-3 text-primary"
              aria-hidden="true"></i>
            <h3 class="fs-4">ID Generate</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet,
              officia aliquid inventore minima voluptatibus magni sed.
            </p>
          </div>
        </div>
        <!-- Service Card 2 -->
        <div class="col-md-3 col-sm-6">
          <div
            class="service-card border rounded shadow p-4 text-center h-100">
            <i
              class="fa-solid fa-id-card fs-1 mb-3 text-primary"
              aria-hidden="true"></i>
            <h3 class="fs-4">Birth Certificate</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet,
              officia aliquid inventore minima voluptatibus magni sed.
            </p>
          </div>
        </div>
        <!-- Service Card 3 -->
        <div class="col-md-3 col-sm-6">
          <div
            class="service-card border rounded shadow p-4 text-center h-100">
            <i
              class="fa-solid fa-id-card fs-1 mb-3 text-primary"
              aria-hidden="true"></i>
            <h3 class="fs-4">Marriage Certificate</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet,
              officia aliquid inventore minima voluptatibus magni sed.
            </p>
          </div>
        </div>
        <!-- Service Card 4 -->
        <div class="col-md-3 col-sm-6">
          <div
            class="service-card border rounded shadow p-4 text-center h-100">
            <i
              class="fa-solid fa-id-card fs-1 mb-3 text-primary"
              aria-hidden="true"></i>
            <h3 class="fs-4">Death Certificate</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet,
              officia aliquid inventore minima voluptatibus magni sed.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="fourth-section">
    <div class="fourth-div-wrapper"></div>
  </section>

  <!-- Footer-part starting here  -->
  <footer class="bg-dark text-white py-4 position-relative">
    <div class="container-fluid ">
      <div class="row">
        <!-- Brand Section -->
        <div class="footer_ginjo col-md-3 text-center mb-4 mb-md-0 pt-5">
          <a href="#" class="text-white text-decoration-none">
            <!--  <h1 class="fw-bold">Ginjo</h1> -->
            <img class="w-25 rounded-4" src="images/sample_image/28.04.2025_23.31.03_REC.png" alt="">
          </a>
        </div>

        <!-- Quick Links Section -->
        <div class="col-md-3 mb-4 mb-md-0 lh-5">
          <h5 class="fw-bold">Quick Links</h5>
          <ul class="list-unstyled lh-3">
            <li>
              <a href="#" class="text-white text-decoration-none">Home</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">About</a>
            </li>
            <li
              class="position-relative services-hover"
              style="cursor: pointer">
              <a href="#" class="text-white text-decoration-none">Services</a>
              <!-- Sidebar for Services -->
              <div
                class="services-sidebar position-absolute bg-light text-dark shadow">
                <ul class="list-unstyled m-0">
                  <li>
                    <a href="#" class="d-block py-2 px-3 text-decoration-none">ID</a>
                  </li>
                  <li>
                    <a href="#" class="d-block py-2 px-3 text-decoration-none">Birth Certificate</a>
                  </li>
                  <li>
                    <a href="#" class="d-block py-2 px-3 text-decoration-none">Death Certificate</a>
                  </li>
                  <li>
                    <a href="#" class="d-block py-2 px-3 text-decoration-none">Marriage Certificate</a>
                  </li>
                  <li>
                    <a href="#" class="d-block py-2 px-3 text-decoration-none">Others</a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Contact</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">FAQs</a>
            </li>
          </ul>
        </div>

        <!-- Support Section -->
        <div class="col-md-3 mb-4 mb-md-0 ">
          <h5 class="fw-bold">Support</h5>
          <ul class="list-unstyled lh-3">
            <li>
              <a href="#" class="text-white text-decoration-none">Blog</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Careers</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Privacy Policy</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Terms of Service</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Support</a>
            </li>
          </ul>
        </div>

        <!-- About us Section -->
        <div class="col-md-3 lh-5">
          <h5 class="fw-bold">About us</h5>
          <ul class="list-unstyled lh-3`">
            <li>
              <a href="#" class="text-white text-decoration-none">Partners</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Investors</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Media</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Resources</a>
            </li>
            <li>
              <a href="#" class="text-white text-decoration-none">Feedback</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Footer Bottom Section -->
      <div class="row mt-4 ">

        <h3 style="align-self: right;">Socials!</h3>
        <p style="float: right;">
          <a href="#" class="text-decoration-none text-white me-3">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="#" class="text-decoration-none text-white me-3">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-decoration-none text-white me-3">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-decoration-none text-white me-3">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-decoration-none text-white me-3">
            <i class="fab fa-brands fa-telegram"></i>
          </a>
        </p>
        <hr />
        <div class="col text-center">
          <p class="mb-0">&copy; 2025 Ginjo. All rights reserved.</p>

        </div>
      </div>
    </div>
  </footer>
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