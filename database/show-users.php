<?php

require_once __DIR__ . "/connection.php";

$stmt = $conn->prepare("SELECT * FROM ORDER BY created_at DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
return $stmt->fetchAll();
