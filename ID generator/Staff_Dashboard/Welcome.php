<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Staff Dashboard</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #eef2f7;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard {
      max-width: 900px;
      margin: 60px auto;
    }

    .dashboard-title {
      text-align: center;
      margin-bottom: 40px;
      font-weight: 600;
      color: #333;
    }

    .card-custom {
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .card-custom:hover {
      transform: translateY(-5px);
    }

    .card-icon {
      font-size: 40px;
      margin-bottom: 15px;
      color: white;
    }

    .btn-custom {
      border-radius: 20px;
      padding: 6px 16px;
    }

    .card-body {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container dashboard">
    <h2 class="dashboard-title">Welcome to the Staff Dashboard</h2>

    <div class="row">
      <!-- Manage Applications -->
      <div class="col-md-6 mb-4">
        <div class="card card-custom bg-primary text-white">
          <div class="card-body">
            <div class="card-icon"><i class="fas fa-file-alt"></i></div>
            <h5 class="card-title">Manage Applications</h5>
            <p class="card-text">Review, approve, or reject user applications with searching ease.</p>
            <a href="../Admin dashboard/manage_request.php" class="btn btn-light btn-custom">Go to Applications</a>
          </div>
        </div>
      </div>

      <!-- Resident Management -->
      <div class="col-md-6 mb-4">
        <div class="card card-custom bg-dark text-white">
          <div class="card-body">
            <div class="card-icon"><i class="fas fa-user-friends"></i></div>
            <h5 class="card-title">Resident Management</h5>
            <p class="card-text">Add, update, or manage resident records securely and efficiently.</p>
            <a href="../Admin dashboard/Manage_residents.php" class="btn btn-light btn-custom">Go to Residents</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>