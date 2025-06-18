<?php
include("../db_connection.php");

// Initialize variables
$resident = null;
$error_message = "";

// Handle search request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_id'])) {
    $search_id = $_POST['search_id'];

    // Fetch resident data based on the ID
    $query = "SELECT * FROM inhabitants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resident = $result->fetch_assoc();
    $stmt->close();

    if (!$resident) {
        $error_message = "Resident with ID $search_id not found.";
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_resident'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $street_name = $_POST['street_name'];
    $house_number = $_POST['house_number'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];

    $query = "UPDATE inhabitants SET first_name = ?, middle_name = ?, last_name = ?, phone = ?, email = ?, street_name = ?, house_number = ?, gender = ?, date_of_birth = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $first_name, $middle_name, $last_name, $phone, $email, $street_name, $house_number, $gender, $date_of_birth, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Resident updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating resident: " . $conn->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Resident</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Search Resident by ID</h4>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="search_id" class="form-label">Resident ID</label>
                                <input type="number" id="search_id" name="search_id" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <?php if ($resident): ?>
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h4>Update Resident Information</h4>
                        </div>
                        <div class="card-body">
                            <!-- Update Form -->
                            <form method="POST" action="">
                                <!-- Hidden input for resident ID -->
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($resident['id']); ?>">

                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" id="firstName" name="first_name" class="form-control" value="<?php echo htmlspecialchars($resident['first_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" id="middleName" name="middle_name" class="form-control" value="<?php echo htmlspecialchars($resident['middle_name']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" id="lastName" name="last_name" class="form-control" value="<?php echo htmlspecialchars($resident['last_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($resident['phone']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($resident['email']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="streetName" class="form-label">Street Name</label>
                                    <input type="text" id="streetName" name="street_name" class="form-control" value="<?php echo htmlspecialchars($resident['street_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="houseNumber" class="form-label">House Number</label>
                                    <input type="text" id="houseNumber" name="house_number" class="form-control" value="<?php echo htmlspecialchars($resident['house_number']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select" required>
                                        <option value="male" <?php echo $resident['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo $resident['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                                        <option value="other" <?php echo $resident['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                    <input type="date" id="dateOfBirth" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($resident['date_of_birth']); ?>" required>
                                </div>

                                <button type="submit" name="update_resident" class="btn btn-success">Update Resident</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>