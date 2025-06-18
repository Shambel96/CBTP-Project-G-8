<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id'])) {
    header("Location: ../signin.php");
    exit();
}
include("../db_connection.php");



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
if ($role !== 'staff') {
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
// Count unread contact messages (do NOT mark as read here)
$unread_result = $conn->query("SELECT COUNT(*) AS unread_count FROM contact_messages WHERE is_read = 0");
$unread_count = 0;
if ($unread_result && $row = $unread_result->fetch_assoc()) {
    $unread_count = $row['unread_count'];
}

// Fetch the number of pending requests
$query = "SELECT COUNT(*) AS pending_count FROM applications WHERE status = 'Pending'";
$result = $conn->query($query);
$pending_count = 0;
if ($result && $row = $result->fetch_assoc()) {
    $pending_count = $row['pending_count'];
}
$first_name = htmlspecialchars($_SESSION['first_name'] ?? 'User');
$last_name = htmlspecialchars($_SESSION['last_name'] ?? '');
$user_name = trim("$first_name $last_name");
// Default values

$profile_image = "avatar.png"; // Default avatar fallback

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT first_name, last_name, profile_image FROM users WHERE id = $user_id LIMIT 1";
    $user_result = $conn->query($user_query);
    if ($user_result && $user_row = $user_result->fetch_assoc()) {
        $user_name = $user_row['first_name'] . " " . $user_row['last_name'];
        if (!empty($user_row['profile_image'])) {
            $profile_image = $user_row['profile_image'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ginjo Staff Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .sidebar {
            background-color: black;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: orange;
            color: white;
        }

        .content {
            margin-left: 250px;
            margin-top: 60px;
        }

        iframe {
            width: 100%;
            height: 80vh;
            border: none;
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

        .profile-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-box img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .profile-box span {
            font-size: 14px;
            color: #fff;
            white-space: nowrap;
        }

        .btn-color {
            color: #fff;
            text-decoration: none;
        }

        .btn-color:hover {
            background-color: orange;
        }

        .sidebar-link.active,
        .sidebar-link.active:focus,
        .sidebar-link.active:hover {
            background-color: orange !important;
            color: #fff !important;
            border-radius: 6px;
        }

        .sidebar-link i {
            margin-right: 8px;
            font-size: 1.2em;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar Section -->
        <div class="sidebar d-flex flex-column p-3" id="staffSidebar">
            <h2 class="text-center">Ginjo</h2>
            <a href="../userProfile/Welcome.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <a href="../Admin dashboard/manage_request.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-envelope-paper"></i> Manage Requests
                <?php if ($pending_count > 0): ?>
                    <span class="notification-icon"><?php echo $pending_count; ?></span>
                <?php endif; ?>
            </a>
            <a href="../Admin dashboard/manag_residents.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-people-fill"></i> Manage Residents
            </a>
            <a href="../Admin dashboard/Search_Residents.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-search"></i> Search Residents
            </a>
            <a href="../Admin dashboard/Applications.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-file-earmark-text"></i> Applications
            </a>
            <a href="verify_cert.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-patch-check"></i> Verify Certificates
            </a>
            <!--    <a href="generate_reports.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-bar-chart-line-fill"></i> Generate Reports
            </a> -->
            <a href="Search_ID.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-gear"></i> Search_Residents ID
            </a>
            <a href="contact_messages.php" target="contentFrame" class="btn btn-link text-start sidebar-link">
                <i class="bi bi-envelope-at"></i> Contact Messages
                <?php if ($unread_count > 0): ?>
                    <span class="notification-icon"><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a>

            <!-- Logout Link (Triggers Modal) -->
            <button type="button" class="btn btn-link text-start btn-color sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>

        <!-- Header Section -->
        <div class="w-100">
            <div class="bg-primary text-white p-3 fixed-top d-flex justify-content-between align-items-center" style="margin-left: 250px;">
                <h1 class="h4 mb-0">Welcome to Staff Dashboard</h1>
                <div class="profile-box me-3">
                    <img src="../uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile">
                    <span><?php echo htmlspecialchars($user_name); ?></span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content p-3">
                <iframe name="contentFrame" src="Welcome.php"></iframe>
            </div>
        </div>
    </div>
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout? Your session will be closed and you'll be redirected to the home page.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Yes, Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Highlight active sidebar link based on iframe navigation
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const iframe = document.querySelector('iframe[name="contentFrame"]');

            // Set active link by href
            function setActiveSidebar(href) {
                sidebarLinks.forEach(link => {
                    link.classList.remove('active');
                    // Compare only the file name part for matching
                    if (link.getAttribute('href')) {
                        const linkHref = link.getAttribute('href').split('/').pop().toLowerCase();
                        const targetHref = href.split('/').pop().toLowerCase();
                        if (linkHref === targetHref) {
                            link.classList.add('active');
                        }
                    }
                });
            }

            // On sidebar link click
            sidebarLinks.forEach(link => {
                if (link.tagName === 'A' && link.getAttribute('href')) {
                    link.addEventListener('click', function(e) {
                        setActiveSidebar(this.getAttribute('href'));
                    });
                }
            });

            // Initial active (default src)
            setActiveSidebar('Welcome.php');

            // On iframe load, update active link
            if (iframe) {
                iframe.addEventListener('load', function() {
                    try {
                        const path = iframe.contentWindow.location.pathname;
                        const page = path.substring(path.lastIndexOf('/') + 1);
                        setActiveSidebar(page);
                    } catch (err) {
                        // Cross-origin, fallback: do nothing
                    }
                });
            }
        });
    </script>
</body>

</html>