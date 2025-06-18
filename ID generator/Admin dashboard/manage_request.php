<?php
// Include database connection
include("../db_connection.php");

// Handle AJAX status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
  $id = intval($_POST['id']);
  $status = ($_POST['status'] === 'accepted') ? 'accepted' : 'rejected';
  $update = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
  $update->bind_param("si", $status, $id);
  $success = $update->execute();
  $update->close();
  echo json_encode(['success' => $success]);
  exit;
}
// Fetch data from the applications table (only pending)
$query = "SELECT id AS request_id, name AS resident_name, certificate_type AS request_type, house_number, submission_date AS date_submitted FROM applications WHERE status IS NULL OR status = '' OR status = 'pending'";
$result = $conn->query($query);

// Check for database errors
if (!$result) {
  die("Error fetching data: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
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
    <h2>Pending Requests</h2>
    <!-- Display Requests Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="requestsTable">
        <thead class="bg-dark text-white">
          <tr>
            <th>Request ID</th>
            <th>Resident Name</th>
            <th>Request Type</th>
            <th>Date Submitted</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr id="row-<?php echo $row['request_id']; ?>">
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['resident_name']; ?></td>
                <td><?php echo ucfirst(str_replace('_', ' ', $row['request_type'])); ?></td>
                <td><?php echo $row['date_submitted']; ?></td>
                <td>
                  <!-- Actions: Accept, Reject, and Details -->
                  <button class="btn btn-success btn-sm accept-btn" data-id="<?php echo $row['request_id']; ?>">Accept</button>
                  <button class="btn btn-danger btn-sm reject-btn" data-id="<?php echo $row['request_id']; ?>">Reject</button>
                  <a href="request_details.php?house_number=<?php echo $row['house_number']; ?>" class="btn btn-info btn-sm">Details</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No requests found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    document.querySelectorAll('.accept-btn, .reject-btn').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        var status = this.classList.contains('accept-btn') ? 'accepted' : 'rejected';
        var row = document.getElementById('row-' + id);

        fetch('', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(status)
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              row.remove();
            } else {
              alert('Failed to update status.');
            }
          })
          .catch(() => alert('Failed to update status.'));
      });
    });
  </script>
</body>

</html>