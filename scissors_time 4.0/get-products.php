<?php
include 'db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>