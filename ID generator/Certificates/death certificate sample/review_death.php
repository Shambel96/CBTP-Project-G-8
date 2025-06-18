<?php

session_start();
require_once("../../db_connection.php"); // Make sure this path is correct

// Helper: Generate certificate number in PHP, do NOT use $_POST['certificate_number']
function generateDeathCertificateNumber($conn)
{
    $currentYear = date('Y');
    $query = "SELECT certificate_number FROM death_certificate 
              WHERE certificate_number LIKE 'DC-$currentYear-%'
              ORDER BY certificate_number DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $lastCert = $result->fetch_assoc()['certificate_number'];
        $parts = explode('-', $lastCert);
        $nextNum = str_pad((int)$parts[2] + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $nextNum = '000001';
    }
    return "DC-$currentYear-$nextNum";
}

// If user clicks Edit, repopulate form with previous data
if (isset($_GET['edit'])) {
    // Repopulate form with previous values
    if (isset($_SESSION['death_form'])) {
        $data = $_SESSION['death_form'];
        // Pass data as query string for GET prefill (not secure for photo, so use session)
        header("Location: death_certificate.php?edit=1");
        exit;
    } else {
        header("Location: death_certificate.php");
        exit;
    }
}

// Handle POST from form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store form data in session for review and possible editing
    $_SESSION['death_form'] = $_POST;
    // Handle photo upload temporarily
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $_SESSION['death_form']['photo_tmp'] = base64_encode(file_get_contents($_FILES['photo']['tmp_name']));
        $_SESSION['death_form']['photo_name'] = $_FILES['photo']['name'];
        $_SESSION['death_form']['photo_type'] = $_FILES['photo']['type'];
    }
    // Generate certificate number here and store in session (not from user input)
    if (!isset($_SESSION['death_form']['certificate_number']) || empty($_SESSION['death_form']['certificate_number'])) {
        $_SESSION['death_form']['certificate_number'] = generateDeathCertificateNumber($conn);
    }
    header("Location: review_death.php");
    exit;
}

// If coming from the form, show review
$data = $_SESSION['death_form'] ?? null;
if (!$data) {
    header("Location: death_certificate.php");
    exit;
}

// For image preview
$photo_src = isset($data['photo_tmp']) ? "data:" . htmlspecialchars($data['photo_type']) . ";base64," . $data['photo_tmp'] : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Review Death Certificate Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .review-container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            padding: 32px;
        }

        .review-photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .review-photo img {
            max-width: 120px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .review-table td {
            padding: 6px 12px;
        }

        .review-actions {
            margin-top: 30px;
            text-align: center;
        }

        .review-actions form {
            display: inline;
        }
    </style>
</head>

<body>
    <div class="review-container">
        <h2 class="mb-4 text-center">Review Death Certificate Information</h2>
        <?php if ($photo_src): ?>
            <div class="review-photo">
                <img src="<?php echo $photo_src; ?>" alt="Deceased Photo">
            </div>
        <?php endif; ?>
        <table class="table review-table">
            <tr>
                <td><b>Full Name:</b></td>
                <td><?php echo htmlspecialchars($data['full_name']); ?></td>
            </tr>
            <tr>
                <td><b>Date of Birth:</b></td>
                <td><?php echo htmlspecialchars($data['date_of_birth']); ?></td>
            </tr>
            <tr>
                <td><b>Date of Death:</b></td>
                <td><?php echo htmlspecialchars($data['date_of_death']); ?></td>
            </tr>
            <tr>
                <td><b>Place of Death:</b></td>
                <td><?php echo htmlspecialchars($data['place_of_death']); ?></td>
            </tr>
            <tr>
                <td><b>Cause of Death:</b></td>
                <td><?php echo htmlspecialchars($data['cause_of_death']); ?></td>
            </tr>
            <tr>
                <td><b>Father's Name:</b></td>
                <td><?php echo htmlspecialchars($data['father_name']); ?></td>
            </tr>
            <tr>
                <td><b>Mother's Name:</b></td>
                <td><?php echo htmlspecialchars($data['mother_name']); ?></td>
            </tr>
            <tr>
                <td><b>Memorial Message 1:</b></td>
                <td><?php echo htmlspecialchars($data['memorial_message1']); ?></td>
            </tr>
            <tr>
                <td><b>Memorial Message 2:</b></td>
                <td><?php echo htmlspecialchars($data['memorial_message2']); ?></td>
            </tr>
            <tr>
                <td><b>Kebele Name:</b></td>
                <td><?php echo htmlspecialchars($data['kebele_name']); ?></td>
            </tr>
            <tr>
                <td><b>Certificate Number:</b></td>
                <td><?php echo htmlspecialchars($data['certificate_number']); ?></td>
            </tr>
            <tr>
                <td><b>Issued Date:</b></td>
                <td><?php echo htmlspecialchars($data['issued_date']); ?></td>
            </tr>
            <tr>
                <td><b>Official Name:</b></td>
                <td><?php echo htmlspecialchars($data['official_name']); ?></td>
            </tr>
        </table>
        <div class="review-actions">
            <form method="get" action="death_certificates-input.php">
                <button type="submit" class="btn btn-warning">Edit</button>
            </form>
            <form method="post" action="submit_death.php" style="display:inline;">
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
            <form method="get" action="death_certificates-input.php" style="display:inline;">
                <button type="submit" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>