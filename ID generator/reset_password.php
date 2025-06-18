<?php
session_start();
include("db_connection.php");

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $new_password = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);


    if ($code == $_SESSION['reset_code']) {
        $phone = $_SESSION['reset_phone'];

        // Update password (simple version; hash it if needed)
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE phone = ?");
        $stmt->bind_param("ss", $new_password, $phone);

        if ($stmt->execute()) {
            $success = "Password updated successfully. <a href='signin.php'>Login now</a>";
            unset($_SESSION['reset_code'], $_SESSION['reset_phone']);
        } else {
            $error = "Failed to update password.";
        }

        $stmt->close();
    } else {
        $error = "Invalid reset code.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .reset-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 40px 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 60%;
            text-align: center;
            border: 4px solid orange;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            margin-right: 20px;
        }

        label {
            display: block;
            text-align: left;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #1e3a5f;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: orange;
        }

        .message {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <h2>Reset Password</h2>

        <?php if (!empty($error)) echo "<div class='message error'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='message success'>$success</div>"; ?>

        <form method="post">
            <label for="code">Enter the reset code:</label>
            <input type="text" id="code" name="code" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>

</html>