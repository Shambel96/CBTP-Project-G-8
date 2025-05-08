document
  .getElementById("signupForm")
  .addEventListener("submit", function (event) {
    if (!validateForm()) {
      event.preventDefault(); // Prevent form submission if validation fails
    }
  });

// Clear errors on input focus
document.querySelectorAll("input").forEach((input) => {
  input.addEventListener("input", function () {
    const errorId = this.id + "Error"; // Match the error message ID
    document.getElementById(errorId).textContent = ""; // Clear the error message
  });
});

function validateForm() {
  // Clear previous errors
  document.getElementById("firstNameError").textContent = "";
  document.getElementById("lastNameError").textContent = "";
  document.getElementById("phoneError").textContent = "";
  document.getElementById("passwordError").textContent = "";
  document.getElementById("confirmPasswordError").textContent = "";

  let isValid = true;

  // Get form values
  const firstName = document.getElementById("firstName").value.trim();
  const lastName = document.getElementById("lastName").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  // Validate first name
  if (firstName === "") {
    document.getElementById("firstNameError").textContent =
      "First name is required.";
    isValid = false;
  } else if (!/^[A-Za-z]+$/.test(firstName)) {
    document.getElementById("firstNameError").textContent =
      "First name must only contain letters.";
    isValid = false;
  } else if (firstName.length < 3 || firstName.length > 20) {
    document.getElementById("firstNameError").textContent =
      "First name must be between 3 and 20 characters long.";
    isValid = false;
  }

  // Validate last name
  if (lastName === "") {
    document.getElementById("lastNameError").textContent =
      "Last name is required.";
    isValid = false;
  } else if (!/^[A-Za-z]+$/.test(lastName)) {
    document.getElementById("lastNameError").textContent =
      "Last name must only contain letters.";
    isValid = false;
  } else if (lastName.length < 3 || lastName.length > 20) {
    document.getElementById("lastNameError").textContent =
      "Last name must be between 3 and 20 characters long.";
    isValid = false;
  }

  // Validate phone
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

  // Validate confirm password
  if (confirmPassword === "") {
    document.getElementById("confirmPasswordError").textContent =
      "Confirm password is required.";
    isValid = false;
  } else if (password !== confirmPassword) {
    document.getElementById("confirmPasswordError").textContent =
      "Passwords do not match.";
    isValid = false;
  }

  return isValid; // Prevent form submission if not valid
}

function resetForm() {
  document.getElementById("signupForm").reset(); // Clear all form inputs
  // Clear error messages
  document.querySelectorAll(".error").forEach((error) => {
    error.textContent = "";
  });
}
