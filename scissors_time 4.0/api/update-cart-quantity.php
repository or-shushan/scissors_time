<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'משתמש לא מחובר']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$item_id = isset($data['item_id']) ? intval($data['item_id']) : 0;
$change = isset($data['change']) ? intval($data['change']) : 0;

if ($item_id <= 0 || $change === 0) {
    echo json_encode(['success' => false, 'message' => 'נתונים לא תקינים']);
    exit;
}

// קבלת הכמות הנוכחית
$stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $item_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $new_quantity = $row['quantity'] + $change;
    if ($new_quantity <= 0) {
        // אם הכמות פחות מ-1 – הסר את הפריט
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $item_id, $_SESSION['user_id']);
        $stmt->execute();
    } else {
        // עדכון כמות
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ?, created_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $new_quantity, $item_id, $_SESSION['user_id']);
        $stmt->execute();
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'פריט לא נמצא']);
}
?>
