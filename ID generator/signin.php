<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="css/signin-style.css" />
</head>

<body>
  <div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" action="login.php" method="POST" onsubmit="return validateLogin()">
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
        <a href="#" class="forgot-password">Forget password?</a>
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