<?php
include("../db_connection.php");

// Initialize variables
$error_message = "";
$success_message = "";
$edit_user = null; // Variable to store the user being edited

// Handle Add User Request

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'] ?? 'public'; // Default role is 'public' if not selected

    $query = "INSERT INTO users (first_name, last_name, phone, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $first_name, $last_name, $phone, $password, $role);

    if ($stmt->execute()) {
        $success_message = "User added successfully.";
    } else {
        $error_message = "Error adding user: " . $stmt->error;
    }

    $stmt->close();
}

// Handle Edit User Request (Fetch User Data)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['id'];

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_user = $result->fetch_assoc(); // Store the user data for editing
    $stmt->close();
}

// Handle Update User Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $phone = $_POST['phone'];
    $role = $_POST['role'] ?? 'public'; // Default role is 'public' if not selected

    $query = "UPDATE users SET first_name = ?, last_name = ?, phone = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $phone, $role, $id);

    if ($stmt->execute()) {
        $success_message = "User updated successfully.";
    } else {
        $error_message = "Error updating user: " . $stmt->error;
    }

    $stmt->close();
}

// Handle Delete User Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success_message = "User deleted successfully.";
    } else {
        $error_message = "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch All Users
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Users</h2>

        <!-- Display Success or Error Messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add or Edit User Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <?php echo $edit_user ? "Edit User" : "Add New User"; ?>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <?php if ($edit_user): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_user['id']; ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="firstName">First Name *</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $edit_user['first_name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $edit_user['last_name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $edit_user['phone'] ?? ''; ?>" required>
                    </div>
                    <?php if (!$edit_user): ?>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="public" <?php echo isset($edit_user['role']) && $edit_user['role'] === 'public' ? 'selected' : ''; ?>>Public</option>
                            <option value="admin" <?php echo isset($edit_user['role']) && $edit_user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="staff" <?php echo isset($edit_user['role']) && $edit_user['role'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>
                    <button type="submit" name="<?php echo $edit_user ? 'update_user' : 'add_user'; ?>" class="btn btn-success mt-3">
                        <?php echo $edit_user ? "Update User" : "Add User"; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header bg-secondary text-white">Existing Users</div>
            <div class="card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="userSearchInput" class="form-control" placeholder="Search users by name, phone, or role...">
                </div>
                <table class="table table-bordered" id="usersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
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
                                <td><?php echo ucfirst($row['role']); ?></td>
                                <td>
                                    <!-- Edit User Form -->
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="edit_user" class="btn btn-warning btn-sm">Edit</button>
                                    </form>

                                    <!-- Delete User Form -->
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
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
        // Simple client-side search for the users table
        document.getElementById('userSearchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#usersTable tbody tr');
            rows.forEach(function(row) {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>

</html>