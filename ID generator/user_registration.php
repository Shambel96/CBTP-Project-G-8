<?php
include("db_connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form inputs
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : 'public'; // Default to 'public' if role is not selected

    // Initialize an array to hold validation errors
    $errors = [];

    // Validate inputs
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^(09|07)\d{8}$/", $phone)) {
        $errors[] = "Phone number must start with 09 or 07 and be 10 digits long.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Validate the role (optional, for stricter security)
    if (!in_array($role, ['admin', 'public'])) {
        $errors[] = "Invalid role selected.";
    }

    // If there are no validation errors, proceed to insert the data
    if (empty($errors)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert user data into the database
        $sql = "INSERT INTO users (first_name, last_name, phone, password, role) 
                VALUES ('$firstName', '$lastName', '$phone', '$hashedPassword', '$role')";

        if (mysqli_query($conn, $sql)) {
            // Success message
            echo "<p style='color:green;'>Sign up successful! You can now <a href='signin.php'>login</a>.</p>";
        } else {
            // Database insertion error
            echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
mysqli_close($conn);
