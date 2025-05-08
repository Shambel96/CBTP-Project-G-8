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
