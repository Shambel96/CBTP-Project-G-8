<?php
// Include database connection
include("../db_connection.php");

// Initialize variables
$search_results = [];
$error_message = "";

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $house_number = htmlspecialchars(trim($_POST['house_number']));

    // Validate input
    if (empty($house_number)) {
        $error_message = "Please enter a house number to search.";
    } else {
        // Query to fetch residents with the same house number
        $query = "SELECT * FROM inhabitants WHERE house_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $house_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $search_results = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $error_message = "No residents found for the provided house number.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Residents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Search Residents by House Number</h2>

        <!-- Search Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="house_number">House Number:</label>
                <input
                    type="text"
                    class="form-control"
                    id="house_number"
                    name="house_number"
                    placeholder="Enter house number"
                    required />
            </div>
            <button type="submit" class="btn btn-primary mt-3">Search</button>
        </form>

        <!-- Display Error Message -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger mt-3"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Display Search Results -->
        <?php if (!empty($search_results)): ?>
            <div class="table-responsive mt-4">
                <h2>Here is the resident's information!</h2>
                <table class="table table-bordered table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Street Name</th>
                            <th>House Number</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($search_results as $resident): ?>
                            <tr>
                                <td><?php echo $resident['id']; ?></td>
                                <td><?php echo $resident['first_name'] . ' ' . $resident['middle_name'] . ' ' . $resident['last_name']; ?></td>
                                <td><?php echo $resident['phone']; ?></td>
                                <td><?php echo $resident['email']; ?></td>
                                <td><?php echo $resident['street_name']; ?></td>
                                <td><?php echo $resident['house_number']; ?></td>
                                <td><?php echo ucfirst($resident['gender']); ?></td>
                                <td><?php echo $resident['date_of_birth']; ?></td>
                                <td><?php echo ucfirst($resident['role']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>