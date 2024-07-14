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
                                <i class="fa fa-plus"></i>Insert User
                            </h1>
                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="appFormInput" id="first_name" name="first_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="appFormInput" id="last_name" name="last_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="appFormInput" name="email">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="appFormInput" name="password">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="user_role"> Role</label>
                                        <select id="user_role" name="role" class="appFormInput">
                                            <option value="1">Admin</option>
                                            <option value="0">User</option>
                                            <option value="2">Sales</option>
                                            <option value="3">Purchase</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i>Add User</button>
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