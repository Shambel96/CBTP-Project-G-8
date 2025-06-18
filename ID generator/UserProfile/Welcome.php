<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}
require_once("../db_connection.php");

// Fetch user details from DB
$user_id = $_SESSION['id'];
$first_name = $last_name = $phone = $profile_pic = $db_password = "";
$user_sql = "SELECT first_name, last_name, phone, profile_pic, password FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
if ($user_stmt) {
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_stmt->bind_result($first_name, $last_name, $phone, $profile_pic, $db_password);
    $user_stmt->fetch();
    $user_stmt->close();
}
$full_name = htmlspecialchars(trim("$first_name $last_name"));
$phone = htmlspecialchars($phone);

// If no profile picture, use avatar service as default
$profile_pic_url = $profile_pic && file_exists($profile_pic)
    ? htmlspecialchars($profile_pic)
    : "https://ui-avatars.com/api/?name=" . urlencode($full_name) . "&background=f0f2f5&color=6c757d";

// Handle profile update and remove photo
$update_success = false;
$update_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_first_name = trim($_POST['first_name']);
    $new_last_name = trim($_POST['last_name']);
    $new_phone = trim($_POST['phone']);
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $new_profile_pic = $profile_pic;

    // Handle remove photo
    if (isset($_POST['remove_photo'])) {
        // Optionally delete the file from disk
        if ($profile_pic && file_exists($profile_pic)) {
            @unlink($profile_pic);
        }
        $new_profile_pic = '';
    }

    // Handle profile picture upload (store file path in DB)
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $target = $upload_dir . "profile_" . $user_id . "_" . time() . "." . $ext;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
            $new_profile_pic = $target;
        }
    }

    // Password change logic
    $change_password = false;
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $update_error = "Please enter your current password to change your password.";
        } elseif (!password_verify($current_password, $db_password)) {
            $update_error = "Wrong current password.";
        } elseif ($new_password !== $confirm_password) {
            $update_error = "New passwords do not match.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $change_password = true;
        }
    }

    if (!$update_error) {
        require("../db_connection.php");
        if ($change_password) {
            $update_sql = "UPDATE users SET first_name=?, last_name=?, phone=?, profile_pic=?, password=? WHERE id=?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sssssi", $new_first_name, $new_last_name, $new_phone, $new_profile_pic, $hashed_password, $user_id);
        } else {
            $update_sql = "UPDATE users SET first_name=?, last_name=?, phone=?, profile_pic=? WHERE id=?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssssi", $new_first_name, $new_last_name, $new_phone, $new_profile_pic, $user_id);
        }
        if ($update_stmt->execute()) {
            $update_success = true;
            // Refresh values for placeholders and profile picture
            $first_name = $new_first_name;
            $last_name = $new_last_name;
            $phone = $new_phone;
            $profile_pic = $new_profile_pic;
            $profile_pic_url = $profile_pic && file_exists($profile_pic)
                ? htmlspecialchars($profile_pic)
                : "https://ui-avatars.com/api/?name=" . urlencode(htmlspecialchars(trim("$first_name $last_name"))) . "&background=f0f2f5&color=6c757d";
        } else {
            $update_error = "Failed to update profile.";
        }
        $update_stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Digital ID System</title>
    <link rel="stylesheet" href="css/welcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="profile-container">
        <?php if ($update_success): ?>
            <div class="alert alert-success">Profile updated successfully!</div>
        <?php elseif ($update_error): ?>
            <div class="alert alert-danger"><?php echo $update_error; ?></div>
        <?php endif; ?>
        <div class="welcome-title">Welcome back, <?php echo htmlspecialchars($first_name); ?>!</div>
        <div class="profile-row mb-4">
            <div class="profile-avatar">
                <img src="<?php echo $profile_pic_url; ?>" alt="Profile Picture" id="profilePicPreview">
                <label class="change-photo-btn" for="profilePicInput">
                    <i class="fa fa-camera me-2"></i>Change Photo
                </label>
                <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" style="display:none;">
                <?php if ($profile_pic): ?>
                    <form method="post" action="" style="display:inline;">
                        <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                        <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        <button type="submit" name="remove_photo" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Are you sure you want to remove your photo?');">
                            <i class="fa fa-trash"></i> Remove Photo
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <div>
                <div class="full-name"><?php echo $full_name; ?></div>
            </div>
        </div>
        <form class="profile-form" method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="<?php echo htmlspecialchars($first_name); ?>" value="<?php echo htmlspecialchars($first_name); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="<?php echo htmlspecialchars($last_name); ?>" value="<?php echo htmlspecialchars($last_name); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="<?php echo $phone; ?>" value="<?php echo $phone; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter current password">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm new password">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        // Profile picture preview
        document.getElementById('profilePicInput').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('profilePicPreview').src = URL.createObjectURL(file);
            }
        });
    </script>
</body>

</html>