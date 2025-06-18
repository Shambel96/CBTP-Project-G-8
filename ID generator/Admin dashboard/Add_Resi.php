<?php
// Include database connection
include("../db_connection.php");

// Initialize variables
$error_message = "";
$success_message = "";

// Handle Add Resident Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? null;
    $middle_name = $_POST['middle_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $email = $_POST['email'] ?? null;
    $street_name = $_POST['street_name'] ?? null;
    $house_number = $_POST['house_number'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $role = $_POST['role'] ?? null; // New role field

    // Validate required fields
    if (!$first_name || !$last_name || !$street_name || !$house_number || !$gender || !$date_of_birth || !$role) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Insert resident into the database
        $query = "INSERT INTO inhabitants (first_name, middle_name, last_name, phone, email, street_name, house_number, gender, date_of_birth, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssssssss", $first_name, $middle_name, $last_name, $phone, $email, $street_name, $house_number, $gender, $date_of_birth, $role);

            if ($stmt->execute()) {
                $success_message = "Resident added successfully.";
            } else {
                $error_message = "Error adding resident: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Error preparing the query: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Resident</title>
    <link rel="stylesheet" href="css/add-resident-style.css">
</head>

<body>
    <div class="center-container">
        <div class="dashboard">
            <div class="main-content">
                <div class="header">
                    <h2>Add New Resident</h2>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Resident Information</h2>
                    </div>
                    <form id="addResidentForm" action="#" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="male" name="gender" value="male" checked>
                                        <label for="male">Male</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="female" name="gender" value="female">
                                        <label for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="date_of_birth" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="child">Child</option>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="houseNumber">House Number</label>
                                <input type="text" id="houseNumber" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="streetName">Street Name</label>
                                <input type="text" id="streetName" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Resident</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>