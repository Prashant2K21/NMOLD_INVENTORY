<?php

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$pid = $_POST['pid'];

// Upload or move the file to our directory
$target_dir = "../uploads/products/";
$file_name_value = NULL;
$file_data = $_FILES['img'];
if ($file_data['tmp_name'] != '') {
    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    $file_name = 'product-' . time() . '.' . $file_ext;
    $check = getimagesize($file_data['tmp_name']);
    $file_name_value = NULL;
    if ($check !== false) {
        // Move the file
        if (move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            // Save the file name to the database
            $file_name_value = $file_name;
        }
    }
}


// Update the product record
try {
    include('connection.php'); // Make sure the connection.php file is included here.

    $sql = "UPDATE products SET product_name=?, description=?,img=? WHERE id=?";


    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_name, $description, $file_name_value, $pid]); // Assuming $pid is defined somewhere.

    //delete the old values
    $sql = "DELETE FROM productsuppliers WHERE product=?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$pid]);

    //loop through the suppliers and add record
    //get suppliers
        $suppliers = isset($_POST['suppliers'])?$_POST['suppliers']:[];
        foreach($suppliers as $supplier){
            $supplier_data = [
                'supplier_id' => $supplier,
                'product_id' => $pid,
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
        'message' => "<strong>$product_name</strong> successfully updated to the system."
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ];
}

echo json_encode($response);