<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['מנהל', 'ספר'])) {
    echo json_encode(['success' => false, 'message' => 'גישה נדחתה']);
    exit;
}

$barber_id = $_SESSION['user_id'];
$date = $_GET['date'] ?? '';

if (!$date) {
    echo json_encode(['success' => false, 'message' => 'תאריך לא סופק']);
    exit;
}

$stmt = $conn->prepare("
    SELECT a.appointment_date, a.appointment_time, a.service,
           CONCAT(u.first_name, ' ', u.last_name) AS customer_name
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    WHERE a.barber_id = ? AND a.appointment_date = ?
    ORDER BY a.appointment_time ASC
");
$stmt->bind_param("is", $barber_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];

while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode(['success' => true, 'appointments' => $appointments]);
