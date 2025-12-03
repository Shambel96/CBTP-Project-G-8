<?php
include("db_connection.php");
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate inputs
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^(09|07)\d{8}$/", $phone)) {
        $errors[] = "Phone number must start with 09 or 07 and be 10 digits long.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE phone = '$phone'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['role'] = $user['role']; // Store the user's role 

                // Check user role and redirect accordingly
                if ($user['role'] === 'admin') {
                    header("Location: Admin Dashboard/AdminDashboard.php");
                } else if ($user['role'] === 'staff') {
                    header("Location: Staff_Dashboard/staff_dashboard.php");
                } else {
                    header("Location: UserProfile/User_Profile.php");
                }
                exit;
            } else {
                $errors[] = "Invalid password. Please try again.";
            }
        } else {
            $errors[] = "No account found with this phone number.";
        }
    }

    // If there are errors, store them in session and redirect back to signin.php
    if (!empty($errors)) {
        $_SESSION['login_error'] = implode('<br>', $errors);
        header("Location: signin.php");
        exit;
    }
}
// clsoing session
mysqli_close($conn);
