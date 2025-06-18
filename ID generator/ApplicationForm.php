<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: signin.php");
  exit();
}

// Include database connection
include("db_connection.php");

// Initialize variables
$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = htmlspecialchars(trim($_POST['name']));
  $dob = htmlspecialchars(trim($_POST['dob']));
  $gender = htmlspecialchars(trim($_POST['gender']));
  $contact = htmlspecialchars(trim($_POST['contact']));
  $house_number = htmlspecialchars(trim($_POST['house_number']));
  $certificate_type = htmlspecialchars(trim($_POST['certificate_type']));

  // Validate required fields
  $errors = [];
  if (empty($name) || empty($dob) || empty($gender) || empty($contact) || empty($house_number) || empty($certificate_type)) {
    $errors[] = "All fields are required.";
  }

  // Check for valid contact number
  if (!preg_match('/^\d{10}$/', $contact)) {
    $errors[] = "Contact number must be 10 digits.";
  }

  // If no errors, save to the database
  if (empty($errors)) {
    // Insert data into the database
    $user_id = $_SESSION['id'];
    $query = "INSERT INTO applications (user_id, name, dob, gender, contact, house_number, certificate_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
      $stmt->bind_param("issssss", $user_id, $name, $dob, $gender, $contact, $house_number, $certificate_type);

      if ($stmt->execute()) {
        $success_message = "Application submitted successfully.";
      } else {
        $error_message = "Error submitting application: " . $stmt->error;
      }

      $stmt->close();
    } else {
      $error_message = "Error preparing the query: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Application Form</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
      max-width: 600px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .container {
      border: 1px solid black;
      padding: 10px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>Application Form</h2>

    <!-- Display Success or Error Messages -->
    <?php if (!empty($success_message)): ?>
      <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endforeach; ?>
    <?php endif; ?>

    <form
      action="ApplicationForm.php"
      method="post"
      enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Full Name:</label>
        <input
          type="text"
          class="form-control"
          id="name"
          name="name"
          required />
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input
          type="date"
          class="form-control"
          id="dob"
          name="dob"
          required />
      </div>

      <div class="form-group">
        <label for="gender">Gender:</label>
        <select
          class="form-control"
          id="gender"
          name="gender"
          required>
          <option value="">Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="contact">Contact Number:</label>
        <input
          type="tel"
          class="form-control"
          id="contact"
          name="contact"
          required />
      </div>

      <div class="form-group">
        <label for="house_number">House Number:</label>
        <input
          type="text"
          class="form-control"
          id="house_number"
          name="house_number"
          required />
      </div>

      <div class="form-group">
        <label for="certificate_type">Certificate Type:</label>
        <select
          class="form-control"
          id="certificate_type"
          name="certificate_type"
          required>
          <option value="">Choose one</option>
          <option value="residence_id">Residence ID</option>
          <option value="birth_certificate">Birth Certificate</option>
          <option value="marriage_certificate">Marriage Certificate</option>
          <option value="death_certificate">Death Certificate</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-block">
        Submit Application
      </button>
    </form>
  </div>
</body>

</html>