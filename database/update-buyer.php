<?php

$buyer_name = isset($_POST['buyer_name']) ? $_POST['buyer_name'] : '';
$buyer_contact = isset($_POST['buyer_contact']) ? $_POST['buyer_contact'] : '';
$buyer_gstin= isset($_POST['buyer_gstin']) ? $_POST['buyer_gstin'] : '';
$buyer_location = isset($_POST['buyer_location']) ? $_POST['buyer_location'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';



$buyer_id =  $_POST['sid'];


// Update the product record
try {
    include('connection.php'); // Make sure the connection.php file is included here.

    $sql = "UPDATE buyers SET buyer_name=?,buyer_contact=?,buyer_gstin=?, buyer_location=?,email=? WHERE id=?";


    $stmt = $conn->prepare($sql);
    $stmt->execute([$buyer_name,$buyer_contact,$buyer_gstin, $buyer_location, $email, $buyer_id]); // Assuming $pid is defined somewhere.

    //delete the old values
    $sql = "DELETE FROM productbuyers WHERE buyer=?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$buyer_id]);

    //loop through the buyers and add record
    //get buyers
        $products = isset($_POST['products'])?$_POST['products']:[];
        foreach($products as $product){
            $buyer_data = [
                'buyer_id' => $buyer_id,
                'product_id' => $product,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $insert_method = "INSERT INTO 
            productbuyers(buyer, product, updated_at, created_at)
            VALUES 
            (:buyer_id, :product_id, :updated_at, :created_at)";
            
            $stmt = $conn->prepare($insert_method);
            $stmt->execute($buyer_data);
        }
    $response = [
        'success' => true,
        'message' => "<strong>$buyer_name</strong> successfully updated to the system."
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ];
}

echo json_encode($response);