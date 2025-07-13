<?php
include 'db.php';
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

if ($q !== '') {
    $search = "%" . $q . "%";
    $stmt = $conn->prepare("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, email, phone, role FROM users WHERE CONCAT(first_name, ' ', last_name) LIKE ?");
    $stmt->bind_param("s", $search);
} else {
    $stmt = $conn->prepare("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, email, phone, role FROM users");
}

$stmt->execute();
$result = $stmt->get_result();
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>
