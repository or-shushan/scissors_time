<?php
$host = 'localhost';
$db = 'scissors_time';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("שגיאת חיבור למסד הנתונים: " . $conn->connect_error);
}
?>
