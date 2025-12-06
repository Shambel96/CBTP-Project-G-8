<?php


session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id'])) {
  header("Location: ../signin.php");
  exit();
}
$first_name = htmlspecialchars($_SESSION['first_name'] ?? 'User');
$last_name = htmlspecialchars($_SESSION['last_name'] ?? '');
$full_name = trim("$first_name $last_name");

// Notification logic
require_once("../db_connection.php");
$user_id = $_SESSION['id'];

// Check user role
$role = '';
$role_stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
if ($role_stmt) {
  $role_stmt->bind_param("i", $user_id);
  $role_stmt->execute();
  $role_stmt->bind_result($role);
  $role_stmt->fetch();
  $role_stmt->close();
}

if ($role !== 'public') {
  // Restrict access for non-public users
  echo '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Access Denied</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-5">
      <div class="alert alert-danger text-center">
        <h3>Access Denied</h3>
        <p>You do not have permission to access this page.</p>
        <a href="../signin.php" class="btn btn-primary mt-3">Return to Login</a>
      </div>
    </div>
  </body>
  </html>';
  exit();
}

// Fetch user's phone number from users table
$phone = $_SESSION['phone'];
$phone_stmt = $conn->prepare("SELECT phone FROM users WHERE id = ?");
if ($phone_stmt) {
  $phone_stmt->bind_param("i", $user_id);
  $phone_stmt->execute();
  $phone_stmt->bind_result($phone);
  $phone_stmt->fetch();
  $phone_stmt->close();
}

// Sidebar menu access (accepted application)
$has_accepted_application = false;
$app_check_stmt = $conn->prepare("SELECT COUNT(*) FROM applications WHERE user_id = ? AND status = 'accepted'");
if ($app_check_stmt) {
  $app_check_stmt->bind_param("i", $user_id);
  $app_check_stmt->execute();
  $app_check_stmt->bind_result($accepted_count);
  $app_check_stmt->fetch();
  $has_accepted_application = ($accepted_count > 0);
  $app_check_stmt->close();
}

// Notifications for bell (old logic, keep if needed)
$notif_count = 0;
$notifications = [];
$sql = "SELECT id, status FROM applications WHERE user_id = ? AND (status = 'accepted' OR status = 'rejected')";
$stmt = $conn->prepare($sql);
if ($stmt) {
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($app_id, $status);
  while ($stmt->fetch()) {
    if ($status === 'accepted') {
      $notifications[] = [
        'id' => $app_id,
        'message' => '<span class="ms-2 badge bg-success">Your application has been <b>accepted</b>.</span>',
        'icon' => 'fa-circle-check',
        'icon_color' => 'text-success'
      ];
    } elseif ($status === 'rejected') {
      $notifications[] = [
        'id' => $app_id,
        'message' => '<span class="ms-2 badge bg-danger">Your application has been <b>rejected</b>.</span>',
        'icon' => 'fa-circle-xmark',
        'icon_color' => 'text-danger'
      ];
    }
  }
  $notif_count = count($notifications);
  $stmt->close();
}

// Notifications for "Notifications" sidebar link (with certificate_type and action)
$applications = [];
$sql2 = "SELECT certificate_type, status FROM applications WHERE user_id = ?";
$stmt2 = $conn->prepare($sql2);
if ($stmt2) {
  $stmt2->bind_param("i", $user_id);
  $stmt2->execute();
  $stmt2->bind_result($certificate_type, $status);
  while ($stmt2->fetch()) {
    $applications[] = [
      'certificate_type' => $certificate_type,
      'status' => $status
    ];
  }
  $stmt2->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($full_name); ?> - User Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/User_Profile.css">
  <style>
    .notification-badge {
      background: #dc3545;
      color: #fff;
      border-radius: 50%;
      padding: 2px 7px;
      font-size: 12px;
      position: absolute;
      top: 0;
      right: 0;
    }

    .notif-link-wrap {
      position: relative;
    }
  </style>
</head>

<body>
  <!-- Dashboard Header -->
  <header class="dashboard-header">
    <div class="logo">
      <span>GINJO</span>
      <a class="home" href="../index.php">Home</a>
    </div>
    <div class="user-controls">
      <div class="notification-bell" id="notifBell" tabindex="0">
        <i class="fas fa-bell<?php echo ($notif_count > 0) ? ' notif-alert' : ''; ?>"></i>
        <?php if ($notif_count > 0): ?>
          <span class="notification-badge" id="notifBadge"><?php echo $notif_count; ?></span>
        <?php endif; ?>
        <span id="notifArea" style="display:none"></span>
      </div>
      <div class="user-profile">
        <div class="user-avatar">
          <i class="fas fa-user"></i>
        </div>
        <span><?php echo $full_name; ?></span>
        <div class="user-dropdown">
          <a href="Welcome.php"><i class="fas fa-user"></i> My Profile</a>
          <a href="#"><i class="fas fa-cog"></i> Settings</a>
          <a href="../Admin dashboard/Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>
  </header>
  <!-- Dashboard Container -->
  <div class="dashboard-container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
      <div class="sidebar-user" style="padding:0 20px 20px 20px; border-bottom:1px solid #f1f1f1; margin-bottom:10px;">
        <div style="display:flex;align-items:center;gap:12px;padding:12px 0;">
          <div style="width:48px;height:48px;border-radius:50%;background:#f0f2f5;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--gray);">
            <i class="fas fa-user"></i>
          </div>
          <div>
            <div style="font-weight:600;"><?php echo htmlspecialchars($first_name); ?></div>
            <div style="font-size:12px;color:var(--gray);"><?php echo htmlspecialchars($phone); ?></div>
          </div>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-item">
          <a href="Welcome.php" target="contentFrame" class="menu-link active">
            <i class="fas fa-tachometer-alt"></i>
            <span>Profile</span>
          </a>
        </li>
        <!--   <?php if ($has_accepted_application): ?>
          <li class="menu-item">
            <a href="../IDuserRegistration.php" target="contentFrame" class="menu-link">
              <i class="fas fa-home"></i>
              <span>Residence ID</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="birth_certificate.html" target="contentFrame" class="menu-link">
              <i class="fas fa-certificate"></i>
              <span>Birth Certificate</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="marriage_certificate.html" target="contentFrame" class="menu-link">
              <i class="fas fa-ring"></i>
              <span>Marriage Certificate</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="death_certificate.html" target="contentFrame" class="menu-link">
              <i class="fas fa-cross"></i>
              <span>Death Certificate</span>
            </a>
          </li>
        <?php endif; ?> -->
        <li class="menu-item">
          <a href="../ApplicationForm.php" target="contentFrame" class="menu-link">
            <i class="fas fa-file-alt"></i>
            <span>Applications</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="../contact.php" target="contentFrame" class="menu-link">
            <i class="fas fa-question-circle"></i>
            <span>Help & Support</span>
          </a>
        </li>
        <li class="menu-item notif-link-wrap position-relative">
          <a href="application_checker.php" class="menu-link" id="notificationsLink" target="contentFrame">
            <i class="fas fa-bell"></i>
            <span>Application Checker</span>
            <?php
            // Count accepted and rejected applications for badge
            $notif_badge_count = 0;
            foreach ($applications as $app) {
              if ($app['status'] === 'accepted' || $app['status'] === 'rejected') {
                $notif_badge_count++;
              }
            }
            ?>
            <?php if ($notif_badge_count > 0): ?>
              <span class="notification-badge" style="position:absolute;top:8px;right:10px;">
                <?php echo $notif_badge_count; ?>
              </span>
            <?php endif; ?>
          </a>
        </li>
        <li class="menu-item">
          <a href="../Admin dashboard/Logout.php" class="menu-link" target="_top">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </aside>
    <!-- Main Content Area with Iframe -->
    <main class="main-content">
      <iframe name="contentFrame" src="Welcome.php" style="width:100%;height:100%;border:none;"></iframe>
    </main>
  </div>
  <script>
    // Remove notifications when user clicks the bell or notification area (optional, can be removed)
    document.getElementById('notifBell').addEventListener('click', function() {
      const notifBadge = document.getElementById('notifBadge');
      if (notifBadge) notifBadge.remove();
    });
    // Prevent page reload for most sidebar links, load in iframe instead
    document.querySelectorAll('.sidebar-menu .menu-link').forEach(link => {
      link.addEventListener('click', function(e) {
        document.querySelectorAll('.sidebar-menu .menu-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        if (this.getAttribute('target') === 'contentFrame') {
          e.preventDefault();
          document.querySelector('iframe[name="contentFrame"]').src = this.getAttribute('href');
        }
      });
    });
    // Dropdown functionality for notifications link is removed
  </script>
</body>

</html>