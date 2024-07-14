<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

$show_table = 'users';
$users = include('database/show.php');
$_SESSION['table'] = 'users';
$_SESSION['redirect_to'] = 'user-add.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Inventory Management System</title>
    <?php include('partials/app-header-script.php'); ?>
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
                                <i class="fa fa-plus"></i>Insert Project
                            </h1>
                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="project_name">PROJECT NAME</label>
                                        <input type="text" class="appFormInput" id="project_name" name="project_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="description">DESCRIPTION</label>
                                        <input type="text" class="appFormInput" id="description" name="description">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="project_status"> Status</label>
                                        <select id="project_status" name="status" class="appFormInput">
                                            <option value="pending">Pending</option>
                                            <option value="complete">Complete</option>
                                            <!-- <option value="2">Sales</option> -->
                                            <!-- <option value="3">Purchase</option> -->
                                        </select>
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i>Add Project</button>
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
    <?php include('partials/app-script.php'); ?>
</body>

</html>