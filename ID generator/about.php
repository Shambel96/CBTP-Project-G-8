<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Our Subcity Administration</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="Css/About-style.css" />
  </head>
  <body>
    <?php
    include 'header.php';
    ?>
    <section class="container">
      <div class="box fade-in">
        <h1><i class="fas fa-city"></i> Who We Are</h1>
        <p>
          We are the local administration of Greenfield Subcity, dedicated to
          serving our community with integrity and innovation. Our team of
          professionals works tirelessly to ensure the smooth operation of
          municipal services and the well-being of all residents.
        </p>
        <p>
          Established in 2005, we've grown from a small township office to a
          full-service subcity administration, now serving over 50,000 residents
          across 12 neighborhoods.
        </p>

        <div class="stats-container">
          <div class="stat-box fade-in delay-1">
            <div class="stat-number">50K+</div>
            <div class="stat-label">Residents</div>
          </div>
          <div class="stat-box fade-in delay-2">
            <div class="stat-number">12</div>
            <div class="stat-label">Neighborhoods</div>
          </div>
          <div class="stat-box fade-in delay-3">
            <div class="stat-number">15</div>
            <div class="stat-label">Years Serving</div>
          </div>
          <div class="stat-box fade-in delay-4">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Service</div>
          </div>
        </div>
      </div>

      <div class="box fade-in">
        <h1><i class="fas fa-eye"></i> Our Vision</h1>
        <p>
          We envision Greenfield Subcity as a model of sustainable urban
          development, where technology and community values work hand in hand
          to create a thriving, inclusive, and environmentally conscious
          municipality.
        </p>
        <p>
          Our goal is to be recognized as a leader in municipal innovation, with
          smart city solutions that improve quality of life while preserving our
          community's unique character and natural beauty.
        </p>

        <div class="icon-container">
          <div class="icon-box fade-in delay-1">
            <i class="fas fa-leaf"></i>
            <h3>Sustainability</h3>
            <p>Green initiatives for a cleaner future</p>
          </div>
          <div class="icon-box fade-in delay-2">
            <i class="fas fa-network-wired"></i>
            <h3>Smart City</h3>
            <p>Technology-driven solutions</p>
          </div>
          <div class="icon-box fade-in delay-3">
            <i class="fas fa-hands-helping"></i>
            <h3>Community</h3>
            <p>Strong neighborhood bonds</p>
          </div>
          <div class="icon-box fade-in delay-4">
            <i class="fas fa-chart-line"></i>
            <h3>Growth</h3>
            <p>Sustainable development</p>
          </div>
        </div>
      </div>

      <div class="box fade-in">
        <h1><i class="fas fa-bullseye"></i> Our Mission</h1>
        <p>
          To provide exceptional municipal services through transparent
          governance, innovative solutions, and community engagement. We are
          committed to making Greenfield Subcity a better place to live, work,
          and grow.
        </p>
        <p>
          Our administration focuses on four key pillars: infrastructure
          development, public safety, environmental sustainability, and
          community programs that enrich the lives of all residents.
        </p>

        <div class="icon-container">
          <div class="icon-box fade-in delay-1">
            <i class="fas fa-road"></i>
            <h3>Infrastructure</h3>
            <p>Modern roads and utilities</p>
          </div>
          <div class="icon-box fade-in delay-2">
            <i class="fas fa-shield-alt"></i>
            <h3>Public Safety</h3>
            <p>24/7 protection services</p>
          </div>
          <div class="icon-box fade-in delay-3">
            <i class="fas fa-recycle"></i>
            <h3>Environment</h3>
            <p>Eco-friendly policies</p>
          </div>
          <div class="icon-box fade-in delay-4">
            <i class="fas fa-users"></i>
            <h3>Community</h3>
            <p>Engagement programs</p>
          </div>
        </div>
      </div>
    </section>

    <script>
      // Animation trigger on scroll
      document.addEventListener("DOMContentLoaded", function () {
        const iconBoxes = document.querySelectorAll(".icon-box");

        const observer = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                entry.target.classList.add("animate");
              }
            });
          },
          { threshold: 0.1 }
        );

        iconBoxes.forEach((box) => {
          observer.observe(box);
        });

        // Animate stats on page load
        const statBoxes = document.querySelectorAll(".stat-box");
        statBoxes.forEach((box, index) => {
          setTimeout(() => {
            box.style.opacity = 1;
            box.style.transform = "translateY(0)";
          }, index * 200);
        });
      });
    </script>
  </body>
</html>
