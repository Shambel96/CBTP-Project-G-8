async function validateLogin() {
  // Clear previous errors
  document.getElementById("phoneError").textContent = "";
  document.getElementById("passwordError").textContent = "";

  let isValid = true;

  // Get form values
  const phone = document.getElementById("phone").value.trim();
  const password = document.getElementById("password").value;

  // Validate phone (must start with Ethiopian numbers 09 or 07 and be 10 digits long)
  if (phone === "") {
    document.getElementById("phoneError").textContent =
      "Phone number is required.";
    isValid = false;
  } else if (!/^(09|07)\d{8}$/.test(phone)) {
    document.getElementById("phoneError").textContent =
      "Phone number must start with 09 or 07 and be 10 digits long.";
    isValid = false;
  }

  // Validate password
  if (password === "") {
    document.getElementById("passwordError").textContent =
      "Password is required.";
    isValid = false;
  } else if (password.length < 6) {
    document.getElementById("passwordError").textContent =
      "Password must be at least 6 characters long.";
    isValid = false;
  }

  // If validation fails, prevent form submission
  if (!isValid) return false;

  // Backend login logic
  try {
    // Make a POST request to the backend login endpoint
    const response = await fetch("login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ phone, password }),
    });

    const data = await response.json();

    if (response.ok) {
      // Check user role and redirect accordingly
      if (data.role === "admin") {
        window.location.href = "AdminDashboard.php"; // Redirect to admin dashboard
      } else if (data.role === "public") {
        window.location.href = "index.php"; // Redirect to public user dashboard
      } else {
        alert("Invalid user role!");
      }
    } else {
      // Handle errors (e.g., invalid credentials)
      alert(data.message || "Login failed. Please try again.");
    }
  } catch (error) {
    console.error("Error during login:", error);
    /* alert("Something went wrong. Please try again later."); */
  }

  return false; // Prevent form submission
}

function resetForm() {
  // Reset the form inputs
  document.getElementById("loginForm").reset();

  // Clear error messages
  document.getElementById("phoneError").textContent = "";
  document.getElementById("passwordError").textContent = "";
}

// Live validation for phone input while typing
document.addEventListener('DOMContentLoaded', function () {
  const phoneInput = document.getElementById('phone');
  const phoneError = document.getElementById('phoneError');

  if (!phoneInput) return;

  const phoneRegex = /^(09|07)\d{0,8}$/; // allow partial typing (0..8 more digits after prefix)

  phoneInput.addEventListener('input', function () {
    const value = phoneInput.value.trim();

    // Clear prior styles
    phoneInput.classList.remove('input-invalid');
    phoneError.textContent = '';

    if (value === '') {
      // Optionally show a hint while typing
      phoneError.textContent = '';
      return;
    }

    // If user started typing, give immediate feedback about prefix
    if (!/^(09|07)/.test(value)) {
      phoneError.textContent = 'Phone must start with 09 or 07.';
      phoneInput.classList.add('input-invalid');
      return;
    }

    // If prefix is correct but length too long or contains non-digits, show message
    if (!/^\d+$/.test(value)) {
      phoneError.textContent = 'Phone must contain only digits.';
      phoneInput.classList.add('input-invalid');
      return;
    }

    if (value.length > 10) {
      phoneError.textContent = 'Phone number cannot be more than 10 digits.';
      phoneInput.classList.add('input-invalid');
      return;
    }

    // If exactly 10 digits and matches full pattern, mark valid
    if (/^(09|07)\d{8}$/.test(value)) {
      phoneError.textContent = '';
      phoneInput.classList.remove('input-invalid');
      return;
    }

    // Otherwise, show how many more digits are needed
    const needed = 10 - value.length;
    if (needed > 0) {
      phoneError.textContent = `Enter ${needed} more digit${needed > 1 ? 's' : ''}.`;
    }
  });

  // On blur, if invalid show full validation message
  phoneInput.addEventListener('blur', function () {
    const v = phoneInput.value.trim();
    if (v === '') return;
    if (!/^(09|07)\d{8}$/.test(v)) {
      phoneError.textContent = 'Phone number must start with 09 or 07 and be 10 digits long.';
      phoneInput.classList.add('input-invalid');
    }
  });
});
