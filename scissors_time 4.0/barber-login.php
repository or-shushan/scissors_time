<?php
session_start();
include 'db.php';
include 'components/header.php';


if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['מנהל', 'ספר'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>כניסת ספר - SCISSORS TIME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
  

    <!-- Barber Dashboard Section -->
    <section class="barber-section">
        <div class="container">
            <div class="section-header">
                <h1>ממשק ספר <span class="fas fa-calendar-alt"></span></h1>
                <div class="divider"></div>
                <p>נהל את התורים שלך וקבע ימים סגורים בקלות</p>
            </div>

            <div class="barber-content" style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem;">
                <!-- Closed Days Management (Left) -->
                <div class="closed-days">
                    <h2>ניהול ימים סגורים</h2>
                    <div class="form-group">
                        <label for="closed-date">בחר תאריך לסגירה</label>
                        <input type="date" id="closed-date">
                    </div>
                    <button class="btn btn-primary" id="add-closed-date">הוסף יום סגור</button>
                    <button class="btn btn-outline" id="remove-closed-date">הסר יום סגור</button>
                    <div class="closed-dates-list" id="closed-dates-list">
                        <h3>ימים סגורים</h3>
                        <ul></ul>
                    </div>
                </div>

                <!-- Daily Schedule (Right) -->
                <div class="daily-schedule">
                    <h2>יומן תורים</h2>
                    <div class="date-nav">
                        <button class="btn btn-outline" id="prev-day"><i class="fas fa-chevron-right"></i></button>
                        <div id="calendar-picker" style="display: inline-block;"></div>
                        <button class="btn btn-outline" id="next-day"><i class="fas fa-chevron-left"></i></button>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>שעה</th>
                                <th>שם הלקוח</th>
                                <th>שירות</th>
                            </tr>
                        </thead>
                        <tbody id="appointments-table"></tbody>
                    </table>
                </div>
            </div>
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
                <p>© 2023 SCISSORS TIME. כל הזכויות שמורות.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/products.js"></script>
    <script src="js/appointments-history.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/he.js"></script>
    <script>
    const loggedInBarberId = <?= json_encode($user_id) ?>;
    </script>
    <script src="js/barber-login.js"></script>

</body>
</html>