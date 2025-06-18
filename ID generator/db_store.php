<?php
include("db_connection.php");

$password = '111222';

// Hash the password
/* $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 */
// SQL statement to insert into the users table
$sql = "ALTER TABLE applications
ADD CONSTRAINT fk_applications_user
FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE
ON UPDATE CASCADE;";


if (mysqli_query($conn, $sql)) {
    echo "User added successfully!";
} else {
    echo "Error adding user: " . mysqli_error($conn);
}

mysqli_close($conn);
