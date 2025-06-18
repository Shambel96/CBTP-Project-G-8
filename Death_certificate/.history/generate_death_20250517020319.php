<?php
// [Previous PHP processing code remains exactly the same until HTML output]
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
        <!-- Memorial Section (unchanged) -->
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
        
        <!-- Information Section -->
        <div class="info-section">
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
        
        <!-- Bottom Section with Stamp on Left and Info on Right -->
        <div class="bottom-section">
            <div class="stamp-container">
                <img src="images/cleaned_logo.jpg" alt="Official Stamp" class="stamp-image">
            </div>
            <div class="official-info">
                <p class="amharic-text">ግንጆ ቀበለ አስዳደር</p>
                <p>Kebele: <?= sanitize($data['kebele_name']) ?></p>
                <p>Issued: <?= date('F j, Y', strtotime(sanitize($data['issued_date']))) ?></p>
                <p>Official: <?= sanitize($data['official_name']) ?></p>
                <p class="signature-line">_________________________</p>
                <p class="bottom-text">Bulciinsa ganda Ginjoo</p>
            </div>
        </div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()" class="btn">Print Certificate</button>
        <a href="death_certificate.php" class="btn secondary-btn">Create Another</a>
    </div>
</body>
</html>