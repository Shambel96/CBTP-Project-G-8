<?php
require_once("db_connection.php");

// Get the ID from the URL (e.g., IDpage.php?id=123)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
  $stmt = $conn->prepare("SELECT * FROM id_registers WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result ? $result->fetch_assoc() : null;
  $stmt->close();
} else {
  $user = null;
}
$conn->close();

// Calculate age from dob
$age = '';
if (!empty($user['dob'])) {
  $dob = new DateTime($user['dob']);
  $now = new DateTime();
  $age = $now->diff($dob)->y;
}

// Set issue date to today (year-month-day)
$issue_date = date('Y-m-d');

// Set expiry date to 6 years after issue date
$expiry_date = date('Y-m-d', strtotime($issue_date . ' +6 years'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Css/idDesign.css" />
  <title>Your ID</title>
  <style>
    .BR-code {
      width: 10%;
    }

    .image-container img {
      width: 110px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid #e2e8f0;
      display: block;
    }

    .image-container {
      width: 110px;
      height: 100px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .chapa {
      width: 20%;
    }

    .print-btn {
      display: block;
      margin: 30px auto 10px auto;
      padding: 8px 24px;
      font-size: 16px;
      background: #198754;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s;
    }

    .print-btn:hover {
      background: #145c32;
    }

    @media print {
      .print-btn {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <?php if ($user): ?>
    <button class="print-btn" onclick="window.print()">
      Print / Generate PDF
    </button>
    <section class="front-ID-container">
      <div class="logo-container-flags">
        <div class="ethiopiaFlag flag">
          <img src="images/Flag_of_Ethiopia.svg" alt="Ethiopia Flag" />
        </div>
        <div class="ginjo-info">
          <h1>Ginjo residence Identification Card</h1>
        </div>
        <div class="OromiaFlag flag">
          <img src="images/Flag_of_the_Oromia_Region.svg.png" alt="Oromia Flag" />
        </div>
      </div>
      <div class="flex-for-image-and-info">
        <div class="image-container">
          <img src="<?php echo htmlspecialchars($user['photo'] ?? 'images/default.png'); ?>" alt="User Image" />
        </div>
        <div class="information">
          <table>
            <tr>
              <td class="bold">Full Name:</td>
              <td>
                <?php
                echo htmlspecialchars(
                  ($user['fname'] ?? '') . ' ' .
                    ($user['mname'] ?? '') . ' ' .
                    ($user['lname'] ?? '')
                );
                ?>
              </td>
            </tr>
            <tr>
              <td class="bold">Nationality:</td>
              <td>Ethiopian</td>
            </tr>
            <tr>
              <td class="bold">Gender:</td>
              <td><?php echo htmlspecialchars($user['gender'] ?? ''); ?></td>
            </tr>
            <tr>
              <td class="bold">Address:</td>
              <td>Jimma, Oromia, Ethiopia</td>
            </tr>
            <tr>
              <td class="bold">Kebele:</td>
              <td>Ginjo</td>
            </tr>
            <tr>
              <td class="bold">Date of Birth:</td>
              <td><?php echo htmlspecialchars($user['dob'] ?? ''); ?></td>
            </tr>
            <tr>
              <div class="BR-code" style="text-align:center; margin-top:10px;">
                <img src="https://barcode.tec-it.com/barcode.ashx?data=<?php echo urlencode($user['id'] ?? ''); ?>&code=Code128&translate-esc=false" alt="Barcode" />
              </div>
            </tr>
          </table>
        </div>
      </div>
    </section>
    <section class="back-ID-container">
      <div class="watermark">
        <h1>Ginjo</h1>
      </div>
      <div class="back-header">
        <h1>GINjo town administrative</h1>
      </div>
      <div class="back-image-container">
        <img src="<?php echo htmlspecialchars($user['photo'] ?? 'images/default.png'); ?>" alt="back id image passport size" />
      </div>
      <div class="information-container-div">
        <div class="information-container">
          <table>
            <tr>
              <td class="bold">Mother's Name:</td>
              <td><?php echo htmlspecialchars($user['mother_name'] ?? ''); ?></td>
            </tr>
            <tr>
              <td class="bold">Age:</td>
              <td><?php echo $age; ?></td>
            </tr>
            <tr>
              <td class="bold">Occupation:</td>
              <td><?php echo htmlspecialchars($user['occupation'] ?? ''); ?></td>
            </tr>
            <tr>
              <td class="bold">Marital Status:</td>
              <td><?php echo htmlspecialchars($user['status'] ?? ''); ?></td>
          </table>
        </div>
        <div class="information-container">
          <table>
            <tr>
              <td class="bold">Issue Date:</td>
              <td><?php echo $issue_date; ?></td>
            </tr>
            <tr>
              <td class="bold">Expiry Date:</td>
              <td><?php echo $expiry_date; ?></td>
            </tr>
            <tr>
              <td class="bold">House Number:</td>
              <td><?php echo htmlspecialchars($user['h_number'] ?? ''); ?></td>
            </tr>
            <tr>
              <td class="bold">Emergency:</td>
              <td><?php echo htmlspecialchars($user['emergency_num'] ?? ''); ?></td>
            </tr>
          </table>
        </div>
      </div>
      <p class="note">Only valid for 6 years!</p>
    </section>
  <?php else: ?>
    <div class="container mt-5">
      <div class="alert alert-danger text-center">No record found for this ID.</div>
    </div>
  <?php endif; ?>
</body>

</html>