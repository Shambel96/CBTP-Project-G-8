<?php
session_start();
include("../db_connection.php");

$session_user_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
$session_role = $_SESSION['role'] ?? '';

// Ensure user is logged in
if ($session_user_id <= 0) {
    header("Location: ../signin.php");
    exit();
}

// Allow admin to pass ?id= to edit another user; otherwise use logged-in user id
if (isset($_GET['id']) && is_numeric($_GET['id']) && $session_role === 'admin') {
    $user_id = intval($_GET['id']);
    $editing_other = ($user_id !== $session_user_id);
} else {
    $user_id = $session_user_id;
    $editing_other = false;
}
$message = "";

// Handle profile update
if (isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET first_name=?, last_name=?, phone=? WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $first_name, $last_name, $phone, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $message = "Failed to prepare update statement.";
    }

    $message = "Profile updated successfully.";
}

// Handle password update
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verify current password
    // Fetch current hashed password safely
    $check = null;
    if ($stmt = $conn->prepare("SELECT password FROM users WHERE id = ?")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        if ($stmt->fetch()) {
            $check = ['password' => $hashed_password];
        }
        $stmt->close();
    }

    // If editing another user, only admins may change password without current password
    if ($editing_other && $session_role !== 'admin') {
        $message = "You do not have permission to change another user's password.";
    } else {
        $can_change = false;
        if ($editing_other && $session_role === 'admin') {
            // Admin can set new password directly
            $can_change = true;
        } else {
            // User changing own password: verify current password
            if ($check && password_verify($current_password, $check['password'])) {
                $can_change = true;
            }
        }

        if ($can_change) {
            if ($stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?")) {
                $stmt->bind_param('si', $new_password, $user_id);
                $stmt->execute();
                $stmt->close();
                $message = "Password changed successfully.";
            } else {
                $message = "Failed to update password.";
            }
        } else {
            if (!$message) $message = "Current password is incorrect.";
        }
    }
}

// Handle profile image upload
if (isset($_POST['upload_avatar']) && isset($_FILES['avatar'])) {
    $image = $_FILES['avatar']['name'];
    $tmp = $_FILES['avatar']['tmp_name'];
    $target = "../uploads/" . basename($image);

    if (move_uploaded_file($tmp, $target)) {
        if ($stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?")) {
            $stmt->bind_param('si', $image, $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "Profile picture updated.";
        } else {
            $message = "Failed to update profile image in database.";
        }
    } else {
        $message = "Failed to upload image.";
    }
}

// Fetch user data
$user = null;
if ($stmt = $conn->prepare("SELECT id, first_name, last_name, phone, profile_image FROM users WHERE id = ?")) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
    $stmt->close();
}

if (!$user) {
    // If no user found, redirect or show an error
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <h2>Account Settings</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>

    <form method="post">
        <h5>Change Password</h5>
        <div class="mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <button type="submit" name="change_password" class="btn btn-warning">Change Password</button>
    </form>

    <hr>

    <form method="post" enctype="multipart/form-data">
        <h5>Update Profile Picture</h5>
        <div class="mb-3">
            <input type="file" name="avatar" class="form-control">
        </div>
        <button type="submit" name="upload_avatar" class="btn btn-secondary">Upload</button>
    </form>

</body>

</html>