<?php 
session_start(); 
include 'db.php';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SCISSORS TIME</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
  <header class="header">
    <div class="container1">
      <div class="header-content">
        <div class="logo">
          <a href="index.php">SCISSORS <span class="fas fa-scissors"></span> TIME</a>
        </div>

        <nav class="main-nav">
          <ul>
            <li><a href="about.php">אודות</a></li>
            <li><a href="index.php">דף הבית</a></li>
            <li><a href="appointments.php">הזמן תור</a></li>
            <li><a href="products.php">מוצרים</a></li>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li>
          </ul>
        </nav>

        <div class="auth-buttons">
          <?php if (isset($_SESSION['full_name'])): ?>
            <div class="user-dropdown">
              <button class="btn btn-outline user-btn">
                <i class="fas fa-user"></i>
                <span><?= htmlspecialchars($_SESSION['full_name']) ?></span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="dropdown-menu">
                <a href="profile.php"><i class="fas fa-user-circle"></i> פרופיל</a>
                <a href="order-history.php"><i class="fas fa-history"></i> היסטוריית הזמנות</a>
                <a href="appointments-history.php"><i class="fas fa-cut"></i> התורים שלי</a>
                <hr>
                <?php if ($_SESSION['role'] === 'מנהל'): ?>
                  <a href="admin.php"><i class="fas fa-user-shield"></i> כניסת מנהל</a>
                  <a href="barber-login.php"><i class="fas fa-user-shield"></i> כניסת ספר</a>
                  <a href="admin-reports.php"><i class="fas fa-book"></i> דוחות</a>
                <?php elseif ($_SESSION['role'] === 'ספר'): ?>
                  <a href="barber-login.php"><i class="fas fa-user-shield"></i> כניסת ספר</a>
                <?php endif; ?>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> התנתק</a>
              </div>
            </div>
          <?php else: ?>
            <a href="login.php" class="btn">התחברות</a>
            <a href="register.php" class="btn">הרשמה</a>
          <?php endif; ?>
        </div>

        <div class="mobile-menu-toggle">
          <i class="fas fa-bars"></i>
        </div>
      </div>
    </div>
  </header>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const userBtn = document.querySelector('.user-btn');
      const dropdownMenu = document.querySelector('.dropdown-menu');

      if (userBtn && dropdownMenu) {
        userBtn.addEventListener('click', function (e) {
          e.preventDefault();
          dropdownMenu.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
          if (!e.target.closest('.user-dropdown')) {
            dropdownMenu.classList.remove('active');
          }
        });
      }
    });
  </script>
</body>
</html>
