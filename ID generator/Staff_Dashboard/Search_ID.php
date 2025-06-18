<?php
// filepath: c:\xampp\htdocs\shanbe\CBTP G-8\ID generator\Staff_Dashboard\search_by_id.php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id'])) {
    header("Location: ../signin.php");
    exit();
}
include("../db_connection.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search_id = trim($_POST['search_id'] ?? '');
    if ($search_id === "") {
        $error = "Please enter an ID number.";
    } else {
        // Check if the ID exists in the table
        $stmt = $conn->prepare("SELECT id FROM id_registers WHERE id = ?");
        $stmt->bind_param("i", $search_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // Redirect to IDpage.php with the found id
            header("Location: ../IDpage.php?id=" . urlencode($search_id));
            exit();
        } else {
            $error = "No record found with this ID number.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search by ID Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .search-container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(67, 97, 238, 0.08);
            padding: 32px 24px;
        }
    </style>
</head>

<body>
    <div class="search-container">
        <h3 class="mb-4 text-center">Search Resident's ID by their ID Number</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="search_id" class="form-label">Enter ID Number</label>
                <input type="number" class="form-control" id="search_id" name="search_id" required autofocus>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</body>

</html>