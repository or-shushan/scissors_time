<?php
session_start();
include 'db.php';
include 'components/header.php';

$user_id = $_SESSION['user_id'] ?? null;
$stmt_user = $conn->prepare("SELECT first_name, last_name, email, image FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();


if (!$user_id) {
    echo "<p>אנא התחבר למערכת כדי לצפות בתורים שלך.</p>";
    exit;
}

$query = $conn->prepare("
    SELECT a.appointment_date, a.appointment_time, a.service, a.status,
           CONCAT(u.first_name, ' ', u.last_name) AS barber_name
    FROM appointments a
    JOIN users u ON a.barber_id = u.id
    WHERE a.user_id = ?
    ORDER BY a.appointment_date ASC, a.appointment_time ASC 
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>היסטוריית התורים שלי</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/appointments.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!--קישור לאייקונים של VS-->

</head>
<body>

<section class="appointments-history">
    <div class="container">
        <div class="section-header">
            <h1>היסטוריית התורים שלי</h1>
            <div class="divider"></div>
        </div>
        <div class="profile-wrapper">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="user-info">
                    <div class="avatar">
                    <img id="user-avatar"
                    src="<?php echo !empty($user['image']) ? 'images/users/' . htmlspecialchars($user['image']) : 'images/users/placeholder.svg.jpg'; ?>"
                    alt="תמונת פרופיל">
                    </div>
                    <h3 id="user-name" >שם המשתמש:</h3>
                    <p id="user-email"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                    </div>
               
                <ul class="profile-nav">
                <li data-tab="personal-info">
                    <a href="profile.php"><i class="fas fa-user"></i> פרטים אישיים</a>
                    </li>

                    <li data-tab="haircuts"> 
                          <li class="active" data-tab="personal-info">
                        <a href="appointments-history.php"><i class="fas fa-cut"></i> התורים שלי</a>
                    </li>

                    <li data-tab="orders"> 
                        <a href="order-history.php"><i class="fas fa-shopping-bag"></i> היסטוריית הזמנות</a>
                    </li>
                </ul>
            </div>

        <?php if ($result->num_rows > 0): ?>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>תאריך</th>
                        <th>שעה</th>
                        <th>שירות</th>
                        <th>ספר</th>
                        <th>סטטוס</th>
                        <th>פעולה</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                        <td><?= date('d/m/Y', strtotime($row['appointment_date'])) ?></td>
                        <td><?= htmlspecialchars(substr($row['appointment_time'], 0, 5)) ?></td>
                            <td><?= htmlspecialchars($row['service']) ?></td>
                            <td><?= htmlspecialchars($row['barber_name']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
    <?php if ($row['status'] !== 'בוטל'): ?>
        <form method="post" action="cancel_appointment.php" onsubmit="return confirm('האם אתה בטוח שברצונך לבטל את התור?');">
            <input type="hidden" name="appointment_date" value="<?= htmlspecialchars($row['appointment_date']) ?>">
            <input type="hidden" name="appointment_time" value="<?= htmlspecialchars($row['appointment_time']) ?>">
            <button type="submit" class="btn-cancel">בטל</button>
        </form>
    <?php else: ?>
        <span class="status-cancelled">בוטל</span>
    <?php endif; ?>
</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message-wrapper">
  <h1>אין לך תורים שנקבעו, נשמח לתת לך את השירות המקצועי שלנו.</h1>
  <a href="appointments.php" class="btn-primary1">לקביעת תור לחצן כאן</a>
</div>
         <?php endif; ?>
    </div>
</section>


<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <h3>SCISSORS TIME</h3>
                <p>חווית תספורת מקצועית בסגנון אישי</p>
            </div>
            <div class="footer-links">
                <h4>ניווט מהיר</h4>
                <ul>
                    <li><a href="index.php">דף הבית</a></li>
                    <li><a href="appointments.php">הזמן תור</a></li>
                    <li><a href="products.php">מוצרים</a></li>
                    <li><a href="login.php">התחברות</a></li>
                    <li><a href="register.php">הרשמה</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4>שעות פתיחה</h4>
                <ul>
                    <li>א'-ה': 09:00-19:00</li>
                    <li>ו' וערבי חג: עד שעה לפני כניסתם</li>
                    <li>שבת: סגור</li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>צור קשר</h4>
                <p><i class="fas fa-map-marker-alt"></i> מכללת פרס, רחובות</p>
                <p><i class="fas fa-phone"></i> 03-1234567</p>
                <p><i class="fas fa-envelope"></i> info@scissorstime.co.il</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 SCISSORS TIME. כל הזכויות שמורות.</p>
        </div>
    </div>
</footer>

</body>
</html>
