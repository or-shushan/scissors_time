<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'משתמש לא מחובר']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$quantity = isset($data['quantity']) ? intval($data['quantity']) : 0;

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'נתונים שגויים']);
    exit;
}

// בדוק אם המוצר כבר קיים בעגלה
$stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // עדכן כמות
    $new_quantity = $row['quantity'] + $quantity;
    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ?, created_at = NOW() WHERE id = ?");
    $stmt->bind_param("ii", $new_quantity, $row['id']);
    $success = $stmt->execute();
} else {
    // הוסף מוצר חדש
    $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $success = $stmt->execute();
}

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'שגיאה בשמירת העגלה']);
}
?>
