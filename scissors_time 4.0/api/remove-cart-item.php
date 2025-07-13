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

if ($item_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID לא תקין']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $item_id, $_SESSION['user_id']);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'שגיאה במחיקת הפריט']);
}
?>
