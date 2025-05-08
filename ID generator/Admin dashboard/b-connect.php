<?php
include("../db_connection.php");

// Create families table
$sql_families = "CREATE TABLE families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_name VARCHAR(100) NOT NULL,
    head_of_family_id INT,
    house_number VARCHAR(50),
    street_name VARCHAR(100),
    subcity VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Execute the query for families table
if (!mysqli_query($conn, $sql_families)) {
    echo "Error creating families table: " . mysqli_error($conn);
}

// Create residents table
$sql_residents = "CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE,
    email VARCHAR(100) UNIQUE,
    gender ENUM('male', 'female', 'other'),
    date_of_birth DATE,
    house_number VARCHAR(50),
    street_name VARCHAR(100),
    subcity VARCHAR(100) NOT NULL,
    family_id INT,
    is_head_of_family BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (family_id) REFERENCES families(id) ON DELETE SET NULL
)";

// Execute the query for residents table
if (!mysqli_query($conn, $sql_residents)) {
    echo "Error creating residents table: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
