<?php
include("../db_connection.php");

// Create inhabitants table
$sql_inhabitants = "UPDATE applications a
JOIN users u ON a.contact = u.phone
SET a.user_id = u.id
WHERE a.user_id IS NULL;";

// Execute the query for inhabitants table
if (!mysqli_query($conn, $sql_inhabitants)) {
    echo "Error creating inhabitants table: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
