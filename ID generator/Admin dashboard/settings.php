<?php
session_start();
include("../db_connection.php");

/* if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} */

$user_id = $_SESSION['id'];
$message = "";

// Handle profile update
if (isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET first_name=?, last_name=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $first_name, $last_name, $phone, $user_id);
    $stmt->execute();

    $message = "Profile updated successfully.";
}

// Handle password update
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verify current password
    $check = $conn->query("SELECT password FROM users WHERE id = $user_id")->fetch_assoc();
    if (password_verify($current_password, $check['password'])) {
        $conn->query("UPDATE users SET password = '$new_password' WHERE id = $user_id");
        $message = "Password changed successfully.";
    } else {
        $message = "Current password is incorrect.";
    }
}

// Handle profile image upload
if (isset($_POST['upload_avatar']) && isset($_FILES['avatar'])) {
    $image = $_FILES['avatar']['name'];
    $tmp = $_FILES['avatar']['tmp_name'];
    $target = "../uploads/" . basename($image);

    if (move_uploaded_file($tmp, $target)) {
        $conn->query("UPDATE users SET profile_image='$image' WHERE id=$user_id");
        $message = "Profile picture updated.";
    } else {
        $message = "Failed to upload image.";
    }
}

// Fetch user data
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
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