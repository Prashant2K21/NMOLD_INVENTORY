<?php
session_start();
if (!isset($_SESSION['user']))  header('location: login.php');



//Get all products
$show_table = 'products';
$products = include('database/show.php');
$products = json_encode($products);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product - Inventory Management System</title>
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
                                <i class="fa fa-plus"></i>Order Product
                            </h1>
                            <div>
                                <form action="database/save-order.php" method="POST">
                                    <div class="alignRight">
                                        <button type="button" class=" orderBtn orderProductBtn" id="orderProductBtn">Add Another Product </button>
                                    </div>
                                    <div id="orderProductLists">
                                        <p id="noData" style="color:#9f9f9f">No product selected.</p>
                                    </div>
                                    <div class="alignRight marginTop20">
                                        <input type="submit" class="orderBtn submitOrderProductBtn" value="Submit Order">
                                    </div>
                                </form>
                             </div>

                             <?php if (isset($_SESSION['response'])) { 
                                $response_message = $_SESSION['response']['message'];
                                $is_success = $_SESSION['response']['success']
                                ?>
                                    <div class="responseMessage">
                                        <p class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                        <?=  $response_message ?>
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
    <?php include('partials/app-script.php'); ?>
    <script>
        var products = <?= $products ?>;
        var counter = 0;

        function script() {
            var vm = this;

            let productOptions = '\
        <div >\
                 <label for= "product_name">PRODUCT NAME</label>\
              <select name="products[]" class="productNameSelect" id="product_name">\
                <option value=""> Select Product </option>\
                INSERTPRODUCTHERE\
                </select>\
                <input type="button" class="appbtn removeOrderBtn" value="Remove">\
                </div>';

            this.initialize = function() {
                    this.registerEvents();
                    this.renderProductOptions();
                },
                this.renderProductOptions = function() {
                    let optionHTML = '';
                    products.forEach((product) => {
                        optionHTML += '<option value="' + product.id + '">' + product.product_name + '</option>';
                    })

                    productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHTML);

                },
                this.registerEvents = function() {

                    document.addEventListener('click', function(e) {
                        var targetElement = e.target;
                        var classList = targetElement.classList;

                        //add new product order event
                        if (targetElement.id === 'orderProductBtn') {
                            document.getElementById('noData').style.display = 'none';
                            let orderProductListsContainer = document.getElementById('orderProductLists');

                            orderProductLists.innerHTML += '\
                    <div class="orderProductRow">\
                                ' + productOptions + '\
                                    <div class="suppliersRows" id="supplierRows_' + counter + '"data-counter="' + counter + '"></div>\
                                    </div>';

                            counter++;
                        }

                        //if remove button is clicked
                        if (targetElement.classList.contains('removeOrderBtn')) {
                            let orderRow = targetElement
                                .closest('.orderProductRow').remove();

                            //remove element
                            console.log(orderRow);
                        }

                    });
                    document.addEventListener('change', function(e) {
                        var targetElement = e.target;
                        var classList = targetElement.classList;

                        //add supplier row AN Product option change
                        if (classList.contains('productNameSelect')) {
                            let pid = targetElement.value;

                            let counterId = targetElement
                                .closest('div.orderProductRow')
                                .querySelector('.suppliersRows')
                                .dataset.counter;

                            $.get('database/get-product-supplier.php', {
                                id: pid
                            }, function(suppliers) {
                                vm.renderSupplierRows(suppliers, counterId);
                            }, 'json');
                        }

                    });

                }
            this.renderSupplierRows = function(suppliers, counterId) {
                let supplierRows = '';
                suppliers.forEach((supplier) => {
                    supplierRows += '\
                    <div class="row">\
                <div style="width:50%;">\
                <p class="supplierName">' + supplier.supplier_name + '</p>\
                </div>\
            <div style="width:50%;">\
                <label for="quanity">Quantity :</label>\
                <input type="number" class="appFormInput orderProductQty " id="quantity" placeholder="Enter quantity..." name="quantity['+ counterId +'][' + supplier.id + ']"/>\
            </div>\
        </div>';

                });

                //Append to container
                let supplierRowContainer = document.getElementById('supplierRows_' + counterId);
                supplierRowContainer.innerHTML = supplierRows;

            }
        }
    
        (new script()).initialize();
    </script>
</body>

</html>