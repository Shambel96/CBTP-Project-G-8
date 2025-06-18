<?php
// filepath: c:\xampp\htdocs\shanbe\CBTP G-8\ID generator\Certificates\Birth_Certificate.php

require_once("../db_connection.php");

// Helper: Generate certificate number like BC-2025-00001
function generateBirthCertificateNumber($conn)
{
  $currentYear = date('Y');
  $query = "SELECT cert_number FROM birth_certificates 
              WHERE cert_number LIKE 'BC-$currentYear-%'
              ORDER BY cert_number DESC LIMIT 1";
  $result = $conn->query($query);
  if ($result && $result->num_rows > 0) {
    $lastCert = $result->fetch_assoc()['cert_number'];
    $parts = explode('-', $lastCert);
    $nextNum = str_pad((int)$parts[2] + 1, 5, '0', STR_PAD_LEFT);
  } else {
    $nextNum = '00001';
  }
  return "BC-$currentYear-$nextNum";
}

// Handle POST from birth-input.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Generate certificate number
  $certNumber = generateBirthCertificateNumber($conn);

  // Handle photo upload
  $photoData = null;
  $photoType = null;
  if (isset($_FILES['childPhoto']) && $_FILES['childPhoto']['error'] === UPLOAD_ERR_OK) {
    $photoData = file_get_contents($_FILES['childPhoto']['tmp_name']);
    $photoType = mime_content_type($_FILES['childPhoto']['tmp_name']);
  }

  // Insert into database
  $stmt = $conn->prepare("INSERT INTO birth_certificates 
        (child_name, gender, birth_day, birth_month, birth_year, 
         father_name, mother_name, place_of_birth, cert_number, 
         child_photo, photo_type, issued_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

  $stmt->bind_param(
    "ssissssssbs",
    $_POST['childName'],
    $_POST['gender'],
    $_POST['birthDay'],
    $_POST['birthMonth'],
    $_POST['birthYear'],
    $_POST['fatherName'],
    $_POST['motherName'],
    $_POST['placeOfBirth'],
    $certNumber,
    $photoData,
    $photoType
  );
  if ($photoData !== null) {
    $stmt->send_long_data(9, $photoData); // 0-based index for child_photo
  }

  if ($stmt->execute()) {
    // Fetch the inserted data for display
    $id = $stmt->insert_id;
    $stmt->close();
    $stmt2 = $conn->prepare("SELECT * FROM birth_certificates WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $data = $result->fetch_assoc();
    $stmt2->close();
  } else {
    die("Error saving certificate: " . $conn->error);
  }
} elseif (isset($_GET['cert'])) {
  // Display certificate by cert_number
  $certNumber = $_GET['cert'];
  $stmt = $conn->prepare("SELECT * FROM birth_certificates WHERE cert_number = ?");
  $stmt->bind_param("s", $certNumber);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  $stmt->close();
} else {
  die("No certificate data found.");
}

// Prepare photo for display
$photo_src = '';
if (!empty($data['child_photo'])) {
  $photo_type = !empty($data['photo_type']) ? $data['photo_type'] : 'image/jpeg';
  $photo_src = "data:" . $photo_type . ";base64," . base64_encode($data['child_photo']);
}

// Format issued date
$issuedDate = date("F j, Y", strtotime($data['issued_date']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ginjo Kebele - Birth Certificate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Libre+Baskerville&display=swap" rel="stylesheet" />
  <style>
    /* ...copy your CSS from Birth_Certificate.html here... */
    body {
      font-family: "Libre Baskerville", serif;
      background-color: #f5f5f5;
    }

    .certificate-container {
      width: 700px;
      margin: 20px auto;
      padding: 20px;
      background-color: white;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .certificate {
      border: 10px solid #8b0000;
      padding: 20px;
      position: relative;
      background-color: #fffdf5;
    }

    .top-flags {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .flag {
      height: 60px;
      width: auto;
    }

    .photo-placeholder,
    .child-photo {
      height: 60px;
      width: 45px;
      border: 1px dashed #ccc;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 9px;
      color: #999;
      overflow: hidden;
    }

    .child-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
    }

    .header h1 {
      font-size: 20px;
      color: #003366;
      margin-bottom: 5px;
    }

    .header h2 {
      font-size: 15px;
      color: #555;
      margin-bottom: 5px;
    }

    .header h3 {
      font-size: 22px;
      color: #8b0000;
      margin-top: 10px;
      font-family: "Great Vibes", cursive;
    }

    .content {
      margin: 15px 0;
      line-height: 1.5;
    }

    .name {
      font-size: 22px;
      text-align: center;
      margin: 10px 0;
      color: #003366;
    }

    .underline {
      border-bottom: 1px solid #333;
      padding-bottom: 1px;
    }

    .stamp-wrapper {
      text-align: center;
      margin: 15px 0;
    }

    .fancy-stamp {
      width: 120px;
      height: 120px;
    }

    .signature-section {
      display: flex;
      justify-content: space-around;
      margin: 20px 0;
    }

    .sign {
      text-align: center;
    }

    .footer {
      margin-top: 20px;
      text-align: center;
    }

    .manager-sign {
      margin-bottom: 10px;
    }

    .issued-date {
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <div class="certificate-container" id="certificateToPrint">
    <div class="certificate">
      <!-- Photo and Flag -->
      <div class="top-flags">
        <img src="Oromia.png" alt="Oromia Flag" class="flag left-flag" />
        <?php if ($photo_src): ?>
          <div class="child-photo"><img src="<?php echo $photo_src; ?>" alt="Child Photo"></div>
        <?php else: ?>
          <div class="photo-placeholder">Child's Photo<br />(35mm x 45mm)</div>
        <?php endif; ?>
      </div>

      <!-- Header -->
      <div class="header">
        <h1>Federal Democratic Republic of Ethiopia</h1>
        <h2>Oromia Region, Jimma Zone, Ginjo Kebele</h2>
        <h3>Birth Certificate</h3>
      </div>

      <!-- Content -->
      <div class="content">
        <p class="intro">This is to certify that</p>
        <h2 class="name" id="childName"><?php echo htmlspecialchars($data['child_name']); ?></h2>
        <p>
          was born on the <span class="underline" id="birthDay"><?php echo htmlspecialchars($data['birth_day']); ?></span> day
          of <span class="underline" id="birthMonth"><?php echo htmlspecialchars($data['birth_month']); ?></span>,
          <span class="underline" id="birthYear"><?php echo htmlspecialchars($data['birth_year']); ?></span>
        </p>
        <p>
          at <span class="underline">Ginjo Kebele</span>, Jimma, National
          State of Oromia
        </p>

        <p>Child of:</p>
        <p>
          Father:
          <span class="underline" id="fatherName"><?php echo htmlspecialchars($data['father_name']); ?></span>
        </p>
        <p>
          Mother:
          <span class="underline" id="motherName"><?php echo htmlspecialchars($data['mother_name']); ?></span>
        </p>

        <p>Gender: <span class="underline" id="gender"><?php echo htmlspecialchars($data['gender']); ?></span></p>
        <p>
          Birth Certificate No.:
          <span class="underline" id="certNumber"><?php echo htmlspecialchars($data['cert_number']); ?></span>
        </p>
      </div>
      <!-- Signatures -->
      <div class="signature-section">
        <div class="sign">
          <p>_______________________</p>
          <p>Registrar's Signature</p>
        </div>
        <div class="sign">
          <p>_______________________</p>
          <p>Parent/Guardian</p>
        </div>
      </div>

      <!-- Footer -->
      <div class="footer">
        <div class="manager-sign">
          <p>_______________________</p>
          <p><strong>Wada Diriba</strong></p>
          <p>Kebele Manager</p>
        </div>
        <p class="issued-date">
          Issued on:
          <span class="underline" id="issueDate"><?php echo $issuedDate; ?></span>
        </p>
        <p>Ginjo Kebele Administrative Office, Jimma</p>
      </div>
    </div>
  </div>
  <div class="text-center my-4">
    <button class="btn btn-outline-primary" onclick="printCertificate()">Print Certificate</button>
  </div>
  <script>
    function printCertificate() {
      var printContents = document.getElementById('certificateToPrint').innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload(); // reload to restore event handlers
    }
  </script>
</body>

</html>