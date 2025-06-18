<?php

session_start();
require_once("../ID generator/db_connection.php");

$success = $error = "";
$show_review = false;
$review_data = [];

// Helper to get image BLOB and mime type from uploaded image
function getImageBlobAndType($input_name)
{
    if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === UPLOAD_ERR_OK) {
        $imgData = file_get_contents($_FILES[$input_name]['tmp_name']);
        $mimeType = mime_content_type($_FILES[$input_name]['tmp_name']);
        return [
            'blob' => $imgData,
            'type' => $mimeType
        ];
    }
    return ['blob' => '', 'type' => ''];
}

function generateCertificateNumber($conn)
{
    $currentYear = date('Y');
    $query = "SELECT certificate_number FROM marriage_certificate 
              WHERE certificate_number LIKE 'MC-$currentYear-%'
              ORDER BY certificate_number DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $lastCert = $result->fetch_assoc()['certificate_number'];
        $parts = explode('-', $lastCert);
        $nextNum = str_pad((int)$parts[2] + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $nextNum = '000001';
    }
    return "MC-$currentYear-$nextNum";
}

// Main form submission (not confirmation or edit)
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['confirm_registration']) && !isset($_POST['edit_back'])) {
    // Generate certificate number by system
    $certificate_number = generateCertificateNumber($conn);
    $groom_name = trim($_POST['groom_name']);
    $bride_name = trim($_POST['bride_name']);
    $marriage_date = $_POST['marriage_date'];
    $state = $_POST['state'];
    $witness1_name = trim($_POST['witness1_name']);
    $witness2_name = trim($_POST['witness2_name']);
    // Always use today's date for recorded_on
    $recorded_on = date('Y-m-d');

    // Handle image uploads and get blob and mime type
    $groom_photo_info = getImageBlobAndType('groom_photo');
    $bride_photo_info = getImageBlobAndType('bride_photo');

    // If editing and no new photo uploaded, use previous photo from session
    if (empty($groom_photo_info['blob']) && isset($_SESSION['marriage_review']['groom_photo_blob'])) {
        $groom_photo_info['blob'] = $_SESSION['marriage_review']['groom_photo_blob'];
        $groom_photo_info['type'] = $_SESSION['marriage_review']['groom_photo_type'];
    }
    if (empty($bride_photo_info['blob']) && isset($_SESSION['marriage_review']['bride_photo_blob'])) {
        $bride_photo_info['blob'] = $_SESSION['marriage_review']['bride_photo_blob'];
        $bride_photo_info['type'] = $_SESSION['marriage_review']['bride_photo_type'];
    }

    // Validate all required fields
    if (
        !$certificate_number || !$groom_name || !$bride_name || !$marriage_date ||
        !$state || !$witness1_name || !$witness2_name || !$groom_photo_info['blob'] || !$bride_photo_info['blob']
    ) {
        $error = "Please fill in all required fields and upload both photos.";
    } else {
        // Store for review (store base64 for preview, blob for DB)
        $review_data = [
            'certificate_number' => $certificate_number,
            'groom_name' => $groom_name,
            'groom_photo_blob' => $groom_photo_info['blob'],
            'groom_photo_base64' => base64_encode($groom_photo_info['blob']),
            'groom_photo_type' => $groom_photo_info['type'],
            'bride_name' => $bride_name,
            'bride_photo_blob' => $bride_photo_info['blob'],
            'bride_photo_base64' => base64_encode($bride_photo_info['blob']),
            'bride_photo_type' => $bride_photo_info['type'],
            'marriage_date' => $marriage_date,
            'state' => $state,
            'witness1_name' => $witness1_name,
            'witness2_name' => $witness2_name,
            'recorded_on' => $recorded_on
        ];
        $_SESSION['marriage_review'] = $review_data;
        $show_review = true;
    }
}

// If user confirms (after review)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm_registration'])) {
    $review_data = $_SESSION['marriage_review'] ?? [];
    if ($review_data) {
        $stmt = $conn->prepare(
            "INSERT INTO marriage_certificate 
            (certificate_number, groom_name, groom_photo, groom_photo_type, bride_name, bride_photo, bride_photo_type, marriage_date, state, witness1_name, witness2_name, recorded_on)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        // Use 'b' for BLOBs
        $stmt->bind_param(
            "ssbssbssssss",
            $review_data['certificate_number'],
            $review_data['groom_name'],
            $groom_photo_blob,
            $review_data['groom_photo_type'],
            $review_data['bride_name'],
            $bride_photo_blob,
            $review_data['bride_photo_type'],
            $review_data['marriage_date'],
            $review_data['state'],
            $review_data['witness1_name'],
            $review_data['witness2_name'],
            $review_data['recorded_on']
        );
        // Send BLOB data
        $groom_photo_blob = $review_data['groom_photo_blob'];
        $bride_photo_blob = $review_data['bride_photo_blob'];
        $stmt->send_long_data(2, $groom_photo_blob); // groom_photo
        $stmt->send_long_data(5, $bride_photo_blob); // bride_photo

        if ($stmt->execute()) {
            $success = "Marriage certificate registered successfully!";
            unset($_SESSION['marriage_review']);
            header("Location: Marriage.php?cert=" . urlencode($review_data['certificate_number']));
            exit();
        } else {
            $error = "Failed to save certificate. Please try again.";
        }
        $stmt->close();
    }
}

// If user clicks Edit (after review)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_back'])) {
    $review_data = $_SESSION['marriage_review'] ?? [];
    $show_review = false;
    // Set recorded_on to today for the edit form
    $review_data['recorded_on'] = date('Y-m-d');
}

// If coming from review, load review data
if (isset($_SESSION['marriage_review']) && $show_review === false && empty($review_data)) {
    $review_data = $_SESSION['marriage_review'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Marriage Certificate Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .photo-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .review-table th {
            width: 30%;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($show_review && $review_data): ?>
            <h3 class="mb-4 text-center">Review Your Marriage Certificate Information</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <table class="table table-bordered review-table">
                    <tr>
                        <th>Certificate Number</th>
                        <td><?php echo htmlspecialchars($review_data['certificate_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Groom Name</th>
                        <td><?php echo htmlspecialchars($review_data['groom_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Groom Photo</th>
                        <td>
                            <?php if (!empty($review_data['groom_photo_base64'])): ?>
                                <img src="data:<?php echo htmlspecialchars($review_data['groom_photo_type']); ?>;base64,<?php echo $review_data['groom_photo_base64']; ?>" class="photo-preview" alt="Groom Photo">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Bride Name</th>
                        <td><?php echo htmlspecialchars($review_data['bride_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Bride Photo</th>
                        <td>
                            <?php if (!empty($review_data['bride_photo_base64'])): ?>
                                <img src="data:<?php echo htmlspecialchars($review_data['bride_photo_type']); ?>;base64,<?php echo $review_data['bride_photo_base64']; ?>" class="photo-preview" alt="Bride Photo">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td><?php echo htmlspecialchars($review_data['marriage_date']); ?></td>
                    </tr>
                    <tr>
                        <th>State/Region</th>
                        <td><?php echo htmlspecialchars($review_data['state']); ?></td>
                    </tr>
                    <tr>
                        <th>Witness 1 Name</th>
                        <td><?php echo htmlspecialchars($review_data['witness1_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Witness 2 Name</th>
                        <td><?php echo htmlspecialchars($review_data['witness2_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Recorded On</th>
                        <td><?php echo htmlspecialchars($review_data['recorded_on']); ?></td>
                    </tr>
                </table>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" name="edit_back" class="btn btn-warning">Edit</button>
                    <button type="submit" name="confirm_registration" class="btn btn-success">Confirm & Submit</button>
                </div>
            </form>
        <?php else: ?>
            <!-- Edit form: repopulate with previous data -->
            <form id="marriageForm" action="" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-white" style="max-width:600px;margin:auto;">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="groom_name" class="form-label required-field">Groom Name</label>
                        <input type="text" class="form-control" id="groom_name" name="groom_name"
                            required value="<?php echo htmlspecialchars($review_data['groom_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="groom_photo" class="form-label required-field">Groom Photo</label>
                        <input type="file" class="form-control" id="groom_photo" name="groom_photo" accept="image/*" <?php echo empty($review_data['groom_photo_base64']) ? 'required' : ''; ?>>
                        <?php if (!empty($review_data['groom_photo_base64'])): ?>
                            <img src="data:<?php echo htmlspecialchars($review_data['groom_photo_type']); ?>;base64,<?php echo $review_data['groom_photo_base64']; ?>" class="photo-preview mt-2" alt="Groom Photo">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="bride_name" class="form-label required-field">Bride Name</label>
                        <input type="text" class="form-control" id="bride_name" name="bride_name"
                            required value="<?php echo htmlspecialchars($review_data['bride_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="bride_photo" class="form-label required-field">Bride Photo</label>
                        <input type="file" class="form-control" id="bride_photo" name="bride_photo" accept="image/*" <?php echo empty($review_data['bride_photo_base64']) ? 'required' : ''; ?>>
                        <?php if (!empty($review_data['bride_photo_base64'])): ?>
                            <img src="data:<?php echo htmlspecialchars($review_data['bride_photo_type']); ?>;base64,<?php echo $review_data['bride_photo_base64']; ?>" class="photo-preview mt-2" alt="Bride Photo">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="marriage_date" class="form-label required-field">Marriage Date</label>
                    <input type="date" class="form-control" id="marriage_date" name="marriage_date"
                        required value="<?php echo htmlspecialchars($review_data['marriage_date'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label required-field">State/Region</label>
                    <input type="text" class="form-control" id="state" name="state" value="Oromia Region" required readonly>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="witness1_name" class="form-label required-field">Witness 1 Name</label>
                        <input type="text" class="form-control" id="witness1_name" name="witness1_name"
                            required value="<?php echo htmlspecialchars($review_data['witness1_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="witness2_name" class="form-label required-field">Witness 2 Name</label>
                        <input type="text" class="form-control" id="witness2_name" name="witness2_name"
                            required value="<?php echo htmlspecialchars($review_data['witness2_name'] ?? ''); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recorded_on" class="form-label">Recorded On</label>
                    <input type="date" class="form-control" id="recorded_on" name="recorded_on"
                        value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>