<?php
include 'db.php';
header('Content-Type: application/json');

$uploadDir = 'images/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$price = isset($_POST['price']) ? trim($_POST['price']) : '';
$quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$imagePath = '';

if (!empty($_FILES['imageFile']['name'])) {
    $targetFile = $uploadDir . basename($_FILES['imageFile']['name']);
    if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetFile)) {
        $imagePath = $targetFile;
    }
}

if (!empty($id)) {
    // If no new image uploaded, keep current image
    if ($imagePath === '') {
        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, quantity=?, description=? WHERE id=?");
        $stmt->bind_param("ssdisi", $name, $category, $price, $quantity, $description, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, quantity=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("ssdissi", $name, $category, $price, $quantity, $description, $imagePath, $id);
    }
} else {
    $stmt = $conn->prepare("INSERT INTO products (name, category, description, image, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $name, $category, $price, $quantity, $description, $imagePath);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>