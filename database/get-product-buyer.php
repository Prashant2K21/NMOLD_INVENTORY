<?php
include('connection.php');

$id =$_GET['id'];

//fetch suppliers
$stmt = $conn->prepare("
SELECT buyer_name, buyers.id
FROM buyers, productbuyers 
WHERE
 productbuyers.product=$id
AND
productbuyers.buyer = buyers.id
");
$stmt->execute();                                                    
$suppliers = $stmt->fetchAll();


echo json_encode($buyers); 