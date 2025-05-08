<?php
include("db_connection.php");

$password = '111222';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL statement to insert into the users table
$sql = "INSERT INTO users (first_name, last_name, phone, password, role) 
VALUES ('shambel', 'dechu', '0909090909', '$hashed_password', 'admin')";

if (mysqli_query($conn, $sql)) {
    echo "User added successfully!";
} else {
    echo "Error adding user: " . mysqli_error($conn);
}

mysqli_close($conn);
