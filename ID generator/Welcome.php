<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Welcome</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .welcome-message {
      text-align: center;
      margin: 20px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Welcome to the Admin Dashboard</h1>
    <div class="welcome-message">
      <p>
        Hello, Admin! You can manage applications, view reports, and perform
        various administrative tasks from this dashboard.
      </p>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
          <div class="card-header">Manage Applications</div>
          <div class="card-body">
            <h5 class="card-title">View and Approve Applications</h5>
            <p class="card-text">
              Check the status of applications and approve or reject them.
            </p>
            <a href="admin dashboard/manage_request.php" class="btn btn-light">Go to Applications</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
          <div class="card-header">Generate Reports</div>
          <div class="card-body">
            <h5 class="card-title">View Reports</h5>
            <p class="card-text">
              Generate and download reports based on applications.
            </p>
            <a href="view_reports.php" class="btn btn-light">Go to Reports</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-danger mb-3">
          <div class="card-header">User Management</div>
          <div class="card-body">
            <h5 class="card-title">Manage Users</h5>
            <p class="card-text">
              Add, edit, or remove users from the system.
            </p>
            <a href="admin dashboard/manage_users.php" class="btn btn-light">Go to Users</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>