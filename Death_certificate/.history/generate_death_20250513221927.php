<?php
// Process form data
$formData = [
    'kebele_name' => $_POST['kebele_name'] ?? '',
    'full_name' => $_POST['full_name'] ?? '',
    'date_of_birth' => $_POST['date_of_birth'] ?? '',
    'date_of_death' => $_POST['date_of_death'] ?? '',
    'place_of_death' => $_POST['place_of_death'] ?? '',
    'cause_of_death' => $_POST['cause_of_death'] ?? '',
    'father_name' => $_POST['father_name'] ?? '',
    'mother_name' => $_POST['mother_name'] ?? '',
    'certificate_number' => $_POST['certificate_number'] ?? '',
    'issued_date' => $_POST['issued_date'] ?? '',
    'official_name' => $_POST['official_name'] ?? '',
    'memorial_message1' => $_POST['memorial_message1'] ?? '',
    'memorial_message2' => $_POST['memorial_message2'] ?? '',
    'photo' => 'assets/default_photo.jpg'
];

// Handle file upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $fileExt;
    $uploadFile = $uploadDir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        $formData['photo'] = $uploadFile;
    }
}

// Sanitize all data
foreach ($formData as $key => $value) {
    $formData[$key] = htmlspecialchars($value);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Certificate</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="certificate-container">
        <div class="certificate">
            <div class="watermark">OFFICIAL</div>
            
            <!-- Memorial Section -->
            <div class="memorial-section">
                <div class="photo-frame">
                    <img src="<?= $formData['photo'] ?>" alt="<?= $formData['full_name'] ?>">
                </div>
                <h1 class="deceased-name"><?= $formData['full_name'] ?></h1>
                <div class="memorial-message">
                    <p><?= $formData['memorial_message1'] ?></p>
                    <p><?= $formData['memorial_message2'] ?></p>
                </div>
                <div class="dates">
                    <?= date('M j.Y', strtotime($formData['date_of_birth'])) ?> - <?= date('M j.Y', strtotime($formData['date_of_death'])) ?>
                </div>
            </div>
            
            <!-- Certificate Section -->
            <div class="certificate-section">
                <div class="header">
                    <h2>Death Certificate</h2>
                    <h3><?= $formData['kebele_name'] ?> Kebele Administration</h3>
                </div>
                
                <div class="certificate-info">
                    <div class="info-row">
                        <span class="info-label">Certificate Number:</span>
                        <span class="info-value"><?= $formData['certificate_number'] ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Place of Death:</span>
                        <span class="info-value"><?= $formData['place_of_death'] ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Cause of Death:</span>
                        <span class="info-value"><?= $formData['cause_of_death'] ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Father's Name:</span>
                        <span class="info-value"><?= $formData['father_name'] ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Mother's Name:</span>
                        <span class="info-value"><?= $formData['mother_name'] ?></span>
                    </div>
                </div>
                
                <div class="official-stamp">
                    <div class="stamp-area">
                        <p>Official Stamp</p>
                        <p>Issued on: <?= date('F j, Y', strtotime($formData['issued_date'])) ?></p>
                        <div class="signature-line"></div>
                        <p><?= $formData['official_name'] ?></p>
                        <p>Kebele Administrator</p>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p>This is an official document issued by <?= $formData['kebele_name'] ?> Kebele Administration</p>
            </div>
        </div>
        
        <div class="actions">
            <button onclick="window.print()" class="print-btn">Print Certificate</button>
            <a href="death_certificate.php" class="back-btn">Create Another</a>
        </div>
    </div>
</body>
</html>