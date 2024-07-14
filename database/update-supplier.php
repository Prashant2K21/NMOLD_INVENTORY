<?php

$supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
$supplier_contact = isset($_POST['supplier_contact']) ? $_POST['supplier_contact'] : '';
$supplier_gstin= isset($_POST['supplier_gstin']) ? $_POST['supplier_gstin'] : '';
$supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';



$supplier_id =  $_POST['sid'];


// Update the product record
try {
    include('connection.php'); // Make sure the connection.php file is included here.

    $sql = "UPDATE suppliers SET supplier_name=?,supplier_contact=?,supplier_gstin=?, supplier_location=?,email=? WHERE id=?";


    $stmt = $conn->prepare($sql);
    $stmt->execute([$supplier_name,$supplier_contact,$supplier_gstin, $supplier_location, $email, $supplier_id]); // Assuming $pid is defined somewhere.

    //delete the old values
    $sql = "DELETE FROM productsuppliers WHERE supplier=?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$supplier_id]);

    //loop through the suppliers and add record
    //get suppliers
        $products = isset($_POST['products'])?$_POST['products']:[];
        foreach($products as $product){
            $supplier_data = [
                'supplier_id' => $supplier_id,
                'product_id' => $product,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $insert_method = "INSERT INTO 
            productsuppliers(supplier, product, updated_at, created_at)
            VALUES 
            (:supplier_id, :product_id, :updated_at, :created_at)";
            
            $stmt = $conn->prepare($insert_method);
            $stmt->execute($supplier_data);
        }
    $response = [
        'success' => true,
        'message' => "<strong>$supplier_name</strong> successfully updated to the system."
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ];
}

echo json_encode($response);