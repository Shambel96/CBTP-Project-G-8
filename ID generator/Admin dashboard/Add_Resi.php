<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Resident</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="center-container">
        <div class="dashboard">
            <div class="main-content">
                <div class="header">
                    <h2>Add New Resident</h2>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Resident Information</h2>
                    </div>
                    <form id="addResidentForm" action="#" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" required>
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
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="houseNumber">House Number</label>
                                <input type="text" id="houseNumber" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="streetName">Street Name</label>
                                <input type="text" id="streetName" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add Resident</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>