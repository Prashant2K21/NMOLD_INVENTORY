<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];

$show_table = 'users';
$users = include('database/show.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users - Inventory Management System</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i>List of User</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $i => $user) {
                                            ?>
                                                <tr>
                                                    <td><?= $i + 1  ?></td>
                                                    <td class="firstName"><?= $user['first_name'] ?></td>
                                                    <td class="lastName"><?= $user['last_name'] ?></td>
                                                    <td class="email"><?= $user['email'] ?></td>
                                                    <td class="role"><?php $role=$user['role'];
                                                    switch ($role) {
                                                        case 0:
                                                            $role = 'User';
                                                            break;
                                                        case 1:
                                                            $role = 'Admin';
                                                            break;
                                                        case 2:
                                                            $role = 'Sales';
                                                            break;
                                                        case 3:
                                                            $role = 'Purchase';
                                                            break;
                                                        // Add more cases as needed
                                                        default:
                                                        $role = 'Unknown Role';
                                                    } 
                                                    echo($role);?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                    <td><a href="" class="updateuser" onclick="updateUser(this)" data-userid="<?= $user['id'] ?>"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="" class="deleteUser" onclick="deleteUser(this)" data-userId="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($users) ?> Users</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-script.php');?>
    <script>
        function updateUser(node) {
            event.preventDefault();
            let firstName = node.closest('tr').querySelector('td.firstName').innerHTML;
            let lastName = node.closest('tr').querySelector('td.lastName').innerHTML;
            let email = node.closest('tr').querySelector('td.email').innerHTML;
            let role = node.closest('tr').querySelector('td.role').innerHTML;
            let userId = node.dataset.userid;
            BootstrapDialog.confirm({
                title: 'update ' + firstName + ' ' + lastName,
                message: '<form>\
                        <div class="form-group">\
                            <label for="firstName">First Name:</label>\
                            <input type="text" class="form-control" id="firstName" value="' + firstName + '">\
                        </div>\
                        <div class="form-group">\
                            <label for="lastName">Last Name:</label>\
                            <input type="text" class="form-control" id="lastName" value="' + lastName + '">\
                        </div>\
                        <div class="form-group">\
                            <label for="email">Email:</label>\
                            <input type="email" class="form-control" id="emailupdate" value="' + email + '">\
                        </div>\
                        <div class="form-group">\
                        <label for="role">Role:</label>\
                        <select class="form-control" id="roleUpdate">\
                            <option value="User" ' + (role === 'User' ? 'selected' : '') + '>User</option>\
                            <option value="Admin" ' + (role === 'Admin' ? 'selected' : '') + '>Admin</option>\
                            <option value="Sales" ' + (role === 'Sales' ? 'selected' : '') + '>Sales</option>\
                            <option value="Purchase" ' + (role === 'Purchase' ? 'selected' : '') + '>Purchase</option>\
                        </select>\
                    </div>\
                    </form>',
                callback: function(isUpdate) {
                    if (isUpdate) {
                        $.ajax({
                            method: 'POST',
                            data: {
                                userId: userId,
                                f_name: document.getElementById('firstName').value,
                                l_name: document.getElementById('lastName').value,
                                email: document.getElementById('emailupdate').value,
                                role: document.getElementById('roleUpdate').value,
                            },
                            url: 'database/update-users.php',
                            dataType: 'text',
                            success: function(data) {
                                var data = $.parseJSON(data);
                                if (data.success) {
                                    BootstrapDialog.alert({
                                        type: BootstrapDialog.TYPE_SUCCESS,
                                        message: data.message,
                                        callback: function() {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    BootstrapDialog.alert({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        message: data.message,
                                        callback: function() {
                                            location.reload();
                                        }
                                        
                                    });
                                }
                            }
                        });
                        
                    }
                }
            });
        }

        function deleteUser(node) {
            event.preventDefault();
            let userId = node.getAttribute('data-userid');
            let fname = node.getAttribute('data-fname');
            let lname = node.getAttribute('data-lname');
            let fullName = fname + " " + lname;
            BootstrapDialog.confirm({
                type: BootstrapDialog.TYPE_DANGER,
                message: `Are you sure to delete ${fullName} ?`,
                callback: function(isDelete) {
                    if (isDelete) {
                        $.ajax({
                            method: 'POST',
                            data: {
                                user_id: userId,
                                f_name: fname,
                                l_name: lname
                            },
                            url: 'database/delete-users.php',
                            dataType: 'json',
                            success: function(data) {
                                if (data.success) {
                                    BootstrapDialog.alert({
                                        type: BootstrapDialog.TYPE_SUCCESS,
                                        message: data.message,
                                        callback: function() {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    BootstrapDialog.alert({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        message: data.message,
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    </script>
</body>

</html>