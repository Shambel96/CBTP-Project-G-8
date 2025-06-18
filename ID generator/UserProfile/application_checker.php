<?php


session_start();
require_once("../db_connection.php");
if (!isset($_SESSION['id'])) {
    header("Location: ../signin.php");
    exit();
}

$user_id = $_SESSION['id'];
$full_name = htmlspecialchars($_SESSION['first_name'] ?? 'User') . ' ' . htmlspecialchars($_SESSION['last_name'] ?? '');

$applications = [];
$sql = "SELECT certificate_type, status FROM applications WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($certificate_type, $status);
    while ($stmt->fetch()) {
        $applications[] = [
            'certificate_type' => $certificate_type,
            'status' => $status
        ];
    }
    $stmt->close();
}
$conn->close();

function getRequestLink($certificate_type)
{
    $type = strtolower(str_replace(' ', '_', $certificate_type));
    if ($type === 'residence_id') {
        return '../IDuserRegistration.php';
    } elseif ($type === 'birth_certificate') {
        return '../Certificates/birth-input.php';
    } elseif ($type === 'marriage_certificate') {
        return '../Certificates/marriage/Marriage_register.php';
    } elseif ($type === 'death_certificate') {
        return '../Certificates/death certificate sample/death_certificates_input.php';
    }
    return '#';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Requests - <?php echo $full_name; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .request-status {
            max-width: 600px;
            margin: 40px auto;
        }

        .proceed-btn {
            min-width: 100px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container request-status">
        <h2 class="mb-4">My Application Requests</h2>
        <?php if (empty($applications)): ?>
            <div class="alert alert-info">You have not submitted any applications yet.</div>
        <?php else: ?>
            <?php foreach ($applications as $app): ?>
                <?php if ($app['status'] === 'Accepted'): ?>
                    <div class="alert alert-success d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <b><?php echo htmlspecialchars($app['certificate_type']); ?></b> request: <b>Accepted</b>.
                        </div>
                        <div class="proceed-btn">
                            <a href="<?php echo getRequestLink($app['certificate_type']); ?>" class="btn btn-success btn-sm" target="contentFrame">
                                Proceed
                            </a>
                        </div>
                    </div>
                <?php elseif ($app['status'] === 'Rejected'): ?>
                    <div class="alert alert-danger mb-2">
                        <b><?php echo htmlspecialchars($app['certificate_type']); ?></b> request: <b>Rejected</b>. You do not have permission for this request until it is accepted.
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary mb-2">
                        <b><?php echo htmlspecialchars($app['certificate_type']); ?></b> request: <b><?php echo ucfirst($app['status']); ?></b>.
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>