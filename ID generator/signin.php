<?php
session_start();
include("db_connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Ensure DB connection exists before using it
  if (!isset($conn) || !$conn) {
    $errors[] = "Database connection not available. Please contact the administrator.";
  } else {
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
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
          header("Location: Admin dashboard/AdminDashboard.php");
        } else if ($user['role'] === 'staff') {
          header("Location: Staff_Dashboard/staff_dashboard.php");
        } else if ($user['role'] === 'public') {
          header("Location: UserProfile/User_Profile.php");
        } else {
          $errors[] = "Unknown user role. Please contact admin.";
        }
        exit;
      } else {
        $errors[] = "Invalid password. Please try again.";
      }
    } else {
      $errors[] = "No account found with this phone number.";
    }
  }
  }
  
mysqli_close($conn);}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Login Page</title>
  <link rel="stylesheet" href="Css/signin-style.CSS" />
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
    }

    .logo-design img {
      max-width: 30%;
      border-radius: 15%;
      justify-self: center;
      justify-items: center;
      justify-content: center;
      margin-left: 125px;
    }

    .alert-danger .cascade-error {
      animation: fadeInDown 0.5s;
      margin-bottom: 5px;
      padding: 8px 12px;
      border-radius: 5px;
      background: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.07);
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-15px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    /* Inline error message style for inputs */
    .error {
      color: #b02a37;
      font-size: 0.9rem;
      display: block;
      margin-top: 6px;
      min-height: 1.1em;
    }
    .input-invalid {
      border-color: #dc3545 !important;
      box-shadow: 0 0 0 3px rgba(220,53,69,0.06);
    }
  </style>
</head>

<body>
  <?php
  include("header.php");
  ?>
  <div class="login-container" style="font-family: 'Times New Roman', Times, serif;">
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger" style="margin-bottom:15px;">
        <?php foreach ($errors as $i => $error): ?>
          <div class="cascade-error" style="animation-delay: <?php echo $i * 0.15; ?>s;"><?php echo $error; ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="logo-design">
      <img src="images/sample_image/28.04.2025_23.30.08_REC.png" alt="">
    </div>
    <h2>Login</h2>
    <form id="loginForm" action="" method="POST" onsubmit="return validateLogin()">
      <div class="input-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" required />
        <span id="phoneError" class="error"></span>
      </div>
      <div class="input-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" required />
        <span id="passwordError" class="error"></span>
      </div>
      <div class="options">
        <label> <input type="checkbox" name="remember" /> Remember me </label>
        <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
      </div>
      <div class="buttons">
        <button type="submit" class="login-btn">LOGIN</button>
        <button type="button" class="cancel-btn" onclick="resetForm()">Cancel</button>
      </div>
    </form>
    <div class="create-account">
      <p>Don't you have an account?</p>
      <a href="Signup.php"><span>Create new account</span></a>
    </div>
  </div>
  <script src="JS/signin-script.js"></script>
</body>

</html>