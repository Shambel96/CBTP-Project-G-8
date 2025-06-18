<?php
// Include database connection
include("../db_connection.php");
// Count residents by role
$role_counts = [
    'father' => 0,
    'mother' => 0,
    'child' => 0
];

$result_roles = $conn->query("SELECT role FROM inhabitants");
while ($row = $result_roles->fetch_assoc()) {
    $role = strtolower($row['role']);
    if (isset($role_counts[$role])) {
        $role_counts[$role]++;
    }
}

// Initialize variables
$error_message = "";
$success_message = "";
$edit_resident = null; // Variable to store the resident being edited

// Handle Add Resident Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_resident'])) {
    $first_name = $_POST['first_name'] ?? null;
    $middle_name = $_POST['middle_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $email = $_POST['email'] ?? null;
    $street_name = $_POST['street_name'] ?? null;
    $house_number = $_POST['house_number'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $role = $_POST['role'] ?? null;

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

// Handle Edit Resident Request (Fetch Resident Data)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_resident'])) {
    $id = $_POST['id'];

    $query = "SELECT * FROM inhabitants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_resident = $result->fetch_assoc(); // Store the resident data for editing
    $stmt->close();
}

// Handle Update Resident Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_resident'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $street_name = $_POST['street_name'];
    $house_number = $_POST['house_number'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $role = $_POST['role'];

    $query = "UPDATE inhabitants SET first_name = ?, middle_name = ?, last_name = ?, phone = ?, email = ?, street_name = ?, house_number = ?, gender = ?, date_of_birth = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssi", $first_name, $middle_name, $last_name, $phone, $email, $street_name, $house_number, $gender, $date_of_birth, $role, $id);

    if ($stmt->execute()) {
        $success_message = "Resident updated successfully.";
    } else {
        $error_message = "Error updating resident: " . $stmt->error;
    }

    $stmt->close();
}

// Handle Delete Resident Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_resident'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM inhabitants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success_message = "Resident deleted successfully.";
    } else {
        $error_message = "Error deleting resident: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch All Residents
$query = "SELECT * FROM inhabitants";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard - Add Resident</title>
    <link rel="stylesheet" href="css/add-resident-style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Dashboard layout */
        .dashboard {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            padding: 20px;
        }

        /* Resident Overview card - fixed smaller size */
        .resident-overview-card {
            width: 320px;
            height: 320px;
            flex-shrink: 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .resident-overview-card .card-header {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            font-size: 1.2rem;
            background-color: #f7f7f7;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
        }

        .resident-overview-card .card-body {
            flex-grow: 1;
            padding: 15px;
            position: relative;
        }

        .resident-overview-card canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* Main content: form + table take remaining space */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* Add Resident form card */
        .main-content .card {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-content .card-header {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            font-size: 1.2rem;
            background-color: #f7f7f7;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        form {
            padding: 15px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 150px;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .radio-group {
            display: flex;
            gap: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn {
            padding: 10px;
            font-size: 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Table card */
        .card.mt-4 {
            flex-grow: 1;
            overflow-x: auto;
        }

        .card.mt-4 .card-header {
            background-color: #6c757d;
            color: white;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            /* Ensure minimum width */
        }

        table.table th,
        table.table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            white-space: nowrap;
            /* prevent breaking data */
        }

        /* Buttons inside table */
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 3px;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        /* Inline forms for buttons */
        form.d-inline {
            display: inline;
            margin: 0 3px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .dashboard {
                flex-direction: column;
            }

            .resident-overview-card {
                width: 100%;
                height: 300px;
                margin-bottom: 20px;
            }

            .main-content {
                width: 100%;
            }

            table.table {
                min-width: 600px;
            }
        }
    </style>
</head>

<body>
    <div class="center-container">
        <div class="dashboard">

            <!-- Resident Overview card -->
            <div class="card resident-overview-card">
                <div class="card-header">
                    <h2>Resident Overview</h2>
                </div>
                <div class="card-body">
                    <canvas id="residentChart"></canvas>
                </div>
            </div>

            <!-- Main content: Add form + residents table -->
            <div class="main-content">
                <div class="header">
                    <h2>Add New Resident</h2>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Resident Information</h2>
                    </div>
                    <form id="addResidentForm" method="POST" action="">
                        <?php if ($edit_resident): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_resident['id']; ?>">
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="first_name" class="form-control"
                                    value="<?php echo htmlspecialchars($edit_resident['first_name'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" name="middle_name" class="form-control"
                                    value="<?php echo htmlspecialchars($edit_resident['middle_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" class="form-control"
                                    value="<?php echo htmlspecialchars($edit_resident['last_name'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="<?php echo htmlspecialchars($edit_resident['phone'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($edit_resident['email'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="streetName">Street Name</label>
                                <input type="text" id="streetName" name="street_name" class="form-control" value="<?php echo htmlspecialchars($edit_resident['street_name'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="houseNumber">House Number</label>
                                <input type="text" id="houseNumber" name="house_number" class="form-control" value="<?php echo htmlspecialchars($edit_resident['house_number'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="gender" value="Male"
                                            <?php if (($edit_resident['gender'] ?? '') === 'Male') echo 'checked'; ?> required>
                                        Male
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="gender" value="Female"
                                            <?php if (($edit_resident['gender'] ?? '') === 'Female') echo 'checked'; ?> required>
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($edit_resident['date_of_birth'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <option value="father" <?php if (($edit_resident['role'] ?? '') === 'father') echo 'selected'; ?>>Father</option>
                                    <option value="mother" <?php if (($edit_resident['role'] ?? '') === 'mother') echo 'selected'; ?>>Mother</option>
                                    <option value="child" <?php if (($edit_resident['role'] ?? '') === 'child') echo 'selected'; ?>>Child</option>
                                </select>
                            </div>
                        </div>
                        <?php if ($edit_resident): ?>
                            <button type="submit" name="update_resident" class="btn btn-primary">Update Resident</button>
                        <?php else: ?>
                            <button type="submit" name="add_resident" class="btn btn-primary">Add Resident</button>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Display success/error messages -->
                <?php if ($success_message): ?>
                    <p style="color: green;"><?php echo $success_message; ?></p>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
    </div>
    <!-- Residents Table -->
    <div class="card mt-4">
        <div class="card-header container-fluid">
            <h2>Residents Table</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Resident ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Street Name</th>
                    <th>House Number</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['street_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['house_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td>
                            <form method="POST" action="" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="edit_resident" class="btn btn-warning btn-sm">Edit</button>
                            </form>
                            <form method="POST" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this resident?');">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_resident" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        const ctx = document.getElementById('residentChart').getContext('2d');
        const residentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Father', 'Mother', 'Child'],
                datasets: [{
                    label: 'Resident Overview',
                    data: [<?php echo $role_counts['father']; ?>, <?php echo $role_counts['mother']; ?>, <?php echo $role_counts['child']; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>