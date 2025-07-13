
<?php
include 'db.php';
$id = $_POST['id'];
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();
echo json_encode(['success' => $success]);
?>
