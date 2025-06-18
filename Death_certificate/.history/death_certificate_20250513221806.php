<?php
// Default values for the form
$defaultData = [
    'kebele_name' => '',
    'full_name' => '',
    'date_of_birth' => '',
    'date_of_death' => '',
    'place_of_death' => '',
    'cause_of_death' => 'Natural Causes',
    'father_name' => '',
    'mother_name' => '',
    'certificate_number' => '',
    'issued_date' => date('Y-m-d'),
    'official_name' => '',
    'memorial_message1' => "Loved one's wonderful and gentle soul will",
    'memorial_message2' => "forever remain in our hearts."
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Certificate Input</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Death Certificate Information</h1>
        <form method="POST" action="generate.php" enctype="multipart/form-data">
            
            <div class="form-section">
                <h2>Personal Information</h2>
                
                <div class="form-group">
                    <label for="photo">Deceased Photo:</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <small>Recommended: Square photo (300x300px)</small>
                </div>
                
                <div class="form-group">
                    <label for="full_name">Full Name of Deceased:</label>
                    <input type="text" id="full_name" name="full_name" value="<?= $defaultData['full_name'] ?>" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= $defaultData['date_of_birth'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_of_death">Date of Death:</label>
                        <input type="date" id="date_of_death" name="date_of_death" value="<?= $defaultData['date_of_death'] ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="place_of_death">Place of Death:</label>
                    <input type="text" id="place_of_death" name="place_of_death" value="<?= $defaultData['place_of_death'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="cause_of_death">Cause of Death:</label>
                    <select id="cause_of_death" name="cause_of_death" required>
                        <option value="Natural Causes" <?= $defaultData['cause_of_death'] === 'Natural Causes' ? 'selected' : '' ?>>Natural Causes</option>
                        <option value="Illness" <?= $defaultData['cause_of_death'] === 'Illness' ? 'selected' : '' ?>>Illness</option>
                        <option value="Accident" <?= $defaultData['cause_of_death'] === 'Accident' ? 'selected' : '' ?>>Accident</option>
                        <option value="Other" <?= $defaultData['cause_of_death'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Family Information</h2>
                
                <div class="form-group">
                    <label for="father_name">Father's Name:</label>
                    <input type="text" id="father_name" name="father_name" value="<?= $defaultData['father_name'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="mother_name">Mother's Name:</label>
                    <input type="text" id="mother_name" name="mother_name" value="<?= $defaultData['mother_name'] ?>" required>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Memorial Message</h2>
                
                <div class="form-group">
                    <label for="memorial_message1">First Line:</label>
                    <input type="text" id="memorial_message1" name="memorial_message1" value="<?= $defaultData['memorial_message1'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="memorial_message2">Second Line:</label>
                    <input type="text" id="memorial_message2" name="memorial_message2" value="<?= $defaultData['memorial_message2'] ?>" required>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Administrative Information</h2>
                
                <div class="form-group">
                    <label for="kebele_name">Kebele Name:</label>
                    <input type="text" id="kebele_name" name="kebele_name" value="<?= $defaultData['kebele_name'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="certificate_number">Certificate Number:</label>
                    <input type="text" id="certificate_number" name="certificate_number" value="<?= $defaultData['certificate_number'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="issued_date">Issued Date:</label>
                    <input type="date" id="issued_date" name="issued_date" value="<?= $defaultData['issued_date'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="official_name">Issuing Official Name:</label>
                    <input type="text" id="official_name" name="official_name" value="<?= $defaultData['official_name'] ?>" required>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Generate Certificate</button>
        </form>
    </div>
</body>
</html>