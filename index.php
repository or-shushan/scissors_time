
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCISSORS TIME - מספרה מקצועית</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!--link to font & uniqe images-->
    <script src="js/auth.js" ></script>
    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/profile.js"></script>
    <script src="js/appointments-history.js"></script>
 
 <?php
include 'db.php';
 include 'components/header.php';

session_start();
?>
<?php if (isset($_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['role'])): ?>
<script>
  window.loggedInUser = {
    firstName: <?= json_encode($_SESSION['first_name']) ?>,
    lastName: <?= json_encode($_SESSION['last_name']) ?>,
    role: <?= json_encode($_SESSION['role']) ?>
  };
</script>
<?php endif; ?>

</head>
<body>
  

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>ברוכים הבאים <br><span class="gradient-text">SCISSORS TIME</span></h1>
                <p>חווית תספורת אישית ומקצועית <br> הקפה עלינו <span class="far fa-face-smile-wink"> <span class="fas fa-mug-hot"> </span></span></p>
                <div class="hero-buttons">
                    <a href="appointments.php" class="btn btn-primary">הזמן תור עכשיו</a>
                    <a href="#services" class="btn btn-outline">השירותים שלנו</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <h2>השירותים שלנו</h2>
                <div class="divider"></div>
                <p>אנו מציעים מגוון רחב של שירותי תספורת וטיפוח</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <h3>תספורת גברים</h3>
                    <p>תספורות עדכניות בסגנון אישי המתאים לך</p>
                    <span class="price">₪80</span>
                    
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>תספורת וזקן</h3>
                    <p>תספורת מושלמת כולל עיצוב זקן מלא</p>
                    <span class="price">₪110</span>
                    
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hot-tub"></i>
                    </div>
                    <h3>עיצוב זקן</h3>
                    <p>עיצוב וטיפוח זקן מקצועי</p>
                    <span class="price">₪45</span>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <h2>למה לבחור בנו?</h2>
                <div class="divider"></div>
                <p>פתרונות מודרניים לחוויית מספרה קלאסית. אנו משלבים מסורת עם טכנולוגיה.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <h3>הזמנה קלה</h3>
                    <p>הזמן את התספורת שלך בכמה קליקים. בחר את הספר, התאריך והשעה.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>ללא זמן המתנה</h3>
                    <p>הגע בזמן וקבל שירות מיידי עם התהליך היעיל שלנו.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <h3>תספורות איכותיות</h3>
                    <p>ספרים מיומנים המספקים תספורות יוצאות דופן המותאמות לסגנון שלך.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>פרופילים אישיים</h3>
                    <p>שמור על הסגנונות המועדפים עליך לחוויה עקבית בכל ביקור.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>תשלום קל</h3>
                    <p>שלם בבטחה באופן מקוון או במקום עם מגוון אפשרויות תשלום.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>מוצרים איכותיים</h3>
                    <p>רכוש מוצרי שיער איכותיים לשמירה על המראה שלך בין הביקורים.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Barbers Section -->
    <section class="barbers">
        <div class="container">
            <div class="section-header">
                <h2>הספרים שלנו <span class="fas fa-people-group"></span></h2>
                <div class="divider"></div>
                <p>צוות מקצועי ומנוסה לשירותך</p>
            </div>
            <div class="barbers-grid">
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="picturs/or.JPG" alt="אור שושן" class="member-img">
                    </div>
                    <h3>Or Shushan</h3>
                    <p>מומחה לתספורות מודרניות</p>
                </div>
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="picturs/ran.jpg" alt="רן ברסימנטוב" class="member-img">
                    </div>
                    <h3>Ran Barsimantov</h3>
                    <p>מומחה לתספורות ילדים</p>
                </div>
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="picturs/lior.jpg" alt="ליאור טקצ'נקו" class="member-img">
                    </div>
                    <h3>Lior Takachenko</h3>
                    <p>מומחה לעיצוב זקן</p>
                </div> 
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="picturs/akalo.jpg" alt="נגוסו אקלו" class="member-img">
                    </div>
                    <h3>Naguso Akelo</h3>
                    <p>מומחה לתספורות אפרו</p>
                </div>
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="picturs/shay12.jpg" alt="שי צבאן" class="member-img">
                    </div>
                    <h3>Dr.Tsaban</h3>
                    <p>מומחה לעיצוב שיעור לקירחים</p>
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
                <p>&copy; 2023 SCISSORS TIME. כל הזכויות שמורות.</p>
            </div>
        </div>
    </footer>



<aside class="sidebar">
    <?php
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] === 'מנהל') {
            echo '<a href="admin.php">ניהול משתמשים</a>';
            echo '<a href="admin-products.php">ניהול מוצרים</a>';
        } elseif ($_SESSION['user_role'] === 'ספר') {
            echo '<a href="appointments.php">תורים שלי</a>';
        } elseif ($_SESSION['user_role'] === 'לקוח') {
            echo '<a href="profile.php">פרופיל</a>';
            echo '<a href="order-history.php">הזמנות</a>';
        }
    }
    ?>
</aside>

</body>
</html>
