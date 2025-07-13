<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'error' => 'לא מחובר']);
  exit;
}

$user_id = $_SESSION['user_id'];
$first = $_POST['first_name'] ?? '';
$last = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

// בדיקת שדות חובה
if (!$first || !$email) {
  echo json_encode(['success' => false, 'error' => 'שדות חובה חסרים']);
  exit;
}

// טיפול בתמונה
$imageName = '';
if (!empty($_FILES['user-image']['name'])) {
  $targetDir = "images/users/";
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
  }
  $imageName = time() . '_' . basename($_FILES["user-image"]["name"]);
  $targetFile = $targetDir . $imageName;

  if (!move_uploaded_file($_FILES["user-image"]["tmp_name"], $targetFile)) {
    echo json_encode(['success' => false, 'error' => 'שגיאה בהעלאת תמונה']);
    exit;
  }
}

// בניית השאילתה בהתאם למה שהוזן
if ($password && $imageName) {
  $hashed = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, password = ?, image = ? WHERE id = ?");
  $stmt->bind_param("ssssssi", $first, $last, $email, $phone, $hashed, $imageName, $user_id);
} elseif ($password) {
  $hashed = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, password = ? WHERE id = ?");
  $stmt->bind_param("sssssi", $first, $last, $email, $phone, $hashed, $user_id);
} elseif ($imageName) {
  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, image = ? WHERE id = ?");
  $stmt->bind_param("sssssi", $first, $last, $email, $phone, $imageName, $user_id);
} else {
  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
  $stmt->bind_param("ssssi", $first, $last, $email, $phone, $user_id);
}

// ביצוע
if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'שגיאה בעדכון']);
}
?>
