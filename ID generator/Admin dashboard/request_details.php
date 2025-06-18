<?php
// Include database connection
include("../db_connection.php");

// Check if house_number is provided
if (isset($_GET['house_number'])) {
    $house_number = $_GET['house_number'];

    // Fetch user details from the inhabitants table
    $query = "SELECT * FROM inhabitants WHERE house_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $house_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error_message = "No details found for the provided house number.";
    }

    $stmt->close();
} else {
    $error_message = "No house number provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Request Details</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php else: ?>
            <table class="table table-bordered">
                <tr>
                    <th>Full Name</th>
                    <td><?php echo $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name']; ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo $user['phone']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <tr>
                    <th>Street Name</th>
                    <td><?php echo $user['street_name']; ?></td>
                </tr>
                <tr>
                    <th>House Number</th>
                    <td><?php echo $user['house_number']; ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo ucfirst($user['gender']); ?></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><?php echo $user['date_of_birth']; ?></td>
                </tr>
            </table>
        <?php endif; ?>

        <a href="manage_request.php" class="btn btn-primary mt-3">Back to Manage Requests</a>
    </div>
</body>

</html>