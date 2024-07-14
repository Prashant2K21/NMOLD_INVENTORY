<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('location: login.php');
}

include 'Invoice.php';
$invoice = new Invoice();
$show_table = 'products';
$products = include('database/show.php');
// $products = json_encode($products);


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
											<h2 class="title"> Invoice System</h2>

										</div>
									</div>
									<input id="currency" type="hidden" value="$">
									<div class="row">
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
											<h3>From,</h3>
											<?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?><br>

											<?php echo $_SESSION['user']['email']; ?><br>


										</div>
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
											<h3>To,</h3>
											<div class="form-group">
												<input type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off">
											</div>
											<div class="form-group">
												<textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"></textarea>
											</div>

										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<table class="table table-bordered table-hover" id="invoiceItem">
												<tr>
													<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
													<th width="15%">Item No</th>
													<th width="38%">Product Name</th>
													<th width="15%">Quantity</th>
													<th width="15%">Price</th>
													<th width="15%">Total</th>
												</tr>


												<tr>
													<td><input class="itemRow" type="checkbox"></td>
													<td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
													<!-- <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td> -->
													<td>
														<select name="productName[]" id="productName_1" class="form-control">
															<option value="">SELECT</option>
															<?php
															foreach ($products as $item) {
																echo "
														<option value='{$item['product_name']}'>{$item['product_name']}</option>
														";
															}
															?>
														</select>
													</td>
													
														</td>
													<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
													<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
													<td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
												</tr>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
											<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
											<button class="btn btn-success" id="addRows" type="button">+ Add More</button>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											<h3>Notes: </h3>
											<div class="form-group">
												<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
											</div>
											<br>
											<div class="form-group">
												<input type="hidden" value="<?php echo $_SESSION['user']['id']; ?>" class="form-control" name="userId">
												<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
											</div>

										</div>
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
											<span class="form-inline">
												<div class="form-group">
													<label>Subtotal: &nbsp;</label>
													<div class="input-group">
														<div class="input-group-addon currency">$</div>
														<input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
													</div>
												</div>
												<div class="form-group">
													<label>Tax Rate: &nbsp;</label>
													<div class="input-group">
														<input value="" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
														<div class="input-group-addon">%</div>
													</div>
												</div>
												<div class="form-group">
													<label>Tax Amount: &nbsp;</label>
													<div class="input-group">
														<div class="input-group-addon currency">$</div>
														<input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
													</div>
												</div>
												<div class="form-group">
													<label>Total: &nbsp;</label>
													<div class="input-group">
														<div class="input-group-addon currency">$</div>
														<input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
													</div>
												</div>
												<div class="form-group">
													<label>Amount Paid: &nbsp;</label>
													<div class="input-group">
														<div class="input-group-addon currency">$</div>
														<input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
													</div>
												</div>
												<div class="form-group">
													<label>Amount Due: &nbsp;</label>
													<div class="input-group">
														<div class="input-group-addon currency">$</div>
														<input value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
													</div>
												</div>
											</span>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	</div>

	<?php include('partials/app-script.php'); ?>
	

	<script src="js/invoice.js"></script>


</body>

</html>