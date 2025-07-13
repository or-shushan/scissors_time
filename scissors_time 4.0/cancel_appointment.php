<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$date = $_POST['appointment_date'] ?? null;
$time = $_POST['appointment_time'] ?? null;

if ($date && $time) {
    $stmt = $conn->prepare("UPDATE appointments SET status = 'בוטל' WHERE user_id = ? AND appointment_date = ? AND appointment_time = ?");
    $stmt->bind_param("iss", $user_id, $date, $time);
    $stmt->execute();
}

header("Location: appointments-history.php");
exit;
