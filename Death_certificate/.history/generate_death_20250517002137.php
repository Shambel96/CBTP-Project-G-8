<?php
// Process form data
$data = [
    'photo' => 'assets/default_photo.jpg',
    'full_name' => $_POST['full_name'] ?? '',
    'date_of_birth' => $_POST['date_of_birth'] ?? '',
    'date_of_death' => $_POST['date_of_death'] ?? '',
    'place_of_death' => $_POST['place_of_death'] ?? '',
    'cause_of_death' => $_POST['cause_of_death'] ?? '',
    'father_name' => $_POST['father_name'] ?? '',
    'mother_name' => $_POST['mother_name'] ?? '',
    'memorial_message1' => $_POST['memorial_message1'] ?? '',
    'memorial_message2' => $_POST['memorial_message2'] ?? '',
    'kebele_name' => $_POST['kebele_name'] ?? '',
    'certificate_number' => $_POST['certificate_number'] ?? '',
    'issued_date' => $_POST['issued_date'] ?? '',
    'official_name' => $_POST['official_name'] ?? ''
];

// Handle file upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
    $targetFile = $uploadDir . $filename;
    
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        $data['photo'] = $targetFile;
    }
}

// Sanitize all output
function sanitize($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Certificate</title>
    <link rel="stylesheet" href="death.css">
</head>
<body>
    <div class="certificate">
        <!-- Memorial Section -->
        <div class="memorial-section">
            <div class="photo-frame">
                <img src="<?= sanitize($data['photo']) ?>" alt="<?= sanitize($data['full_name']) ?>">
            </div>
            <h1 class="deceased-name"><?= sanitize($data['full_name']) ?></h1>
            <div class="memorial-message">
                <p><?= sanitize($data['memorial_message1']) ?></p>
                <p><?= sanitize($data['memorial_message2']) ?></p>
            </div>
            <div class="dates">
                <?= date('M j, Y', strtotime(sanitize($data['date_of_birth']))) ?> - <?= date('M j, Y', strtotime(sanitize($data['date_of_death']))) ?>
            </div>
        </div>
        
        <!-- Certificate Details -->
        <div class="certificate-details">
            <div class="info-row">
                <div class="info-label">Certificate Number:</div>
                <div class="info-value"><?= sanitize($data['certificate_number']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Place of Death:</div>
                <div class="info-value"><?= sanitize($data['place_of_death']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Cause of Death:</div>
                <div class="info-value"><?= sanitize($data['cause_of_death']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Father's Name:</div>
                <div class="info-value"><?= sanitize($data['father_name']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Mother's Name:</div>
                <div class="info-value"><?= sanitize($data['mother_name']) ?></div>
            </div>
        </div>
        
        <!-- Official Stamp -->
        <div class="official-stamp">
            <div class="stamp-area">
                <p style="font-weight: bold; margin-bottom: 5px;">ግንጆ ቀበለ አስዳደር</p>
                <p>Issued by: <?= sanitize($data['kebele_name']) ?> Kebele</p>
                <p>Date: <?= date('F j, Y', strtotime(sanitize($data['issued_date']))) ?></p>
                <div style="margin: 20px 0; border-top: 1px solid #000; width: 200px;"></div>
                <p><?= sanitize($data['official_name']) ?></p>
                <p>Kebele Administrator</p>
                <p style="font-weight: bold; margin-top: 5px;">Bulciinsa ganda Ginjoo</p>
            </div>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn">Print Certificate</button>
        <a href="death_certificate.php" class="btn" style="background: #555;">Create Another</a>
    </div>
</body>
</html>