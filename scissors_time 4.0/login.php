<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit;
            } else {
                $error = 'סיסמה שגויה';
            }
        } else {
            $error = 'משתמש לא נמצא';
        }
    } else {
        $error = 'נא למלא את כל השדות';
    }
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>התחברות</title>
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
          <h1>התחברות</h1>
          <p class="auth-intro">הזן את הפרטים שלך כדי להיכנס למערכת.</p>
          <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
          <form method="POST" action="login.php" id="login-form" class="auth-form">
            <div class="form-group">
              <label for="email">אימייל</label>
              <div class="input-icon-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="הכנס את כתובת האימייל שלך" required>
              </div>
            </div>
            <div class="form-group">
              <label for="password">סיסמה</label>
              <div class="input-icon-wrapper">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="הכנס סיסמה" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">התחבר</button>
          </form>
          <div class="auth-footer">
            אין לך חשבון? <a href="register.php">הרשמה</a>
          </div>
        </div>
        <div class="auth-image">
          <div class="auth-image-content">
            <h2>SCISSORS TIME</h2>
            <p>התחבר כדי לנהל תורים, פרופיל אישי והזמנות!</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>