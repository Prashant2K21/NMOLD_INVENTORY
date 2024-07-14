<?php
//start the session
session_start();
if (!isset($_SESSION['user']))  header('location: login.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/8c7a3095b5.js"></script>
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include 'partials/app-sidebar.php';
        ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include ('partials/app-topnav.php') ?>
            
                <div id="reportsContainer">
                    <div class="reportTypeContainer">
                    <div class="reportType">
                        <p>Export Products</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                            <a href="database/report_pdf.php?report=product" target="_blank" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Suppliers</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
                            <a href="database/report_pdf.php?report=supplier" target="_blank" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    </div>
                    <div id="reportsContainer">
                    <div class="reportTypeContainer">
                    <div class="reportType">
                        <p>Export Deliveries</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=delivery" class="reportExportBtn">Excel</a>
                            <a href="database/report_pdf.php?report=delivery" target="_blank" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Purchase orders</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=purchase_orders" class="reportExportBtn">Excel</a>
                            <a href="database/report_pdf.php?report=purchase_orders" target="_blank" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/script.js"></script>
</body>
</html>