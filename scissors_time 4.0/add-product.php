
<?php
include 'db.php';
$name = $_POST['name'];
$category = $_POST['category'];
$price = floatval($_POST['price']);
$description = $_POST['description'];
$quantity = intval($_POST['quantity']);
$image = $_POST['image'] ?? '';
$stmt = $conn->prepare("INSERT INTO products (name, category, price, description, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsss", $name, $category, $price, $description, $quantity, $image);
$success = $stmt->execute();
echo json_encode(['success' => $success]);
?>
