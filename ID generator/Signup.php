<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up Form</title>
  <link rel="stylesheet" href="Css/signup-style.css" />
  <style>
    .error {
      color: red;
      font-size: 0.9em;
    }

    #signupForm {
      padding-right: 20px;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <h2>Sign Up</h2>
    <form id="signupForm" action="user_registration.php" method="POST">
      <div class="form-group">
        <label for="firstName">First name *</label>
        <input type="text" id="firstName" name="firstName" required />
        <span id="firstNameError" class="error"></span>
      </div>
      <div class="form-group">
        <label for="lastName">Last name *</label>
        <input type="text" id="lastName" name="lastName" required />
        <span id="lastNameError" class="error"></span>
      </div>
      <div class="form-group">
        <label for="phone">Phone *</label>
        <input type="tel" id="phone" name="phone" required />
        <span id="phoneError" class="error"></span>
      </div>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" required />
        <span id="passwordError" class="error"></span>
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password *</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required />
        <span id="confirmPasswordError" class="error"></span>
      </div>
      <div class="form-actions">
        <button type="submit">Sign Up</button>
        <button type="button" onclick="resetForm()">Cancel</button>
      </div>
    </form>
    <p>Already have an account? <a href="signin.php">Login</a></p>
  </div>

  <script src="js/signup-script.js"></script>
</body>

</html>