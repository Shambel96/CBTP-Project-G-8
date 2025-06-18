<?php
// Include database connection
include("../db_connection.php");

// Fetch the number of pending requests
$query = "SELECT COUNT(*) AS pending_count FROM applications WHERE status = 'Pending'";
$result = $conn->query($query);
$pending_count = 0;

if ($result && $row = $result->fetch_assoc()) {
    $pending_count = $row['pending_count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .notification-icon {
            background-color: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 6px;
            margin-left: 5px;
        }

        .header {
            margin-left: 250px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
        }

        .content {
            margin-left: 250px;
            margin-top: 80px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar Section -->
    <div class="sidebar">
        <h2 class="text-center">Ginjo</h2>
        <a href="manage_request.php" target="contentFrame" class="btn btn-link text-start">
            Manage Requests
            <?php if ($pending_count > 0): ?>
                <span class="notification-icon"><?php echo $pending_count; ?></span>
            <?php endif; ?>
        </a>
        <a href="Manage_residents.php" target="contentFrame" class="btn btn-link text-start">Manage Residents</a>
        <a href="manage_users.php" target="contentFrame" class="btn btn-link text-start">Manage Users</a>
        <a href="generate_reports.php" target="contentFrame" class="btn btn-link text-start">Generate Reports</a>
        <a href="settings.php" target="contentFrame" class="btn btn-link text-start">Settings</a>
        <a href="Search_Residents.php" target="contentFrame" class="btn btn-link text-start">Search Residents</a>
        <a href="settings.php" target="contentFrame" class="btn btn-link text-start">Contact Support</a>
        <a href="settings.php" target="contentFrame" class="btn btn-link text-start">Verify Certificates</a>
        <a href="logout.php" target="_self" class="btn btn-link text-start">Logout</a>
    </div>

    <!-- Header Section -->
    <div class="header">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>

    <!-- Content Section -->
    <div class="content">
        <iframe name="contentFrame" src="manage_request.php" frameborder="0" width="100%" height="600px"></iframe>
    </div>
</body>

</html>