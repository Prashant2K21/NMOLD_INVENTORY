<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

include 'Invoice.php';
$invoice = new Invoice();
// $invoice->checkLoggedIn();
if (!empty($_POST['companyName']) && $_POST['companyName']) {
    $invoice->saveInvoice($_POST);
    header("Location:invoice_list.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice - Inventory Management System</title>


    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/8c7a3095b5.js"></script>


</head>

<body>
    <div id="dashboardMainContainer">
        <?php include 'partials/app-sidebar.php'; ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include 'partials/app-topnav.php'; ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="container content-invoice">
                            <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
                                <div class="load-animate animated fadeInUp">
                                    <div class="row">
                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                            <h2 class="title">PHP Invoice System</h2>

                                        </div>
                                    </div>
                                    <input id="currency" type="hidden" value="$">
                                    <div class="row">
                                        <!-- <div> -->
                                            <h2 class="title">Invoice System</h2>

                                            <table id="data-table" class="table table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice No.</th>
                                                        <th>Create Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Invoice Total</th>
                                                        <th>Print</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $invoiceList = $invoice->getInvoiceList();
                                                foreach ($invoiceList as $invoiceDetails) {
                                                    $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
                                                    echo '
              <tr>
                <td>' . $invoiceDetails["order_id"] . '</td>
                <td>' . $invoiceDate . '</td>
                <td>' . $invoiceDetails["order_receiver_name"] . '</td>
                <td>' . $invoiceDetails["order_total_after_tax"] . '</td>
                <td><a href="print_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '" title="Print Invoice"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id=' . $invoiceDetails["order_id"] . '"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="' . $invoiceDetails["order_id"] . '" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
                                                }
                                                ?>
                                            </table>
                                        <!-- </div> -->

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <?php include('partials/app-script.php'); ?>
                <script src="js/invoice.js"></script>
</body>


</html>