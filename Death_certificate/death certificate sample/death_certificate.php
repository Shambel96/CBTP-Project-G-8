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

// Get certificate id from URL (e.g., death_certificate_sample.php?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  die("Invalid certificate ID.");
}

$stmt = $conn->prepare("SELECT * FROM death_certificate WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
if (!$data) {
  die("Certificate not found.");
}

// If certificate_number is empty, generate and update it
if (empty($data['certificate_number'])) {
  $new_cert_number = generateDeathCertificateNumber($conn);
  $update_stmt = $conn->prepare("UPDATE death_certificate SET certificate_number = ? WHERE id = ?");
  $update_stmt->bind_param("si", $new_cert_number, $id);
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
  <style>
    /* Base Styles */
    :root {
      --primary-color: #333;
      --secondary-color: #555;
      --border-color: #999;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Times New Roman', serif;
      background-color: #f5f5f5;
      color: var(--primary-color);
      line-height: 1.6;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    /* Certificate Container */
    .certificate {
      background-color: white;
      border: 15px double var(--primary-color);
      padding: 30px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      position: relative;
      width: 100%;
      max-width: 800px;
      margin: 20px auto;
    }

    /* Header Section */
    .certificate-header {
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 2px solid var(--primary-color);
    }

    .certificate-title {
      font-size: clamp(24px, 3vw, 32px);
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--primary-color);
    }

    .certificate-subtitle {
      font-size: clamp(16px, 2vw, 22px);
      margin: 10px 0 0;
      font-weight: normal;
      color: var(--secondary-color);
    }

    /* Photo and Seal */
    .deceased-photo {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 80px;
      height: 100px;
      border: 1px solid var(--border-color);
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 10px;
      overflow: hidden;
    }

    .deceased-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .official-seal {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 80px;
      height: 80px;
      border: 2px solid var(--primary-color);
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 10px;
      text-align: center;
      font-style: italic;
    }

    /* Certificate Number */
    .certificate-number {
      position: absolute;
      top: 10px;
      right: 120px;
      font-size: 12px;
    }

    /* Content Sections */
    .certificate-content {
      margin-top: 30px;
    }

    .section {
      margin-bottom: 20px;
    }

    .section-title {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 10px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 5px;
    }

    .info-row {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 8px;
    }

    .info-label {
      width: 150px;
      font-weight: bold;
      font-size: 15px;
    }

    .info-value {
      flex: 1;
      min-width: 200px;
      border-bottom: 1px dotted var(--border-color);
      padding-left: 10px;
      padding-bottom: 3px;
      font-size: 15px;
    }

    /* Memorial Message */
    .memorial-message {
      text-align: center;
      font-style: italic;
      margin: 25px 0;
      padding: 15px 0;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
      font-size: 16px;
      line-height: 1.8;
    }

    /* Signature Area */
    .signature-area {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-top: 40px;
      gap: 20px;
    }

    .signature-box {
      flex: 1;
      min-width: 150px;
      text-align: center;
    }

    .signature-line {
      border-top: 1px solid var(--primary-color);
      margin-top: 40px;
      padding-top: 5px;
      height: 50px;
    }

    /* Footer */
    .certificate-footer {
      text-align: center;
      margin-top: 30px;
      font-size: 12px;
      font-style: italic;
      color: var(--secondary-color);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .certificate {
        padding: 20px;
        border-width: 10px;
      }

      .deceased-photo,
      .official-seal {
        position: static;
        margin: 0 auto 15px;
        display: block;
      }

      .certificate-number {
        position: static;
        text-align: center;
        margin-bottom: 15px;
      }

      .info-label {
        width: 100%;
        margin-bottom: 5px;
      }

      .info-value {
        min-width: 100%;
        padding-left: 0;
      }

      .signature-area {
        flex-direction: column;
        align-items: center;
      }

      .signature-box {
        width: 100%;
        max-width: 250px;
        margin-bottom: 20px;
      }
    }

    @media (max-width: 480px) {
      .certificate {
        padding: 15px;
        border-width: 8px;
      }

      .certificate-title {
        font-size: 20px;
      }

      .certificate-subtitle {
        font-size: 16px;
      }

      .section-title {
        font-size: 16px;
      }

      .info-label,
      .info-value {
        font-size: 14px;
      }

      .memorial-message {
        font-size: 15px;
        padding: 10px 0;
        margin: 15px 0;
      }
    }
  </style>
</head>

<body>
  <div class="certificate">
    <!-- Deceased Photo -->
    <div class="deceased-photo">
      <?php if ($photo_src): ?>
        <img id="deceased-photo" src="<?php echo $photo_src; ?>" alt="Deceased Photo" />
      <?php else: ?>
        <span>No photo available</span>
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
          <div id="official-name" style="font-weight: bolder; font-size: 16px;">
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
</body>

</html>