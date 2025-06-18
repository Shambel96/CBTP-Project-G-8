<?php
require_once("../db_connection.php");

// Fetch all applications and count statuses for admin
$applications = [];
$status_counts = [
    'pending' => 0,
    'accepted' => 0,
    'rejected' => 0
];

$sql = "SELECT id, name, contact, certificate_type, status, submission_date FROM applications ORDER BY submission_date DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
        $status = strtolower($row['status']);
        if (isset($status_counts[$status])) {
            $status_counts[$status]++;
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Applications Overview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f7fa;
        }

        .status-boxes {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .status-box {
            flex: 1 1 180px;
            min-width: 180px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(67, 97, 238, 0.09);
            padding: 1.5rem 1rem;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .status-pending {
            border-left: 6px solid #ffc107;
        }

        .status-accepted {
            border-left: 6px solid #28a745;
        }

        .status-rejected {
            border-left: 6px solid #dc3545;
        }

        .status-count {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .applications-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(67, 97, 238, 0.09);
            padding: 1.5rem;
        }

        .badge-pending {
            background: #ffc107;
            color: #212529;
        }

        .badge-accepted {
            background: #28a745;
        }

        .badge-rejected {
            background: #dc3545;
        }

        @media (max-width: 900px) {
            .status-boxes {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold">Total Applications Overview</h2>
        <div class="status-boxes">
            <div class="status-box status-pending">
                <div class="status-count"><?php echo $status_counts['pending']; ?></div>
                Pending
            </div>
            <div class="status-box status-accepted">
                <div class="status-count"><?php echo $status_counts['accepted']; ?></div>
                Accepted
            </div>
            <div class="status-box status-rejected">
                <div class="status-count"><?php echo $status_counts['rejected']; ?></div>
                Rejected
            </div>
        </div>

        <!-- ...existing code... -->
        <div class="applications-table mt-4">
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search applicants by name, contact, type, or status...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="applicationsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Requested At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($applications) > 0): ?>
                            <?php foreach ($applications as $i => $app): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($app['name']); ?></td>
                                    <td><?php echo htmlspecialchars($app['contact']); ?></td>
                                    <td><?php echo htmlspecialchars($app['certificate_type']); ?></td>
                                    <td>
                                        <?php
                                        $status = strtolower($app['status']);
                                        if ($status == 'pending') {
                                            echo '<span class="badge badge-pending">Pending</span>';
                                        } elseif ($status == 'accepted') {
                                            echo '<span class="badge badge-accepted">Accepted</span>';
                                        } elseif ($status == 'rejected') {
                                            echo '<span class="badge badge-rejected">Rejected</span>';
                                        } else {
                                            echo htmlspecialchars($app['status']);
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($app['submission_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No applications found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ...existing code... -->
        <script>
            // Simple client-side search for the applications table
            document.getElementById('searchInput').addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#applicationsTable tbody tr');
                rows.forEach(function(row) {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        </script>
</body>

</html>