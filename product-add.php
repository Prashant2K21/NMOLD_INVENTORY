<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$show_table = 'users';
$users = include('database/show.php');
$_SESSION['table'] = 'products';
$_SESSION['redirect_to'] = 'product-add.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Inventory Management System</title>
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
                                <i class="fa fa-plus"></i>Create Product
                            </h1>
                              <div id="userAddFormContainer">
                               <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                                <div class="appFormInputContainer">
                                <label for="product_name">Product Name</label>
                                        <input type="text" class="appFormInput" id="product_name" placeholder="Enter product name..." name="product_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="desciption">Description</label>
                                        <textarea class="appFormInput productTextAreaInput" id="description" placeholder="Enter product desciption..." name="description"></textarea>
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="desciption">Suppliers</label>
                                        <select name="suppliers[]" id="suppliersSelect" multiple="">
                                            <option value="">Select Supplier</option>
                                            <?php
                                            $show_table = 'suppliers';
                                            $suppliers = include('database/show.php');
                                            foreach($suppliers as $supplier){
                                                echo "<option value='".$supplier['id']."'>".$supplier['supplier_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="product_name">Product Image</label>
                                        <input type="file" name="img" />
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i>Create Product</button>
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