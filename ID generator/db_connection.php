<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password (empty for XAMPP by default)
$dbname = "ginjo"; // Replace with your actual database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
// Check connection
if (!$conn) {
    error_log("DB connection failed: " . mysqli_connect_error());
    // Do not die here — allow pages to handle the missing connection gracefully.
} else {
    // Optionally log successful connection during development
    // error_log("DB connected successfully");
}
