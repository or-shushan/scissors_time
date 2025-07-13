<?php
ob_start();
include 'db.php';
ob_end_clean();

header('Content-Type: application/json');

$first = $_POST['first_name'] ?? '';
$last = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!$first || !$email || !$password || !$role) {
  echo json_encode(['success' => false, 'error' => 'חסרים שדות חובה']);
  exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, role, password) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
  echo json_encode(['success' => false, 'error' => 'שגיאה בהכנת השאילתה']);
  exit;
}

$stmt->bind_param("ssssss", $first, $last, $email, $phone, $role, $hashed);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'שגיאה בהוספה: ' . $stmt->error]);
}
?>
