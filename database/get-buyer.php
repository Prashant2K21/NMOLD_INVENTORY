<?php
include('connection.php');

$id =$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM buyers WHERE id=$id"); 
$stmt->execute(); 
$row = $stmt->fetch();

//fetch buyers
$stmt = $conn->prepare("
SELECT product_name, products.id
FROM products, productbuyers 
WHERE
productbuyers.buyer=$id
AND
productbuyers.product = products.id
");
$stmt->execute();                                                    
$products = $stmt->fetchAll();

$row['products']= array_column($products, 'id');
echo json_encode($row);