<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Inhabitant</title>
    <link rel="stylesheet" href="css/add-resident-style.css">
</head>

<body>
    <div class="center-container">
        <div class="dashboard">
            <div class="main-content">
                <div class="header">
                    <h2>Add New Inhabitant</h2>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Inhabitant Information</h2>
                    </div>
                    <form id="addInhabitantForm" action="add_inhabitant.php" method="post" onsubmit="return validateForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="first_name" class="form-control" required>
                                <small class="error-message" id="firstNameError"></small>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" name="middle_name" class="form-control">
                                <small class="error-message" id="middleNameError"></small>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" class="form-control" required>
                                <small class="error-message" id="lastNameError"></small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" required>
                                <small class="error-message" id="phoneError"></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <small class="error-message" id="emailError"></small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="male" name="gender" value="male" checked>
                                        <label for="male">Male</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="female" name="gender" value="female">
                                        <label for="female">Female</label>
                                    </div>
                                    <!--  <div class="radio-option">
                                        <input type="radio" id="other" name="gender" value="other">
                                        <label for="other">Other</label>
                                    </div> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="date_of_birth" class="form-control" required>
                                <small class="error-message" id="dobError"></small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="houseNumber">House Number</label>
                                <input type="text" id="houseNumber" name="house_number" class="form-control" required>
                                <small class="error-message" id="houseNumberError"></small>
                            </div>
                            <div class="form-group">
                                <label for="streetName">Street Name</label>
                                <input type="text" id="streetName" name="street_name" class="form-control" required>
                                <small class="error-message" id="streetNameError"></small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Inhabitant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/add_resident.js"></script>
</body>

</html>