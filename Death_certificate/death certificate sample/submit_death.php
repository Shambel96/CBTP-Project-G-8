<?php
// filepath: c:\xampp\htdocs\shanbe\CBTP G-8\ID generator\Death_certificate\death certificate sample\submit_death.php
session_start();
require_once("../../db_connection.php");

$data = $_SESSION['death_form'] ?? null;
if (!$data) {
    header("Location: death_certificate.html");
    exit;
}

// Prepare photo blob
$photo_blob = isset($data['photo_tmp']) ? base64_decode($data['photo_tmp']) : null;

// Insert into DB
$stmt = $conn->prepare("INSERT INTO death_certificate 
    (photo, full_name, date_of_birth, date_of_death, place_of_death, cause_of_death, father_name, mother_name, memorial_message1, memorial_message2, kebele_name, certificate_number, issued_date, official_name)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "bsssssssssssss",
    $photo_blob,
    $data['full_name'],
    $data['date_of_birth'],
    $data['date_of_death'],
    $data['place_of_death'],
    $data['cause_of_death'],
    $data['father_name'],
    $data['mother_name'],
    $data['memorial_message1'],
    $data['memorial_message2'],
    $data['kebele_name'],
    $data['certificate_number'],
    $data['issued_date'],
    $data['official_name']
);
if ($photo_blob !== null) {
    $stmt->send_long_data(0, $photo_blob);
}
$stmt->execute();
$new_id = $stmt->insert_id;
$stmt->close();
$conn->close();

// Clear session data
unset($_SESSION['death_form']);

// Redirect to certificate display page
header("Location: death_certificate.php?id=" . $new_id);
exit;
