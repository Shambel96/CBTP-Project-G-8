<?php


require_once("../db_connection.php");

// Handle search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$certs = [];

// 1. Marriage Certificates
$where = "";
if ($search !== '') {
    $search_esc = $conn->real_escape_string($search);
    $where = "WHERE certificate_number LIKE '%$search_esc%' OR groom_name LIKE '%$search_esc%' OR 'Marriage Certificate' LIKE '%$search_esc%'";
}
$res = $conn->query("SELECT certificate_number AS cert_no, groom_name AS full_name, 'Marriage Certificate' AS cert_type, 'marriage' AS cert_table FROM marriage_certificate $where");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $certs[] = $row;
    }
}

// 2. Death Certificates
$where = "";
if ($search !== '') {
    $search_esc = $conn->real_escape_string($search);
    $where = "WHERE certificate_number LIKE '%$search_esc%' OR full_name LIKE '%$search_esc%' OR 'Death Certificate' LIKE '%$search_esc%'";
}
$res = $conn->query("SELECT certificate_number AS cert_no, full_name, 'Death Certificate' AS cert_type, 'death' AS cert_table FROM death_certificate $where");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $certs[] = $row;
    }
}

// 3. Birth Certificates
$where = "";
if ($search !== '') {
    $search_esc = $conn->real_escape_string($search);
    $where = "WHERE cert_number LIKE '%$search_esc%' OR child_name LIKE '%$search_esc%' OR 'Birth Certificate' LIKE '%$search_esc%'";
}
$res = $conn->query("SELECT cert_number AS cert_no, child_name AS full_name, 'Birth Certificate' AS cert_type, 'birth' AS cert_table FROM birth_certificates $where");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $certs[] = $row;
    }
}

// 4. Residence IDs (from id_registers, merge fname and mname)
$where = "";
if ($search !== '') {
    $search_esc = $conn->real_escape_string($search);
    $where = "WHERE id LIKE '%$search_esc%' OR id LIKE '%$search_esc%' OR fname LIKE '%$search_esc%' OR mname LIKE '%$search_esc%' OR CONCAT(fname, ' ', mname) LIKE '%$search_esc%' OR 'Residence ID' LIKE '%$search_esc%'";
}
$res = $conn->query("SELECT id AS cert_no, CONCAT(fname, ' ', mname) AS full_name, 'Residence ID' AS cert_type, 'id' AS cert_table FROM id_registers $where");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $certs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certified Certificates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cert-card {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.13);
            border-radius: 12px;
            padding: 24px 18px;
            margin-bottom: 24px;
            background: #fff;
            transition: box-shadow 0.2s;
        }

        .cert-card:hover {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        }

        .cert-type {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 8px;
        }

        .cert-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #222;
        }

        .cert-no {
            font-size: 0.95rem;
            color: #888;
            margin-top: 6px;
        }

        .search-bar {
            max-width: 400px;
            margin: 0 auto 32px auto;
        }

        .cert-actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Certified Certificates & IDs</h2>
        <form class="search-bar mb-4" method="get" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by name, certificate type, or number..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <div class="row">
            <?php foreach ($certs as $cert): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="cert-card">
                        <div class="cert-type"><?php echo htmlspecialchars($cert['cert_type']); ?></div>
                        <div class="cert-name"><?php echo htmlspecialchars($cert['full_name']); ?></div>
                        <div class="cert-no">Certificate/ID No: <?php echo htmlspecialchars($cert['cert_no']); ?></div>
                        <div class="cert-actions">
                            <?php
                            // Determine the view URL based on type
                            $viewUrl = "#";
                            $printUrl = "#";
                            if ($cert['cert_table'] === 'marriage') {
                                $viewUrl = "../Certificates/marriage/Marriage.php?cert=" . urlencode($cert['cert_no']);
                                $printUrl = $viewUrl . "&print=1";
                            } elseif ($cert['cert_table'] === 'death') {
                                $viewUrl = "../Certificates/death certificate sample/death_certificate.php?cert=" . urlencode($cert['cert_no']);
                                $printUrl = $viewUrl . "&print=1";
                            } elseif ($cert['cert_table'] === 'birth') {
                                $viewUrl = "../Certificates/Birth_Certificate.php?cert=" . urlencode($cert['cert_no']);
                                $printUrl = $viewUrl . "&print=1";
                            } elseif ($cert['cert_table'] === 'id') {
                                $viewUrl = "../IDpage.php?id=" . urlencode($cert['cert_no']);
                                $printUrl = $viewUrl; // For ID, keep as is
                            }
                            ?>
                            <a href="<?php echo $viewUrl; ?>" class="btn btn-outline-primary btn-sm" target="_blank">View</a>
                            <?php if ($cert['cert_table'] === 'id'): ?>
                                <a href="<?php echo $printUrl; ?>" class="btn btn-outline-success btn-sm" target="_blank">Generate</a>
                            <?php else: ?>
                                <a href="<?php echo $printUrl; ?>" class="btn btn-outline-success btn-sm" target="_blank">Print</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($certs)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">No certificates or IDs found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>