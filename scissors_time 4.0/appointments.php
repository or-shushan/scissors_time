<?php 
include 'components/header.php'; 
include 'db.php';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>הזמן תור - SCISSORS TIME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/appointments.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<section class="appointment-section">
    <div class="container">
        <div class="section-header">
            <h1>הזמן תור <span class="far fa-calendar-check"></span></h1>
            <div class="divider"></div>
            <p>בחר ספר, שירות, תאריך ושעה שמתאימים לך</p>
        </div>

        <div class="appointment-form-container">
            <form id="appointment-form">
                <!-- ספרים -->
                <div class="form-section">
                    <h3>בחר ספר</h3>
                    <div class="barbers-selection">
                        <?php
                        $query = $conn->query("SELECT id, first_name, last_name, image FROM users WHERE role = 'ספר'");
                        $index = 1;
                        while ($barber = $query->fetch_assoc()):
                        ?>
                            <div class="barber-option">
                                <input type="radio" id="barber<?= $index ?>" name="barber" value="<?= htmlspecialchars($barber['id']) ?>">
                                <label for="barber<?= $index ?>">
                                    <div class="barber-img">
                                        <div class="placeholder-img">
                                            <img src="<?= htmlspecialchars($barber['image']) ?>" alt="NO IMG">
                                        </div>
                                    </div>
                                    <span><?= htmlspecialchars($barber['first_name'] . ' ' . $barber['last_name']) ?></span>
                                </label>
                            </div>
                        <?php 
                            $index++;
                        endwhile; 
                        ?>
                    </div>
                </div>

                <!-- שירותים -->
                <div class="form-section">
                    <h3>בחר שירות</h3>
                    <div class="services-selection">
                        <div class="service-option">
                            <input type="radio" id="service1" name="service" value="תספורת גברים">
                            <label for="service1">
                                <div class="service-icon"><i class="fas fa-cut"></i></div>
                                <div class="service-info">
                                    <span class="service-name">תספורת גברים</span>
                                    <span class="service-details">30 דקות · ₪80</span>
                                </div>
                            </label>
                        </div>
                        <div class="service-option">
                            <input type="radio" id="service2" name="service" value="תספורת וזקן">
                            <label for="service2">
                                <div class="service-icon"><i class="fas fa-user-tie"></i></div>
                                <div class="service-info">
                                    <span class="service-name">תספורת וזקן</span>
                                    <span class="service-details">45 דקות · ₪110</span>
                                </div>
                            </label>
                        </div>
                        <div class="service-option">
                            <input type="radio" id="service3" name="service" value="עיצוב זקן">
                            <label for="service3">
                                <div class="service-icon"><i class="fas fa-hot-tub"></i></div>
                                <div class="service-info">
                                    <span class="service-name">עיצוב זקן</span>
                                    <span class="service-details">20 דקות · ₪45</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- תאריך ושעה -->
                <div class="form-section date-time-section">
                    <div class="date-selection">
                        <h3>בחר תאריך</h3>
                        <div class="calendar-container" id="calendar-container"></div>
                    </div>
                    <div class="time-selection">
                        <h3>בחר שעה</h3>
                        <div class="time-slots" id="time-slots-container"></div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="book-appointment">אשר הזמנה</button>
                </div>
            </form>
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

<script src="js/main.js"></script>
<script src="js/cart.js"></script>
<script src="js/auth.js"></script>
<script src="js/appointments.js"></script>
</body>
</html>
