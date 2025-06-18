<?php
include("../db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $houseNumber = mysqli_real_escape_string($conn, $_POST['house_number']);
    $streetName = mysqli_real_escape_string($conn, $_POST['street_name']);

    // Insert query
    $sql = "INSERT INTO inhabitants (first_name, middle_name, last_name, phone, email, gender, date_of_birth, house_number, street_name)
            VALUES ('$firstName', '$middleName', '$lastName', '$phone', '$email', '$gender', '$dateOfBirth', '$houseNumber', '$streetName')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "New inhabitant added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
