<?php

session_start();
if (!isset($_SESSION['id'])) {
  header("Location: signin.php");
  exit();
}

require_once("db_connection.php");

$success = $error = "";
$show_review = false;
$user_data = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_registration'])) {
  // Collect and sanitize input
  $fname = trim($_POST['fname']);
  $mname = trim($_POST['mname']);
  $lname = trim($_POST['lname']);
  $gender = $_POST['gender'] ?? '';
  $dob = $_POST['dob'];
  $status = $_POST['status'] ?? '';
  $occupation = trim($_POST['Occupation']);
  $emergency_num = trim($_POST['emergency_num']);
  $mother_name = trim($_POST['mother_name']);
  $h_number = trim($_POST['h_number']);
  $email = trim($_POST['email'] ?? '');

  // Handle file upload
  $photo_path = "";
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    if ($_FILES['photo']['size'] > 500 * 1024) {
      $error = "Image must be under 500KB.";
    } else {
      $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
      $upload_dir = "uploads/";
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $photo_path = $upload_dir . "id_" . time() . "_" . rand(1000, 9999) . "." . $ext;
      move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
  }

  // Simple server-side validation
  if (
    !$fname || !$mname || !$lname || !$gender || !$dob || !$status ||
    !$occupation || !$emergency_num || !$mother_name || !$h_number || !$photo_path
  ) {
    $error = "Please fill in all required fields.";
  } else {
    // Store user data for review
    $user_data = [
      'fname' => $fname,
      'mname' => $mname,
      'lname' => $lname,
      'gender' => $gender,
      'dob' => $dob,
      'status' => $status,
      'occupation' => $occupation,
      'emergency_num' => $emergency_num,
      'mother_name' => $mother_name,
      'h_number' => $h_number,
      'photo' => $photo_path,
      'email' => $email
    ];
    $show_review = true;
  }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm_registration'])) {
  // Final submission: insert into database
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $status = $_POST['status'];
  $occupation = $_POST['occupation'];
  $emergency_num = $_POST['emergency_num'];
  $mother_name = $_POST['mother_name'];
  $h_number = $_POST['h_number'];
  $photo_path = $_POST['photo'];
  $email = $_POST['email'];

  $stmt = $conn->prepare("INSERT INTO id_registers 
          (fname, mname, lname, gender, dob, status, occupation, emergency_num, mother_name, h_number, photo, email) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param(
    "ssssssssssss",
    $fname,
    $mname,
    $lname,
    $gender,
    $dob,
    $status,
    $occupation,
    $emergency_num,
    $mother_name,
    $h_number,
    $photo_path,
    $email
  );
  if ($stmt->execute()) {
    // Optionally, pass the new ID as a GET parameter if needed
    $new_id = $stmt->insert_id;
    header("Location: IDpage.php?id=" . $new_id);
    exit();
  } else {
    $error = "Registration failed. Please try again.";
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="css/IDuserRegister.css" />
  <title>ID Registration</title>

  <script>
    // Client-side validation
    function validateForm() {
      let valid = true;
      let msg = "";

      const fname = document.getElementById('fname').value.trim();
      const mname = document.getElementById('mname').value.trim();
      const lname = document.getElementById('lname').value.trim();
      const gender = document.querySelector('input[name="gender"]:checked');
      const dob = document.getElementById('dob').value;
      const status = document.getElementById('M-status').value;
      const occupation = document.getElementById('Occupation').value.trim();
      const emergency_num = document.getElementById('emergency_num').value.trim();
      const mother_name = document.getElementById('mother_name').value.trim();
      const h_number = document.getElementById('h_number').value.trim();
      const photo = document.getElementById('photo').value;

      if (!fname || !mname || !lname) {
        msg += "Name fields are required.\n";
        valid = false;
      }
      if (!gender) {
        msg += "Gender is required.\n";
        valid = false;
      }
      if (!dob) {
        msg += "Date of Birth is required.\n";
        valid = false;
      } else {
        // Age validation: must be 18 or older
        const dobDate = new Date(dob);
        const today = new Date();
        const age = today.getFullYear() - dobDate.getFullYear();
        const m = today.getMonth() - dobDate.getMonth();
        if (age < 18 || (age === 18 && m < 0) || (age === 18 && m === 0 && today.getDate() < dobDate.getDate())) {
          msg += "You must be at least 18 years old to register.\n";
          valid = false;
        }
      }
      if (!status) {
        msg += "Marital Status is required.\n";
        valid = false;
      }
      if (!occupation) {
        msg += "Occupation is required.\n";
        valid = false;
      }
      if (!emergency_num.match(/^0[0-9]{9,}$/)) {
        msg += "Emergency Contact must start with 0 and be at least 10 digits.\n";
        valid = false;
      }
      if (!mother_name) {
        msg += "Mother's Name is required.\n";
        valid = false;
      }
      if (!h_number) {
        msg += "House Number is required.\n";
        valid = false;
      }
      if (!photo) {
        msg += "Photo is required.\n";
        valid = false;
      }

      if (!valid) {
        alert(msg);
      }
      return valid;
    }

    // Set max date for DOB input to ensure user is at least 18
    window.onload = function() {
      const today = new Date();
      const minYear = today.getFullYear() - 18;
      const minMonth = String(today.getMonth() + 1).padStart(2, '0');
      const minDay = String(today.getDate()).padStart(2, '0');
      const dobInput = document.getElementById('dob');
      if (dobInput) {
        dobInput.setAttribute('max', `${minYear}-${minMonth}-${minDay}`);
      }
    };

    // Image validation for size and aspect ratio
    document.addEventListener('DOMContentLoaded', function() {
      const photoInput = document.getElementById('photo');
      if (photoInput) {
        photoInput.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (!file) return;

          // Check file size (under 500KB)
          if (file.size > 500 * 1024) {
            alert("Image must be under 500KB.");
            e.target.value = "";
            return;
          }
          // Check dimensions and aspect ratio
          const img = new Image();
          img.onload = function() {
            if (img.width !== img.height) {
              alert("Image must have a 1:1 aspect ratio (square).");
              e.target.value = "";
              return;
            }
          };
          img.onerror = function() {
            alert("Invalid image file.");
            e.target.value = "";
          };
          img.src = URL.createObjectURL(file);
        });
      }
    });
  </script>
</head>

<body>
  <!-- <header>
      <ul>
        <li>
          <a href="SampleIDpage.Php"><i class="fa-solid fa-backward"></i></a>
        </li>
        <li><a href="index.php" target="_blank">Home</a></li>
      </ul>
    </header> -->
  <section class="register-form">
    <h2>ID Registration Form</h2>
    <?php if ($success): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($show_review && $user_data): ?>
      <h3>Please review your information</h3>
      <form method="POST" action="">
        <table class="review-table">
          <tr>
            <th>First Name</th>
            <td><?php echo htmlspecialchars($user_data['fname']); ?><input type="hidden" name="fname" value="<?php echo htmlspecialchars($user_data['fname']); ?>"></td>
            <th>Middle Name</th>
            <td><?php echo htmlspecialchars($user_data['mname']); ?><input type="hidden" name="mname" value="<?php echo htmlspecialchars($user_data['mname']); ?>"></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?php echo htmlspecialchars($user_data['lname']); ?><input type="hidden" name="lname" value="<?php echo htmlspecialchars($user_data['lname']); ?>"></td>
            <th>Gender</th>
            <td><?php echo htmlspecialchars($user_data['gender']); ?><input type="hidden" name="gender" value="<?php echo htmlspecialchars($user_data['gender']); ?>"></td>
          </tr>
          <tr>
            <th>Date of Birth</th>
            <td><?php echo htmlspecialchars($user_data['dob']); ?><input type="hidden" name="dob" value="<?php echo htmlspecialchars($user_data['dob']); ?>"></td>
            <th>Marital Status</th>
            <td><?php echo htmlspecialchars($user_data['status']); ?><input type="hidden" name="status" value="<?php echo htmlspecialchars($user_data['status']); ?>"></td>
          </tr>
          <tr>
            <th>Occupation</th>
            <td><?php echo htmlspecialchars($user_data['occupation']); ?><input type="hidden" name="occupation" value="<?php echo htmlspecialchars($user_data['occupation']); ?>"></td>
            <th>Emergency Contact</th>
            <td><?php echo htmlspecialchars($user_data['emergency_num']); ?><input type="hidden" name="emergency_num" value="<?php echo htmlspecialchars($user_data['emergency_num']); ?>"></td>
          </tr>
          <tr>
            <th>Mother's Name</th>
            <td><?php echo htmlspecialchars($user_data['mother_name']); ?><input type="hidden" name="mother_name" value="<?php echo htmlspecialchars($user_data['mother_name']); ?>"></td>
            <th>House Number</th>
            <td><?php echo htmlspecialchars($user_data['h_number']); ?><input type="hidden" name="h_number" value="<?php echo htmlspecialchars($user_data['h_number']); ?>"></td>
          </tr>
          <tr>
            <th>Email</th>
            <td colspan="3"><?php echo htmlspecialchars($user_data['email']); ?><input type="hidden" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>"></td>
          </tr>
          <tr>
            <th>Photo</th>
            <td colspan="3">
              <?php if ($user_data['photo']): ?>
                <img src="<?php echo htmlspecialchars($user_data['photo']); ?>" class="review-photo" alt="ID Photo">
                <input type="hidden" name="photo" value="<?php echo htmlspecialchars($user_data['photo']); ?>">
              <?php endif; ?>
            </td>
          </tr>
        </table>
        <div class="review-actions">
          <button type="submit" name="edit_back" class="btn btn-warning">Edit</button>
          <button type="submit" name="confirm_registration" class="btn btn-success">Confirm & Submit</button>
        </div>
      </form>
    <?php elseif (isset($_POST['edit_back']) && isset($_POST['fname'])): ?>
      <?php
      // If user clicks Edit, repopulate the form with previous data
      $edit_data = $_POST;
      ?>
      <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <input type="hidden" name="photo" value="<?php echo htmlspecialchars($edit_data['photo']); ?>">
        <table>
          <tr>
            <td>
              <label for="fname">First Name:</label>
              <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($edit_data['fname']); ?>" required />
            </td>
            <td>
              <label for="mname">Middle Name:</label>
              <input type="text" id="mname" name="mname" value="<?php echo htmlspecialchars($edit_data['mname']); ?>" required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="lname">Last Name:</label>
              <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($edit_data['lname']); ?>" required />
            </td>
            <td>
              <label>Gender:</label>
              <input type="radio" id="gender_male" name="gender" value="Male" <?php if ($edit_data['gender'] == 'Male') echo 'checked'; ?> required /> Male
              <input type="radio" id="gender_female" name="gender" value="Female" <?php if ($edit_data['gender'] == 'Female') echo 'checked'; ?> required /> Female
            </td>
          </tr>
          <tr>
            <td>
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($edit_data['email']); ?>" placeholder="Optional: Enter your email" />
            </td>
            <td>
              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($edit_data['dob']); ?>" required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="photo">Upload ID Photo:</label>
              <input type="file" id="photo" name="photo" accept="image/*" />
              <?php if ($edit_data['photo']): ?>
                <br><img src="<?php echo htmlspecialchars($edit_data['photo']); ?>" class="review-photo" alt="ID Photo">
              <?php endif; ?>
            </td>
            <td>
              <label for="M-status">Marital Status:</label>
              <select name="status" id="M-status" style="padding: 8px">
                <option value="">Select</option>
                <option value="Single" <?php if ($edit_data['status'] == 'Single') echo 'selected'; ?>>Single</option>
                <option value="Married" <?php if ($edit_data['status'] == 'Married') echo 'selected'; ?>>Married</option>
                <option value="Divorced" <?php if ($edit_data['status'] == 'Divorced') echo 'selected'; ?>>Divorced</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <label for="Occupation">Occupation:</label>
              <input type="text" id="Occupation" name="Occupation" value="<?php echo htmlspecialchars($edit_data['occupation']); ?>" required />
            </td>
            <td>
              <label for="emergency_num">Emergency Contact:</label>
              <input type="tel" name="emergency_num" id="emergency_num" pattern="0[0-9]{9,}" value="<?php echo htmlspecialchars($edit_data['emergency_num']); ?>" placeholder="09879..." required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="mother_name">Mother's Name:</label>
              <input type="text" id="mother_name" name="mother_name" value="<?php echo htmlspecialchars($edit_data['mother_name']); ?>" required />
            </td>
            <td>
              <label for="h_number">House Number:</label>
              <input type="text" id="h_number" name="h_number" value="<?php echo htmlspecialchars($edit_data['h_number']); ?>" required />
            </td>
          </tr>
          <tr>
            <td>
              <input type="submit" name="submit_registration" value="Submit" />
            </td>
          </tr>
        </table>
      </form>
    <?php else: ?>
      <!-- Initial Registration Form -->
      <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <table>
          <tr>
            <td>
              <label for="fname">First Name:</label>
              <input type="text" id="fname" name="fname" required />
            </td>
            <td>
              <label for="mname">Middle Name:</label>
              <input type="text" id="mname" name="mname" required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="lname">Last Name:</label>
              <input type="text" id="lname" name="lname" required />
            </td>
            <td>
              <label>Gender:</label>
              <input type="radio" id="gender_male" name="gender" value="Male" required checked /> Male
              <input type="radio" id="gender_female" name="gender" value="Female" required /> Female
            </td>
          </tr>
          <tr>
            <td>
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" placeholder="Optional: Enter your email" />
            </td>
            <td>
              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="photo">Upload ID Photo:</label>
              <input type="file" id="photo" name="photo" accept="image/*" required />
            </td>
            <td>
              <label for="M-status">Marital Status:</label>
              <select name="status" id="M-status" style="padding: 8px">
                <option value="">Select</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <label for="Occupation">Occupation:</label>
              <input type="text" id="Occupation" name="Occupation" required />
            </td>
            <td>
              <label for="emergency_num">Emergency Contact:</label>
              <input type="tel" name="emergency_num" id="emergency_num" pattern="0[0-9]{9,}" placeholder="09879..." required />
            </td>
          </tr>
          <tr>
            <td>
              <label for="mother_name">Mother's Name:</label>
              <input type="text" id="mother_name" name="mother_name" required />
            </td>
            <td>
              <label for="h_number">House Number:</label>
              <input type="text" id="h_number" name="h_number" required />
            </td>
          </tr>
          <tr>
            <td>
              <input type="submit" name="submit_registration" value="Submit" />
            </td>
          </tr>
        </table>
      </form>
    <?php endif; ?>
  </section>
  <!-- <footer>
    <p>&copy;2025. All rights reserved.</p>
  </footer> -->
</body>

</html>