<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($first_name && $last_name && $email && $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hash, $phone);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "שגיאה בהרשמה: " . $stmt->error;
        }
    } else {
        $error = "נא למלא את כל השדות.";
    }
}
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>הרשמה - SCISSORS TIME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="auth-section">
<div class="container">
<div class="auth-container">
<div class="auth-form-container">
<h1>הרשמה</h1>
<p class="auth-intro">צור חשבון חדש והתחל ליהנות מכל ההטבות שלנו.</p>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form id="register-form" class="auth-form" method="POST" action="register.php">
<div class="form-row">
<div class="form-group">
<label for="first-name">שם פרטי</label>
<div class="input-icon-wrapper">
<i class="fas fa-user"></i>
<input type="text" name="first_name" id="first-name" placeholder="שם פרטי" required>
</div>
</div>
<div class="form-group">
<label for="last-name">שם משפחה</label>
<div class="input-icon-wrapper">
<i class="fas fa-user"></i>
<input type="text" id="last-name" name="last_name" placeholder="הכנס שם משפחה" required>
</div>
</div>
</div>

<div class="form-group">
<label for="register-email">כתובת אימייל</label>
<div class="input-icon-wrapper">
<i class="fas fa-envelope"></i>
<input type="email" id="register-email" name="email" placeholder="הכנס את כתובת האימייל שלך" required>
</div>
</div>

<div class="form-group">
<label for="phone">מספר טלפון</label>
<div class="input-icon-wrapper">
<i class="fas fa-phone"></i>
<input type="tel" id="phone" name="phone" placeholder="הכנס את מספר הטלפון שלך" required>
</div>
</div>

<div class="form-group">
<label for="register-password">סיסמה</label>
<div class="input-icon-wrapper">
<i class="fas fa-lock"></i>
<input type="password" id="register-password" name="password" placeholder="צור סיסמה" required>
<button type="button" class="password-toggle"></button>
</div>
</div>

<div class="form-group">
<label for="confirm-password">אימות סיסמה</label>
<div class="input-icon-wrapper">
<i class="fas fa-lock"></i>
<input type="password" id="confirm-password" name="confirm-password" placeholder="אמת את הסיסמה" required>
<button type="button" class="password-toggle"></button>
</div>
</div>

<div class="form-checkbox">
<input type="checkbox" id="terms" name="terms" required>
<label for="terms">אני מסכים ל<a href="#">תנאי השימוש</a> ול<a href="#">מדיניות הפרטיות</a></label>
</div>

<button type="submit" class="btn btn-primary btn-block">הירשם</button>
</form>

<div class="auth-footer">
כבר יש לך חשבון? <a href="login.php">התחבר כאן</a>
</div>
</div>

<div class="auth-image">
<div class="auth-image-content">
<h2>SCISSORS TIME</h2>
<p>הירשם עכשיו כדי להזמין תורים בקלות, לראות את היסטוריית התספורות שלך ולקבל הנחות מיוחדות!</p>
</div>
</div>
</div>
</div>
</section>

</body>
</html>