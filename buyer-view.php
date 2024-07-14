<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$show_table = 'buyers';

$buyers = include('database/show.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View buyers - Inventory Management System</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i>List of buyers</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>buyer Name</th>
                                                <th>buyer Contact</th>
                                                <th>buyer GSTIN</th>
                                                <th>buyer Location</th>
                                                <th>Email</th>
                                                <th>Products</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($buyers as $index => $buyer) {
                                            ?>
                                                <tr>
                                                    <td><?= $index + 1  ?></td>
                                                    <td>
                                                        <?= $buyer['buyer_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $buyer['buyer_contact'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $buyer['buyer_gstin'] ?>
                                                    </td>
                                                    <td><?= $buyer['buyer_location'] ?></td>
                                                    <td><?= $buyer['email'] ?></td>
                                                    <td>
                                                        <?php
                                                        $product_list = '-';
                                                        $sid = $buyer['id'];
                                                        $stmt = $conn->prepare("
                                                        SELECT product_name 
                                                        FROM products, productsuppliers 
                                                        WHERE productsuppliers.supplier = $sid
                                                        AND
                                                        productsuppliers.product = products.id
                                                        ");
                                                        $stmt->execute();
                                                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        if ($row) {
                                                            $product_arr = array_column($row, 'product_name');
                                                            $product_list = '<li>' . implode("</li><li>", $product_arr);
                                                        }
                                                        echo $product_list;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $uid = $buyer['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id = $uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        $created_by_name = $row['first_name'] . '' . $row['last_name'];
                                                        echo  $created_by_name;


                                                        ?>

                                                    </td>

                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($buyer['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($buyer['updated_at'])) ?></td>
                                                    <td><a href="" class="updatebuyer" data-sid="<?= $buyer['id'] ?>"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="" class="deletebuyer" data-name="<?= $buyer['buyer_name'] ?>" data-sid="<?= $buyer['id'] ?>"><i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($buyers) ?>buyers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('partials/app-script.php');
    $show_table = 'products';
    $products = include('database/show.php');
    $product_arr = [];
    foreach ($products as $product) {
        $product_arr[$product['id']] = $product['product_name'];
    }
    $product_arr = json_encode($product_arr);
    ?>

    <script>
        var productList = <?= $product_arr ?>;

        function Script() {
            var vm = this;

            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                    var targetElement = e.target;
                    var classList = targetElement.classList;

                    if (classList.contains('deletebuyer')) {
                        e.preventDefault();
                        var sId = targetElement.dataset.sid;
                        var buyerName = targetElement.dataset.name;
                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete buyer',
                            message: `Are you sure to delete <strong>${buyerName}</strong>?`,
                            callback: function(isDelete) {
                                if (isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            id: sId,
                                            table: 'buyers'
                                        },
                                        url: 'database/delete.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            var message = data.success ?
                                                buyerName + ' successfully deleted' : 'Error Processing your request!';

                                            BootstrapDialog.alert({
                                                type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                message: message,
                                                callback: function() {
                                                    if (data.success) location.reload();
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }

                    if (classList.contains('updatebuyer')) {
                        e.preventDefault();
                        var sId = targetElement.dataset.sid;
                        vm.showEditDialog(sId);
                    }
                });
            };

            document.addEventListener('submit', function(e) {
                e.preventDefault();
                var targetElement = e.target;

                if (targetElement.id === 'editbuyerForm') {
                    vm.saveUpdateData(targetElement);
                }
            });

            this.saveUpdateData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: {
                        buyer_name: document.getElementById('buyer_name').value,
                        buyer_contact: document.getElementById('buyer_contact').value,
                        buyer_gstin: document.getElementById('buyer_gstin').value,
                        buyer_location: document.getElementById('buyer_location').value,
                        email: document.getElementById('email').value,
                        products: $('#products').val(),
                        sid: document.getElementById('sid').value
                    },
                    url: 'database/update-buyer.php',
                    dataType: 'json',
                    success: function(data) {
                        BootstrapDialog.alert({
                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                            callback: function() {
                                if (data.success) location.reload();
                            }
                        });
                    }
                });
            };

            this.showEditDialog = function(id) {
                $.get('database/get-buyer.php', {
                    'id': id
                }, function(buyerDetails) {
                    let curProducts = buyerDetails['products'];
                    let productOptions = '';

                    for (const [pId, pName] of Object.entries(productList)) {
                        selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                        productOptions += "<option " + selected + " value='" + pId + "'>" + pName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'update <strong>' + buyerDetails.buyer_name + '</strong>',
                        message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editbuyerForm">\
                    <div class="appFormInputContainer">\
                                        <label for="buyer_name">buyer Name</label>\
                                        <input type="text" class="appFormInput" id="buyer_name" value="' + buyerDetails.buyer_name + '" placeholder="Enter buyer name..." name="buyer_name">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="buyer_contact">buyer Contact</label>\
                                        <input type="text" class="appFormInput" id="buyer_contact" value="' + buyerDetails.buyer_contact + '" placeholder="Enter buyer contact..." name="buyer_contact">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="buyer_gstin">buyer GSTIN</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="buyer_gstin" value="' + buyerDetails.buyer_gstin + '" placeholder="Enter buyer GSTIN..." name="buyer_gstin">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="buyer_location">buyer Location</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="buyer_location" value="' + buyerDetails.buyer_location + '" placeholder="Enter buyer location..." name="buyer_location">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="email">Email</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="email" value="' + buyerDetails.email + '" placeholder="Enter email..." name="email">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="desciption">Products</label>\
                                        <select name="products[]" id="products" multiple="">\
                                            <option value="">Select Products</option>\
                                           ' + productOptions + '\
                                        </select>\
                                    <div>\
                              <input type="hidden" name="sid" id="sid" value="' + buyerDetails.id + '"/>\
                                <input type="submit" value="submit" name="submit" id="editbuyerSubmitBtn" class="hidden"/>\
                            </form>\
                        ',
                        callback: function(isUpdate) {
                            if (isUpdate) {
                                document.getElementById('editbuyerSubmitBtn').click();
                            }
                        }
                    });
                }, 'json');
            };

            this.initialize = function() {
                this.registerEvents();
            };
        }

        var script = new Script();
        script.initialize();
    </script>
</body>

</html>