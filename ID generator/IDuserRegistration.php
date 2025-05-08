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
</head>

<body>
  <header>
    <ul>
      <li>
        <a href="SampleIDpage.Php"><i class="fa-solid fa-backward"></i></a>
      </li>
      <li><a href="index.php" target="_blank">Home</a></li>
    </ul>
  </header>
  <section class="register-form">
    <h2>ID Registration Form</h2>
    <form action="/submit_registration" method="POST">
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
            <input
              type="radio"
              id="gender_male"
              name="gender"
              value="Male"
              required
              checked />
            Male
            <input
              type="radio"
              id="gender_female"
              name="gender"
              value="Female"
              required />
            Female
          </td>
        </tr>
        <tr>
          <td>
            <label for="email">Email:</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Optional: Enter your email" />
          </td>
          <td>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required />
          </td>
        </tr>
        <tr>
          <td>
            <label for="photo">Upload ID Photo:</label>
            <input
              type="file"
              id="photo"
              name="photo"
              accept="image/*"
              required />
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
            <input
              type="tel"
              name="emergency_num"
              id="emergency_num"
              pattern="0[0-9]{9,}"
              placeholder="09879..."
              required />
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
            <input type="submit" value="Register" />
          </td>
        </tr>
      </table>
    </form>
  </section>
  <footer>
    <p>&copy;2025. All rights reserved.</p>
  </footer>
</body>

</html>