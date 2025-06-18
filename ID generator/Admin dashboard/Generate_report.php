<?php


// Place this PHP block at the very top of your file
require_once("../db_connection.php");

// Get date range from AJAX or default to all time
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

// Build WHERE clause for date filtering
$where = "";
$params = [];
$types = "";

if ($startDate && $endDate) {
    $where = "WHERE DATE(submitted_at) BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
    $types = "ss";
}

// Total Residence IDs Issued
$sql1 = "SELECT COUNT(*) AS total_ids FROM id_registers";
$totalIDs = $conn->query($sql1)->fetch_assoc()['total_ids'] ?? 0;

// Total Certificates Issued
$sql2 = "SELECT COUNT(*) AS total_certificates FROM marriage_certificate";
$totalCertificates = $conn->query($sql2)->fetch_assoc()['total_certificates'] ?? 0;

// Pending Applications
$sql3 = "SELECT COUNT(*) AS pending FROM applications " . ($where ? $where . " AND " : "WHERE ") . "status = 'Pending'";
$stmt3 = $conn->prepare($sql3);
if ($where) $stmt3->bind_param($types, ...$params);
$stmt3->execute();
$pendingApplications = $stmt3->get_result()->fetch_assoc()['pending'] ?? 0;
$stmt3->close();

// Rejected Applications
$sql4 = "SELECT COUNT(*) AS rejected FROM applications " . ($where ? $where . " AND " : "WHERE ") . "status = 'Rejected'";
$stmt4 = $conn->prepare($sql4);
if ($where) $stmt4->bind_param($types, ...$params);
$stmt4->execute();
$rejectedApplications = $stmt4->get_result()->fetch_assoc()['rejected'] ?? 0;
$stmt4->close();

// For chart: Applications per status
$chartData = [];
$sqlChart = "SELECT status, COUNT(*) as count FROM applications " . ($where ? $where : "") . " GROUP BY status";
$stmtChart = $conn->prepare($sqlChart);
if ($where) $stmtChart->bind_param($types, ...$params);
$stmtChart->execute();
$resultChart = $stmtChart->get_result();
while ($row = $resultChart->fetch_assoc()) {
    $chartData[$row['status']] = (int)$row['count'];
}
$stmtChart->close();

if (isset($_GET['ajax'])) {
    // AJAX response for JS fetch
    echo json_encode([
        'totalIDs' => $totalIDs,
        'totalCertificates' => $totalCertificates,
        'pendingApplications' => $pendingApplications,
        'rejectedApplications' => $rejectedApplications,
        'chartData' => $chartData
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residence ID and Certificate Management Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .metrics {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .metric {
            flex: 1;
            text-align: center;
            padding: 15px;
            background-color: #e2e2e2;
            border-radius: 5px;
            margin: 0 10px;
        }

        .filters {
            margin-bottom: 20px;
        }

        .chart {
            margin: 20px 0;
            height: 300px;
            background-color: #e0e0e0;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>

<body>
    <h1>Residence ID and Certificate Management Report</h1>
    <div class="container">
        <div class="metrics">
            <div class="metric">
                <h2>Total Residence IDs Issued</h2>
                <p id="totalIDs"><?php echo $totalIDs; ?></p>
            </div>
            <div class="metric">
                <h2>Total Certificates Issued</h2>
                <p id="totalCertificates"><?php echo $totalCertificates; ?></p>
            </div>
            <div class="metric">
                <h2>Pending Applications</h2>
                <p id="pendingApplications"><?php echo $pendingApplications; ?></p>
            </div>
            <div class="metric">
                <h2>Rejected Applications</h2>
                <p id="rejectedApplications"><?php echo $rejectedApplications; ?></p>
            </div>
        </div>
        <div class="filters">
            <label for="dateRange">Select Date Range:</label>
            <input type="date" id="startDate" />
            <input type="date" id="endDate" />
            <button onclick="generateReport()">Generate Report</button>
        </div>
        <div class="chart" id="chart">
            <canvas id="statusChart" width="400" height="300"></canvas>
        </div>
        <button onclick="exportReport()">Export Report</button>
    </div>
    <script>
        let chartInstance = null;

        function generateReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            fetch(`Generate_report.php?ajax=1&startDate=${startDate}&endDate=${endDate}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('totalIDs').innerText = data.totalIDs;
                    document.getElementById('totalCertificates').innerText = data.totalCertificates;
                    document.getElementById('pendingApplications').innerText = data.pendingApplications;
                    document.getElementById('rejectedApplications').innerText = data.rejectedApplications;
                    updateChart(data.chartData);
                });
        }

        function updateChart(chartData) {
            const ctx = document.getElementById('statusChart').getContext('2d');
            const labels = Object.keys(chartData);
            const values = Object.values(chartData);
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Applications by Status',
                        data: values,
                        backgroundColor: ['#5cb85c', '#f0ad4e', '#d9534f', '#5bc0de', '#6f42c1']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
        // Initial chart render
        document.addEventListener('DOMContentLoaded', function() {
            updateChart(<?php echo json_encode($chartData); ?>);
        });

        function exportReport() {
            const totalIDs = document.getElementById('totalIDs').innerText;
            const totalCertificates = document.getElementById('totalCertificates').innerText;
            const pendingApplications = document.getElementById('pendingApplications').innerText;
            const rejectedApplications = document.getElementById('rejectedApplications').innerText;
            const csvContent = `data:text/csv;charset=utf-8,` +
                `Total Residence IDs Issued,Total Certificates Issued,Pending Applications,Rejected Applications\n` +
                `${totalIDs},${totalCertificates},${pendingApplications},${rejectedApplications}`;
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "residence_id_report.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>

</html>