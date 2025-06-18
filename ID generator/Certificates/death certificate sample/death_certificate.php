<?php

require_once("../../db_connection.php");

// Helper function to generate certificate number
function generateDeathCertificateNumber($conn)
{
  $currentYear = date('Y');
  $query = "SELECT certificate_number FROM death_certificate 
              WHERE certificate_number LIKE 'DC-$currentYear-%'
              ORDER BY certificate_number DESC LIMIT 1";
  $result = $conn->query($query);
  if ($result && $result->num_rows > 0) {
    $lastCert = $result->fetch_assoc()['certificate_number'];
    $parts = explode('-', $lastCert);
    $nextNum = str_pad((int)$parts[2] + 1, 6, '0', STR_PAD_LEFT);
  } else {
    $nextNum = '000001';
  }
  return "DC-$currentYear-$nextNum";
}

// Get certificate number from URL (e.g., death_certificate.php?cert=DC-2025-000001)
$cert_number = isset($_GET['cert']) ? $_GET['cert'] : '';

if (empty($cert_number)) {
  die("Invalid certificate number.");
}

// Fetch the certificate by certificate_number
$stmt = $conn->prepare("SELECT * FROM death_certificate WHERE certificate_number = ?");
$stmt->bind_param("s", $cert_number);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
  die("Certificate not found.");
}

// If certificate_number is empty, generate and update it (should not happen if you always use cert_number)
if (empty($data['certificate_number'])) {
  $new_cert_number = generateDeathCertificateNumber($conn);
  $update_stmt = $conn->prepare("UPDATE death_certificate SET certificate_number = ? WHERE id = ?");
  $update_stmt->bind_param("si", $new_cert_number, $data['id']);
  $update_stmt->execute();
  $update_stmt->close();
  $data['certificate_number'] = $new_cert_number;
}

// Prepare photo for display (if exists)
$photo_src = '';
if (!empty($data['photo'])) {
  $photo_type = !empty($data['photo_type']) ? $data['photo_type'] : 'image/jpeg';
  $photo_src = "data:" . $photo_type . ";base64," . base64_encode($data['photo']);
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    Death Certificate - <?php echo htmlspecialchars($data['full_name']); ?>
  </title>
  <link rel="stylesheet" href="../CSS/death-style.css">

</head>

<body>
  <div class="certificate">
    <!-- Deceased Photo -->
    <div class="deceased-photo">
      <?php if ($photo_src): ?>
        <img id="deceased-photo" src="<?php echo $photo_src; ?>" alt="Deceased Photo" />
      <?php else: ?>
        <span>No photo</span>
      <?php endif; ?>
    </div>
    <!-- Official Seal -->
    <div class="official-seal">Official Seal</div>
    <!-- Certificate Number -->
    <div class="certificate-number">
      Certificate No:
      <span id="certificate-no"><?php echo htmlspecialchars($data['certificate_number']); ?></span>
    </div>
    <!-- Header -->
    <div class="certificate-header">
      <h1 class="certificate-title">Death Certificate</h1>
      <h2 class="certificate-subtitle">
        Federal Democratic Republic of Ethiopia
      </h2>
      <h2 class="certificate-subtitle">Vital Events Registration Agency</h2>
    </div>
    <!-- Certificate Content -->
    <div class="certificate-content">
      <!-- Deceased Information -->
      <div class="section">
        <div class="section-title">Deceased Information</div>
        <div class="info-row">
          <div class="info-label">Full Name:</div>
          <div class="info-value" id="full-name">
            <?php echo htmlspecialchars($data['full_name']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Date of Birth:</div>
          <div class="info-value" id="dob">
            <?php echo htmlspecialchars($data['date_of_birth']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Date of Death:</div>
          <div class="info-value" id="dod">
            <?php echo htmlspecialchars($data['date_of_death']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Place of Death:</div>
          <div class="info-value" id="place-death">
            <?php echo htmlspecialchars($data['place_of_death']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Cause of Death:</div>
          <div class="info-value" id="cause-death">
            <?php echo htmlspecialchars($data['cause_of_death']); ?>
          </div>
        </div>
      </div>
      <!-- Family Information -->
      <div class="section">
        <div class="section-title">Family Information</div>
        <div class="info-row">
          <div class="info-label">Father's Name:</div>
          <div class="info-value" id="father-name">
            <?php echo htmlspecialchars($data['father_name']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Mother's Name:</div>
          <div class="info-value" id="mother-name">
            <?php echo htmlspecialchars($data['mother_name']); ?>
          </div>
        </div>
      </div>
      <!-- Memorial Message -->
      <div class="memorial-message">
        <div id="memorial-line1">
          <?php echo htmlspecialchars($data['memorial_message1']); ?>
        </div>
        <div id="memorial-line2">
          <?php echo htmlspecialchars($data['memorial_message2']); ?>
        </div>
      </div>
      <!-- Issuing Authority -->
      <div class="section">
        <div class="section-title">Issuing Authority</div>
        <div class="info-row">
          <div class="info-label">Kebele:</div>
          <div class="info-value" id="kebele-name">
            <?php echo htmlspecialchars($data['kebele_name']); ?>
          </div>
        </div>
        <div class="info-row">
          <div class="info-label">Date Issued:</div>
          <div class="info-value" id="issue-date">
            <?php echo htmlspecialchars($data['issued_date']); ?>
          </div>
        </div>
      </div>
      <!-- Signatures -->
      <div class="signature-area">
        <div class="signature-box">
          <div class="signature-line"></div>
          <div>Authorized Official</div>
          <div id="official-name" style="font-weight: bolder; font-size: 13px;">
            <?php echo htmlspecialchars($data['official_name']); ?>
          </div>
          <div>Registration Officer</div>
        </div>
        <div class="signature-box">
          <div class="signature-line"></div>
          <div>Date:</div>
          <div id="signature-date">
            <?php echo htmlspecialchars($data['issued_date']); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <div class="certificate-footer">
      This is an official document issued by the Government of Ethiopia. Any
      alteration makes this document invalid.
    </div>
  </div>
  <div class="text-center">
    <button class="btn btn-outline-primary print-btn mr-3 py-3" style="background-color:blue; color:aliceblue;" onclick="window.print()">Print Certificate</button>
  </div>
</body>

</html>