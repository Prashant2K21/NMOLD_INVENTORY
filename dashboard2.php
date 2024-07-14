<?php
//start the session
session_start();
if (!isset($_SESSION['user']))  header('location: login.php');


$user = $_SESSION['user'];
//get graph data - purchase order by status
include('database/po_status_pie_graph.php');
//get graph data - supplier product count
include('database/supplier_product_bar_graph.php');
//get line graph data - delivery history per day
include('database/delivery_history.php');
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
            <?php include 'partials/app-topnav.php';
            ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">

                    <div class="col50">
                        <figure class="highcharts-figure">
                            <div id="containerBarChart"></div>
                            <p class="highcharts-description">
                                Here is the breakdown of the purchase orders by status.
                            </p>
                        </figure>
                    </div>
                </div>

            </div>
        </div>
        <script src="js/script.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            //var graphData = <?= json_encode($results) ?>;



            var barGraphData = <?= json_encode($bar_chart_data) ?>;
            var barGraphCategories = <?= json_encode($categories) ?>;


            Highcharts.chart('containerBarChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Product Count Assigned To Supplier'
                },

                xAxis: {
                    categories: barGraphCategories,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Product Count'
                    }
                },
                tooltip: {

                    pointFormatter: function() {
                        var point = this,
                            series = point.series;

                        return '<b>${point.category}</b>:${point.y}'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Suppliers',
                    data: barGraphData
                }]
            });
        </script>

</body>

</html>