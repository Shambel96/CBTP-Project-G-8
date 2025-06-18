function validateForm() {
  // Reset error messages
  document
    .querySelectorAll(".error-message")
    .forEach((el) => (el.textContent = ""));
  let isValid = true;
  // Validate First Name (3-20 characters)
  const firstName = document.getElementById("firstName").value.trim();
  if (firstName.length < 3 || firstName.length > 20) {
    document.getElementById("firstNameError").textContent =
      "First name must be 3-20 characters";
    isValid = false;
  }
  // Validate Middle Name (if provided, 3-20 characters)
  const middleName = document.getElementById("middleName").value.trim();
  if (middleName && (middleName.length < 3 || middleName.length > 20)) {
    document.getElementById("middleNameError").textContent =
      "Middle name must be 3-20 characters";
    isValid = false;
  }
  // Validate Last Name (3-20 characters)
  const lastName = document.getElementById("lastName").value.trim();
  if (lastName.length < 3 || lastName.length > 20) {
    document.getElementById("lastNameError").textContent =
      "Last name must be 3-20 characters";
    isValid = false;
  }
  // Validate Ethiopian phone number (supports both Safaricom and Ethio Telecom)
  const phone = document.getElementById("phone").value.trim();
  // Supports: +2517XXXXXXXX (12 digits) or 07XXXXXXXX (10 digits) or 011XXXXXXXX (11 digits) etc.
  const ethiopianPhoneRegex =
    /^(\+2517\d{8}|07\d{8}|011\d{6,7}|09\d{8}|\+2519\d{8}|0[1-9]\d{7,8})$/;
  if (!ethiopianPhoneRegex.test(phone)) {
    document.getElementById("phoneError").textContent =
      "Please enter a valid Ethiopian phone number (07XXXXXXXX, +2517XXXXXXXX, 011XXXXXXX, etc.)";
    isValid = false;
  }
  // Validate Email (must end with @gmail.com)
  const email = document.getElementById("email").value.trim();
  if (!email.endsWith("@gmail.com")) {
    document.getElementById("emailError").textContent =
      "Email must end with @gmail.com";
    isValid = false;
  }
  // Validate Date of Birth (not in future)
  const dob = document.getElementById("dob").value;
  if (new Date(dob) > new Date()) {
    document.getElementById("dobError").textContent =
      "Date of birth cannot be in the future";
    isValid = false;
  }
  // Validate House Number
  const houseNumber = document.getElementById("houseNumber").value.trim();
  if (!houseNumber) {
    document.getElementById("houseNumberError").textContent =
      "House number is required";
    isValid = false;
  }
  // Validate Street Name
  const streetName = document.getElementById("streetName").value.trim();
  if (!streetName) {
    document.getElementById("streetNameError").textContent =
      "Street name is required";
    isValid = false;
  }
  if (!isValid) {
    return false;
  }
  // If all validations pass, show success message
  alert("Resident added successfully!");
  return true;
}
