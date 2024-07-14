<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$show_table = 'users';
$users = include('database/show.php');
$_SESSION['table'] = 'suppliers';
$_SESSION['redirect_to'] = 'supplier-add.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SUPPLIER - Inventory Management System</title>
    <?php include('partials/app-header-script.php');?>
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include 'partials/app-sidebar.php'; ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include 'partials/app-topnav.php'; ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header">
                                <i class="fa fa-plus"></i>Create Supplier
                            </h1>
                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                                    <div class="appFormInputContainer">
                                        <label for="supplier_name">Supplier Name</label>
                                        <input type="text" class="appFormInput" id="supplier_name" placeholder="Enter supplier name..." name="supplier_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="supplier_contact">Contact</label>
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_contact" placeholder="Enter supplier contact..." name="supplier_contact">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="supplier_gstin">GSTIN No.</label>
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_gstin" placeholder="Enter supplier gstin..." name="supplier_gstin">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="supplier_bankdetails ">Bank Details</label>
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_account_name" placeholder="Enter supplier Account Name" name="supplier_account_name">
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_account_number" placeholder="Enter supplier Account Number" name="supplier_account_number">
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_ifsc" placeholder="Enter supplier Account Ifsc Code" name="supplier_ifsc">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="supplier_location">Location</label>
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_location" placeholder="Enter supplier location..." name="supplier_location">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="appFormInput productTextAreaInput" id="email" placeholder="Enter email..." name="email">
                                    </div>
                                    
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i>Create Supplier</button>
                                </form>
                                <?php if (isset($_SESSION['response'])) { ?>
                                    <div class="responseMessage">
                                        <p class="<?= $_SESSION['response']['success'] ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                            <?= $_SESSION['response']['message'] ?>
                                        </p>
                                    </div>
                                <?php unset($_SESSION['response']);
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-script.php');?>
</body>
</html>