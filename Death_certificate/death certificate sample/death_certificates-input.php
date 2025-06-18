<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Death Certificate Form</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background-color: #f5f5f5;
        color: #333;
      }
      .death-form {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
      }
      .form-group {
        margin-bottom: 20px;
      }
      label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }
      input[type="text"],
      input[type="date"],
      input[type="file"],
      select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
      }
      .btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
      }
      .btn:hover {
        background-color: #45a049;
      }
      .flex-container {
        display: flex;
        gap: 20px;
      }
      .flex-item {
        flex: 1;
      }
    </style>
    <script>
      window.addEventListener('DOMContentLoaded', function () {
        // Prefill logic using PHP session data if present
        <?php
        if (isset($_GET['edit']) && isset($_SESSION['death_form'])):
          $data = $_SESSION['death_form'];
        ?>
          document.getElementById('full_name').value = "<?php echo htmlspecialchars($data['full_name']); ?>";
          document.getElementById('date_of_birth').value = "<?php echo htmlspecialchars($data['date_of_birth']); ?>";
          document.getElementById('date_of_death').value = "<?php echo htmlspecialchars($data['date_of_death']); ?>";
          document.getElementById('place_of_death').value = "<?php echo htmlspecialchars($data['place_of_death']); ?>";
          document.getElementById('cause_of_death').value = "<?php echo htmlspecialchars($data['cause_of_death']); ?>";
          document.getElementById('father_name').value = "<?php echo htmlspecialchars($data['father_name']); ?>";
          document.getElementById('mother_name').value = "<?php echo htmlspecialchars($data['mother_name']); ?>";
          document.getElementById('memorial_message1').value = "<?php echo htmlspecialchars($data['memorial_message1']); ?>";
          document.getElementById('memorial_message2').value = "<?php echo htmlspecialchars($data['memorial_message2']); ?>";
          document.getElementById('issued_date').value = "<?php echo htmlspecialchars($data['issued_date']); ?>";
        <?php endif; ?>

        // Set issued date to today and make it readonly if not editing
        const issuedDate = document.getElementById('issued_date');
        if (!issuedDate.value) {
          const today = new Date().toISOString().split('T')[0];
          issuedDate.value = today;
        }
        issuedDate.readOnly = true;

        // Set kebele name and official name to constants and readonly
        document.getElementById('kebele_name').value = "Ginjo kebele";
        document.getElementById('kebele_name').readOnly = true;
        document.getElementById('official_name').value = "Ginjo Administration";
        document.getElementById('official_name').readOnly = true;

        // Validation on submit
        document.querySelector('.death-form').addEventListener('submit', function (e) {
          const fullName = document.getElementById('full_name').value.trim();
          if (fullName.length < 1 || fullName.length > 50) {
            alert("Full Name must be between 1 and 50 characters.");
            e.preventDefault();
            return;
          }
          const dob = document.getElementById('date_of_birth').value;
          const dod = document.getElementById('date_of_death').value;
          const now = new Date().toISOString().split('T')[0];
          if (dob && dob > now) {
            alert("Date of Birth cannot be in the future.");
            e.preventDefault();
            return;
          }
          if (dod && dod > now) {
            alert("Date of Death cannot be in the future.");
            e.preventDefault();
            return;
          }
        });
      });
    </script>
  </head>
  <body>
    <form
      class="death-form"
      method="POST"
      action="review_death.php"
      enctype="multipart/form-data"
    >
      <h1>Death Certificate Information</h1>

      <div class="form-group">
        <label for="photo">Deceased Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" />
      </div>

      <div class="form-group">
        <label for="full_name">Full Name:</label>
        <input
          type="text"
          id="full_name"
          name="full_name"
          maxlength="50"
          required
        />
      </div>

      <div class="flex-container">
        <div class="form-group flex-item">
          <label for="date_of_birth">Date of Birth:</label>
          <input type="date" id="date_of_birth" name="date_of_birth" required />
        </div>
        <div class="form-group flex-item">
          <label for="date_of_death">Date of Death:</label>
          <input type="date" id="date_of_death" name="date_of_death" required />
        </div>
      </div>

      <div class="form-group">
        <label for="place_of_death">Place of Death:</label>
        <input type="text" id="place_of_death" name="place_of_death" required />
      </div>

      <div class="form-group">
        <label for="cause_of_death">Cause of Death:</label>
        <select id="cause_of_death" name="cause_of_death" required>
          <option value="Natural Causes">Natural Causes</option>
          <option value="Illness">Illness</option>
          <option value="Accident">Accident</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" required />
      </div>

      <div class="form-group">
        <label for="mother_name">Mother's Name:</label>
        <input type="text" id="mother_name" name="mother_name" required />
      </div>

      <div class="form-group">
        <label for="memorial_message1">Memorial Message (Line 1):</label>
        <input
          type="text"
          id="memorial_message1"
          name="memorial_message1"
          value="Loved one's wonderful and gentle soul will"
          required
        />
      </div>

      <div class="form-group">
        <label for="memorial_message2">Memorial Message (Line 2):</label>
        <input
          type="text"
          id="memorial_message2"
          name="memorial_message2"
          value="forever remain in our hearts."
          required
        />
      </div>

      <div class="form-group">
        <label for="kebele_name">Kebele Name:</label>
        <input type="text" id="kebele_name" name="kebele_name" required />
      </div>

      <div class="form-group">
        <label for="issued_date">Issued Date:</label>
        <input type="date" id="issued_date" name="issued_date" required />
      </div>

      <div class="form-group">
        <label for="official_name">Official Name:</label>
        <input type="text" id="official_name" name="official_name" required />
      </div>

      <button type="submit" class="btn">Generate Certificate</button>
    </form>
  </body>
</html>
