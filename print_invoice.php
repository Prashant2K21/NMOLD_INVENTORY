<?php
session_start();

include 'Invoice.php';
$invoice = new Invoice();

// Check if the invoice_id is provided and not empty
if (!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
    $invoiceValues = $invoice->getInvoice($_GET['invoice_id']);
    $invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
} else {
    // Handle the case where invoice_id is missing or empty (you may want to add error handling)
    echo "Invalid or missing invoice_id";
    exit; // Exit the script
}

$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['order_date']));

// Initialize the output HTML
$output = '';

// Start building the HTML for the invoice
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	To,<br />
	<b>RECEIVER (BILL TO)</b><br />
	Name : ' . $invoiceValues['order_receiver_name'] . '<br /> 
	Billing Address : ' . $invoiceValues['order_receiver_address'] . '<br />
	</td>
	<td width="35%">         
	Invoice No. : ' . $invoiceValues['order_id'] . '<br />
	Invoice Date : ' . $invoiceDate . '<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="left">Item Code</th>
	<th align="left">Product Name</th>
	<th align="left">Quantity</th>
	<th align="left">Price</th>
	<th align="left">Actual Amt.</th> 
	</tr>';
$count = 0;
foreach ($invoiceItems as $invoiceItem) {
    $count++;
    $output .= '
	<tr>
	<td align="left">' . $count . '</td>
	<td align="left">' . $invoiceItem["item_code"] . '</td>
	<td align="left">' . $invoiceItem["product _name"] . '</td>
	<td align="left">' . $invoiceItem["order_item_quantity"] . '</td>
	<td align="left">' . $invoiceItem["order_item_price"] . '</td>
	<td align="left">' . $invoiceItem["order_item_final_amount"] . '</td>   
	</tr>';
}

// Calculate totals and add them to the HTML
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>' . $invoiceValues['order_total_before_tax'] . '</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Tax Rate :</b></td>
	<td align="left">' . $invoiceValues['order_tax_per'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Tax Amount: </td>
	<td align="left">' . $invoiceValues['order_total_tax'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Total: </td>
	<td align="left">' . $invoiceValues['order_total_after_tax'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Amount Paid:</td>
	<td align="left">' . $invoiceValues['order_amount_paid'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Amount Due:</b></td>
	<td align="left">' . $invoiceValues['order_total_amount_due'] . '</td>
	</tr>';
$output .= '
	</table>
	</td>
	</tr>
	</table>';

// Create PDF of the invoice
$invoiceFileName = 'Invoice-' . $invoiceValues['order_id'] . '.pdf';
require_once 'dompdf/autoload.inc.php'; // Use autoload.inc.php for Dompdf
// require_once "dompdf/src/Autoloader.php";
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($output);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>
