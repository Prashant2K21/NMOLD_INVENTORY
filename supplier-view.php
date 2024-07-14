<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$show_table = 'suppliers';

$suppliers = include('database/show.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Suppliers - Inventory Management System</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i>List of Suppliers</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier Contact</th>
                                                <th>Supplier GSTIN</th>
                                                <th>Supplier Location</th>
                                                <th>Email</th>
                                                <th>Products</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $index => $supplier) {
                                            ?>
                                                <tr>
                                                    <td><?= $index + 1  ?></td>
                                                    <td>
                                                        <?= $supplier['supplier_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['supplier_contact'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['supplier_gstin'] ?>
                                                    </td>
                                                    <td><?= $supplier['supplier_location'] ?></td>
                                                    <td><?= $supplier['email'] ?></td>
                                                    <td>
                                                        <?php
                                                        $product_list = '-';
                                                        $sid = $supplier['id'];
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
                                                        $uid = $supplier['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id = $uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        $created_by_name = $row['first_name'] . '' . $row['last_name'];
                                                        echo  $created_by_name;


                                                        ?>

                                                    </td>

                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($supplier['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($supplier['updated_at'])) ?></td>
                                                    <td><a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>" data-sid="<?= $supplier['id'] ?>"><i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($suppliers) ?>suppliers</p>
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

                    if (classList.contains('deleteSupplier')) {
                        e.preventDefault();
                        var sId = targetElement.dataset.sid;
                        var supplierName = targetElement.dataset.name;
                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Supplier',
                            message: `Are you sure to delete <strong>${supplierName}</strong>?`,
                            callback: function(isDelete) {
                                if (isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            id: sId,
                                            table: 'suppliers'
                                        },
                                        url: 'database/delete.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            var message = data.success ?
                                                supplierName + ' successfully deleted' : 'Error Processing your request!';

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

                    if (classList.contains('updateSupplier')) {
                        e.preventDefault();
                        var sId = targetElement.dataset.sid;
                        vm.showEditDialog(sId);
                    }
                });
            };

            document.addEventListener('submit', function(e) {
                e.preventDefault();
                var targetElement = e.target;

                if (targetElement.id === 'editSupplierForm') {
                    vm.saveUpdateData(targetElement);
                }
            });

            this.saveUpdateData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: {
                        supplier_name: document.getElementById('supplier_name').value,
                        supplier_contact: document.getElementById('supplier_contact').value,
                        supplier_gstin: document.getElementById('supplier_gstin').value,
                        supplier_location: document.getElementById('supplier_location').value,
                        email: document.getElementById('email').value,
                        products: $('#products').val(),
                        sid: document.getElementById('sid').value
                    },
                    url: 'database/update-supplier.php',
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
                $.get('database/get-supplier.php', {
                    'id': id
                }, function(supplierDetails) {
                    let curProducts = supplierDetails['products'];
                    let productOptions = '';

                    for (const [pId, pName] of Object.entries(productList)) {
                        selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                        productOptions += "<option " + selected + " value='" + pId + "'>" + pName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'update <strong>' + supplierDetails.supplier_name + '</strong>',
                        message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
                    <div class="appFormInputContainer">\
                                        <label for="supplier_name">Supplier Name</label>\
                                        <input type="text" class="appFormInput" id="supplier_name" value="' + supplierDetails.supplier_name + '" placeholder="Enter supplier name..." name="supplier_name">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="supplier_contact">Supplier Contact</label>\
                                        <input type="text" class="appFormInput" id="supplier_contact" value="' + supplierDetails.supplier_contact + '" placeholder="Enter supplier contact..." name="supplier_contact">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="supplier_gstin">Supplier GSTIN</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_gstin" value="' + supplierDetails.supplier_gstin + '" placeholder="Enter supplier GSTIN..." name="supplier_gstin">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="supplier_location">Supplier Location</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="supplier_location" value="' + supplierDetails.supplier_location + '" placeholder="Enter supplier location..." name="supplier_location">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="email">Email</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" id="email" value="' + supplierDetails.email + '" placeholder="Enter email..." name="email">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="desciption">Products</label>\
                                        <select name="products[]" id="products" multiple="">\
                                            <option value="">Select Products</option>\
                                           ' + productOptions + '\
                                        </select>\
                                    <div>\
                              <input type="hidden" name="sid" id="sid" value="' + supplierDetails.id + '"/>\
                                <input type="submit" value="submit" name="submit" id="editSupplierSubmitBtn" class="hidden"/>\
                            </form>\
                        ',
                        callback: function(isUpdate) {
                            if (isUpdate) {
                                document.getElementById('editSupplierSubmitBtn').click();
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