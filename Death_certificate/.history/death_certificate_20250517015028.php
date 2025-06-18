<?php
// Default values
$defaults = [
    'full_name' => '',
    'date_of_birth' => '',
    'date_of_death' => '',
    'place_of_death' => '',
    'cause_of_death' => 'Natural Causes',
    'father_name' => '',
    'mother_name' => '',
    'memorial_message1' => "Loved one's wonderful and gentle soul will",
    'memorial_message2' => "forever remain in our hearts.",
    'kebele_name' => '',
    'certificate_number' => '',
    'issued_date' => date('Y-m-d'),
    'official_name' => ''
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Certificate Form</title>
    <link rel="stylesheet" href="death.css">
</head>
<body>
    <form class="death-form" method="POST" action="generate_death.php" enctype="multipart/form-data">
        <h1>Death Certificate Information</h1>
        
        <div class="form-group">
            <label for="photo">Deceased Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*">
        </div>
        
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?= $defaults['full_name'] ?>" required>
        </div>
        
        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?= $defaults['date_of_birth'] ?>" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="date_of_death">Date of Death:</label>
                <input type="date" id="date_of_death" name="date_of_death" value="<?= $defaults['date_of_death'] ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="place_of_death">Place of Death:</label>
            <input type="text" id="place_of_death" name="place_of_death" value="<?= $defaults['place_of_death'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="cause_of_death">Cause of Death:</label>
            <select id="cause_of_death" name="cause_of_death" required>
                <option value="Natural Causes">Natural Causes</option>
                <option value="Illness">Illness</option>
                <option value="Accident">Accident</option>
                <option value="Other">Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="father_name">Father's Name:</label>
            <input type="text" id="father_name" name="father_name" value="<?= $defaults['father_name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="mother_name">Mother's Name:</label>
            <input type="text" id="mother_name" name="mother_name" value="<?= $defaults['mother_name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="memorial_message1">Memorial Message (Line 1):</label>
            <input type="text" id="memorial_message1" name="memorial_message1" value="<?= $defaults['memorial_message1'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="memorial_message2">Memorial Message (Line 2):</label>
            <input type="text" id="memorial_message2" name="memorial_message2" value="<?= $defaults['memorial_message2'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="kebele_name">Kebele Name:</label>
            <input type="text" id="kebele_name" name="kebele_name" value="<?= $defaults['kebele_name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="certificate_number">Certificate Number:</label>
            <input type="text" id="certificate_number" name="certificate_number" value="<?= $defaults['certificate_number'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="issued_date">Issued Date:</label>
            <input type="date" id="issued_date" name="issued_date" value="<?= $defaults['issued_date'] ?>" required>
        </div>
        <!-- Inside generate_death.php -->
<div class="certificate-container">
    <!-- Information Section (LEFT) -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Certificate Number:</div>
            <div class="info-value">5467</div>
        </div>
        <div class="info-row">
            <div class="info-label">Place of Death:</div>
            <div class="info-value">Ginjo</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cause of Death:</div>
            <div class="info-value">Natural Causes</div>
        </div>
        <div class="info-row">
            <div class="info-label">Father's Name:</div>
            <div class="info-value">Tesafaye Abdi</div>
        </div>
        <div class="info-row">
            <div class="info-label">Mother's Name:</div>
            <div class="info-value">huz yhg</div>
        </div>
    </div>
    
    <!-- Stamp Section (RIGHT) -->
    <div class="stamp-section">
        <img src="images/cleaned_logo.jpg" alt="Official Stamp" class="stamp-image">
        <div class="stamp-text">
            <p class="amharic-text">ግንጆ ቀበለ አስዳደር</p>
            <p>Issued by: ginjo</p>
            <p>Date: May 17, 2025</p>
            <p class="quote">education is bullshit</p>
            <p class="dear-life">dear Life</p>
            <p>Kebele Administrator</p>
            <p class="bottom-text">Bulciinsa ganda Ginjoo</p>
        </div>
    </div>
</div>
        <div class="form-group">
            <label for="official_name">Official Name:</label>
            <input type="text" id="official_name" name="official_name" value="<?= $defaults['official_name'] ?>" required>
        </div>
        
        <button type="submit" class="btn">Generate Certificate</button>
    </form>
</body>
</html>