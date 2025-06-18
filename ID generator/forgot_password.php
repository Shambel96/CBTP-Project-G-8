<?php
session_start();
include("db_connection.php");

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);

    // Check if phone exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate reset code (in a real system, use email or SMS)
        $code = rand(100000, 999999);

        // Save it in session for demo; in real app, save to DB
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_phone'] = $phone;

        $success = "Your reset code is: <strong>$code</strong><br>Use it to <a href='reset_password.php'>reset your password</a>";
    } else {
        $error = "Phone number not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .forgot-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 4px solid orange;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #1e3a5f;
            color: white;
            padding: 12px;
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
            margin-bottom: 15px;
            font-weight: bold;
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
    <div class="forgot-container">
        <h2>Forgot Password</h2>

        <?php if (!empty($error)) echo "<div class='message error'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='message success'>$success</div>"; ?>

        <form method="post">
            <label for="phone">Enter your phone number:</label>
            <input type="text" id="phone" name="phone" required>
            <input type="submit" value="Get Reset Code">
        </form>
    </div>
</body>

</html>