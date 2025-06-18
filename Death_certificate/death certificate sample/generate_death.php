<?php
// filepath: c:\xampp\htdocs\shanbe\CBTP G-8\ID generator\Death_certificate\death certificate sample\generate_death.php
require_once("../../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize form inputs
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_death = $_POST['date_of_death'];
    $place_of_death = $_POST['place_of_death'];
    $cause_of_death = $_POST['cause_of_death'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $memorial_message1 = $_POST['memorial_message1'];
    $memorial_message2 = $_POST['memorial_message2'];
    $kebele_name = $_POST['kebele_name'];
    $certificate_number = $_POST['certificate_number'];
    $issued_date = $_POST['issued_date'];
    $official_name = $_POST['official_name'];

    // Handle photo upload as blob
    $photo_blob = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_blob = file_get_contents($_FILES['photo']['tmp_name']);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO death_certificate 
        (photo, full_name, date_of_birth, date_of_death, place_of_death, cause_of_death, father_name, mother_name, memorial_message1, memorial_message2, kebele_name, certificate_number, issued_date, official_name)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "bsssssssssssss",
        $photo_blob,
        $full_name,
        $date_of_birth,
        $date_of_death,
        $place_of_death,
        $cause_of_death,
        $father_name,
        $mother_name,
        $memorial_message1,
        $memorial_message2,
        $kebele_name,
        $certificate_number,
        $issued_date,
        $official_name
    );
    // For blob, use send_long_data
    if ($photo_blob !== null) {
        $stmt->send_long_data(0, $photo_blob);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Death certificate saved successfully!');window.location.href='death_certificate.html';</script>";
    } else {
        echo "<script>alert('Error saving certificate.');window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: death_certificate.html");
    exit();
}
