<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'משתמש לא מחובר']);
    exit;
}

$user_id = $_SESSION['user_id'];

// שליפת פריטים מהעגלה
$stmt = $conn->prepare("
    SELECT ci.product_id, ci.quantity, p.price
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// אם העגלה ריקה – החזר שגיאה
if (empty($items)) {
    echo json_encode(['success' => false, 'message' => 'העגלה ריקה']);
    exit;
}

// יצירת הזמנה בטבלת orders
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;

// הוספת פריטים לטבלת order_items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($items as $item) {
    $price = $item['price'];
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $price);
    $stmt->execute();
}

// ניקוי העגלה
$stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

echo json_encode(['success' => true, 'order_id' => $order_id]);
?>
