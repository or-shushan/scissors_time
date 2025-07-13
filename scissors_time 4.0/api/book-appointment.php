<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

$user_id = $_SESSION['user_id'] ?? null;
$barber_id = $_POST['barber'] ?? null;
$service = $_POST['service'] ?? null;
$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;

if (!$user_id || !$barber_id || !$service || !$date || !$time) {
    echo json_encode(['success' => false, 'message' => 'נתוני הטופס חסרים']);
    exit;
}

// בדיקה אם כבר יש תור לאותו ספר, תאריך ושעה
$check = $conn->prepare("SELECT id FROM appointments WHERE barber_id = ? AND appointment_date = ? AND appointment_time = ?");
$check->bind_param("iss", $barber_id, $date, $time);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'השעה הזו תפוסה עבור הספר הזה']);
    exit;
}

// הוספת התור למסד הנתונים
$stmt = $conn->prepare("INSERT INTO appointments (user_id, barber_id, appointment_date, appointment_time, service, status) VALUES (?, ?, ?, ?, ?, ?)");
$status = 'נקבע';
$stmt->bind_param("iissss", $user_id, $barber_id, $date, $time, $service, $status);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'שגיאה בשמירת התור למסד הנתונים']);
}
?>
