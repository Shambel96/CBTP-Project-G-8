<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password (empty for XAMPP by default)
$dbname = "ginjo"; // Replace with your actual database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    echo "connected successfully";
}
