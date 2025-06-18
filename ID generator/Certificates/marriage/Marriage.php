<?php

require_once("../../db_connection.php");

// Get certificate number from URL (e.g., Marriage.php?cert=MC-2023-014587)
$cert_number = isset($_GET['cert']) ? $_GET['cert'] : '';
if (!$cert_number) {
  echo "<div class='alert alert-danger'>No certificate number provided.</div>";
  exit;
}

// Fetch the marriage certificate data
$stmt = $conn->prepare("SELECT * FROM marriage_certificate WHERE certificate_number = ?");
$stmt->bind_param("s", $cert_number);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
  echo "<div class='alert alert-danger'>Certificate not found.</div>";
  exit;
}

// Handle groom and bride photo (supporting all image types)
$groom_photo_src = '';
if (!empty($data['groom_photo'])) {
  $groom_photo_type = !empty($data['groom_photo_type']) ? $data['groom_photo_type'] : 'image/jpeg';
  $groom_photo_src = "data:" . $groom_photo_type . ";base64," . base64_encode($data['groom_photo']);
}
$bride_photo_src = '';
if (!empty($data['bride_photo'])) {
  $bride_photo_type = !empty($data['bride_photo_type']) ? $data['bride_photo_type'] : 'image/jpeg';
  $bride_photo_src = "data:" . $bride_photo_type . ";base64," . base64_encode($data['bride_photo']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=800, initial-scale=1.0" />
  <title>Elegant Marriage Certificate</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400&family=Dancing+Script:wght@700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../CSS/marriage.css" />
  <style>
    @media print {
      body * {
        visibility: hidden !important;
      }

      #certificateToPrint,
      #certificateToPrint * {
        visibility: visible !important;
      }

      #certificateToPrint {
        position: absolute !important;
        left: 0;
        top: 0;
        width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        background: #fff !important;
        min-height: 0 !important;
        max-height: 100vh !important;
        overflow: hidden !important;
      }

      .print-btn {
        display: none !important;
      }
    }
  </style>
</head>

<body class="d-flex align-items-center py-4">
  <div class="container certificate-container" id="certificateToPrint">
    <div class="certificate-border position-relative">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4 certificate-header">
        <div class="seal-left">
          <div class="seal"></div>
        </div>
        <h1 class="text-center mx-3">Certificate of Marriage</h1>
        <div class="seal-right">
          <div class="seal"></div>
        </div>
      </div>

      <!-- Body -->
      <div class="certificate-body text-center">
        <p class="intro">This certifies that the union of marriage between</p>
        <div class="row align-items-center justify-content-center couple-names">
          <!-- Groom Section with Photo -->
          <div class="col-md-4 text-center">
            <div class="photo-container">
              <?php if ($groom_photo_src): ?>
                <img src="<?php echo $groom_photo_src; ?>" class="photo-preview" alt="Groom Photo">
              <?php else: ?>
                <div class="photo-placeholder">
                  Groom's Photo<br />(35mm x 45mm)
                </div>
              <?php endif; ?>
            </div>
            <div class="name groom mt-2">
              <h2><?php echo htmlspecialchars($data['groom_name']); ?></h2>
              <p class="title">Groom</p>
            </div>
          </div>
          <div class="col-md-1 text-center">
            <p class="and">&</p>
          </div>
          <!-- Bride Section with Photo -->
          <div class="col-md-4 text-center">
            <div class="photo-container">
              <?php if ($bride_photo_src): ?>
                <img src="<?php echo $bride_photo_src; ?>" class="photo-preview" alt="Bride Photo">
              <?php else: ?>
                <div class="photo-placeholder">
                  Bride's Photo<br />(35mm x 45mm)
                </div>
              <?php endif; ?>
            </div>
            <div class="name bride mt-2">
              <h2><?php echo htmlspecialchars($data['bride_name']); ?></h2>
              <p class="title">Bride</p>
            </div>
          </div>
        </div>
        <p class="declaration">
          was solemnized on this
          <span class="date"><?php echo htmlspecialchars($data['marriage_date']); ?></span>
        </p>
        <p class="location">
          in the city of <span>Jimma</span>,
          county of <span>Ethiopia</span>,
          state of <span>Oromia</span>
        </p>
        <div class="officiant">
          <p>Officiated by <span>Ginjo Administration</span></p>
        </div>
        <div class="d-flex justify-content-center gap-5 my-4 witnesses">
          <div class="witness">
            <p class="witness-name"><?php echo htmlspecialchars($data['witness1_name']); ?></p>
            <p class="witness-title">Witness</p>
          </div>
          <div class="witness">
            <p class="witness-name"><?php echo htmlspecialchars($data['witness2_name']); ?></p>
            <p class="witness-title">Witness</p>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="certificate-footer mt-5">
        <div class="d-flex justify-content-around signatures mb-4">
          <div class="signature text-center">
            <div class="signature-line"></div>
            <p>Officiant Signature</p>
          </div>
          <div class="signature text-center">
            <div class="signature-line"></div>
            <p>County Clerk Signature</p>
          </div>
        </div>
        <div class="certificate-number text-center">
          <p>Certificate Number: <span><?php echo htmlspecialchars($data['certificate_number']); ?></span></p>
          <p>Recorded on: <span><?php echo htmlspecialchars($data['recorded_on']); ?></span></p>
        </div>
      </div>
      <!-- Print Button -->
      <div class="text-center mt-4">
        <button class="btn btn-outline-primary print-btn mt-5" onclick="printCertificate()">Print Certificate</button>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function printCertificate() {
      window.print();
    }
  </script>
</body>

</html>