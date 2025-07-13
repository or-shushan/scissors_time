<?php
include 'db.php';

$id = $_POST['id'] ?? 0;
$first = $_POST['first_name'] ?? '';
$last = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$role = $_POST['role'] ?? '';
$password = $_POST['password'] ?? '';

if ($id && $first && $email && $role) {
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, role=?, password=? WHERE id=?");
        $stmt->bind_param("ssssssi", $first, $last, $email, $phone, $role, $hashed_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, role=? WHERE id=?");
        $stmt->bind_param("sssssi", $first, $last, $email, $phone, $role, $id);
    }
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
}
