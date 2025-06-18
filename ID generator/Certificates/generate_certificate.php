<?php
require_once("../db_connection.php");

// Function to generate certificate number (same pattern as others)
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

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate certificate number by system (not from user input)
    $certNumber = generateBirthCertificateNumber($conn);

    // Handle file upload
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

    // Use 'b' for BLOB (child_photo)
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

    // If using 'b' in bind_param, send_long_data is recommended for BLOBs
    if ($photoData !== null) {
        $stmt->send_long_data(9, $photoData); // 0-based index for child_photo
    }

    if ($stmt->execute()) {

        header("Location: Birth_Certificate.php?cert=" . urlencode($certNumber));
        exit();
    } else {
        die("Error saving certificate: " . $conn->error);
    }
}
