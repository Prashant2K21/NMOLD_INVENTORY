<?php
session_start();
//capture the table mappings
include('table-columns.php');
//capture the tablename
$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];

$db_arr = [];
$user = $_SESSION['user'];
foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at'])) $value = date('Y-m-d H:i:s');
    else if ($column == 'created_by') $value = $user['id'];
    else if ($column == 'password') $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    // else if ($column == 'user_role') $value = $_POST['user_role'];
    elseif ($column == 'img') {
        //upload or move the file to our directory
        $target_dir = "../uploads/products/";
        $file_data = $_FILES[$column];

        $value = NULL;
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
                    $value = $file_name;
                }
            }
        }
    } else $value = isset($_POST[$column]) ? $_POST[$column] : '';
    $db_arr[$column] = $value;
}


$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

//adding record to main table
try {
    $insert_method = "INSERT INTO 
                            $table_name($table_properties)
      VALUES 
              ($table_placeholders)";


    include('connection.php');
    $stmt = $conn->prepare($insert_method);
    $stmt->execute($db_arr);
    //get saved id
    $product_id = $conn->lastInsertId();

    //add supplier
    if ($table_name === 'products') {
        $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
        if ($suppliers) {
            //loop through the suppliers and add record
            foreach ($suppliers as $supplier) {
                $supplier_data = [
                    'supplier_id' => $supplier,
                    'product_id' => $product_id,
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
        }
    }
    //add buyer
    if ($table_name === 'products') {
        $buyers = isset($_POST['buyers']) ? $_POST['buyers'] : [];
        if ($buyers) {
            //loop through the suppliers and add record
            foreach ($buyers as $buyer) {
                $buyer_data = [
                    'buyer_id' => $buyer,
                    'product_id' => $product_id,
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
        }
    }
    $response = [
        'success' => true,
        'message' => ' successfully added to the system.'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('location: ../' . $_SESSION['redirect_to']);
