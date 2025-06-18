<?php
// Include database connection
include("../db_connection.php");

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Residents</title>
    <link rel="stylesheet" href="css/add-resident-style.css">

</head>

<body>
    <div class="container mt-5">
        <h2>Manage Residents</h2>

        <!-- Display Success or Error Messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add Resident Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">Add New Resident</div>
            <div class="card-body">
                <form method="POST" action="">
                    <?php if ($edit_resident): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_resident['id']; ?>">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="form-control" value="<?php echo $edit_resident['first_name'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="middleName">Middle Name</label>
                            <input type="text" id="middleName" name="middle_name" class="form-control" value="<?php echo $edit_resident['middle_name'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="form-control" value="<?php echo $edit_resident['last_name'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $edit_resident['phone'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $edit_resident['email'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="streetName">Street Name</label>
                            <input type="text" id="streetName" name="street_name" class="form-control" value="<?php echo $edit_resident['street_name'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="houseNumber">House Number</label>
                            <input type="text" id="houseNumber" name="house_number" class="form-control" value="<?php echo $edit_resident['house_number'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" id="male" name="gender" value="male" <?php echo isset($edit_resident['gender']) && $edit_resident['gender'] === 'male' ? 'checked' : ''; ?>>
                                    <label for="male">Male</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="female" name="gender" value="female" <?php echo isset($edit_resident['gender']) && $edit_resident['gender'] === 'female' ? 'checked' : ''; ?>>
                                    <label for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="date_of_birth" class="form-control" value="<?php echo $edit_resident['date_of_birth'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="child" <?php echo isset($edit_resident['role']) && $edit_resident['role'] === 'child' ? 'selected' : ''; ?>>Child</option>
                                <option value="father" <?php echo isset($edit_resident['role']) && $edit_resident['role'] === 'father' ? 'selected' : ''; ?>>Father</option>
                                <option value="mother" <?php echo isset($edit_resident['role']) && $edit_resident['role'] === 'mother' ? 'selected' : ''; ?>>Mother</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="<?php echo $edit_resident ? 'update_resident' : 'add_resident'; ?>" class="btn btn-primary btn-block">
                        <?php echo $edit_resident ? "Update Resident" : "Add Resident"; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Residents Table -->
        <div class="card residents-table">
            <div class="card-header bg-secondary text-white">Existing Residents</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="search">Search Residents:</label>
                    <input type="text" id="search" placeholder="Search by any field..." class="form-control" style="width: 300px; margin-bottom: 15px;">
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
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
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['street_name']; ?></td>
                                <td><?php echo $row['house_number']; ?></td>
                                <td><?php echo ucfirst($row['gender']); ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo ucfirst($row['role']); ?></td>
                                <td>
                                    <!-- Edit Resident Form -->
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="edit_resident" class="btn btn-warning btn-sm">Edit</button>
                                    </form>

                                    <!-- Delete Resident Form -->
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_resident" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.querySelectorAll('td'));
                const match = cells.some(cell => cell.textContent.toLowerCase().includes(searchTerm));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

</body>

</html>