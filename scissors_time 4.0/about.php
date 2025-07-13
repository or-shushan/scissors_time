<?php include 'components/header.php'; ?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABOUT - SCISSORS TIME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!--קישור לאייקונים של VS-->
    <link rel="stylesheet" href="css/about.css">
</head>
<body>


    <!-- About Section -->
    <section class="about">
        <div class="container">
            <div class="section-header">
                <h2>אודות</h2>
                <div class="divider"></div>
                <p> אפליקצייה לניהול מספרות אשר מטרתה לתכלל את כלל הפעילות השוטפת במספרה (זימון תורים ועד תיק לקוח) הכוללת אפשרות לתשלום מקוון ורכישת מוצרים נלווים.</p> <br>
                <p style="font-size: 0.9rem;"> <strong> גרסת המערכת: 1.1 </strong></p>
                    <hr style="width: 20%; border: 0; border-top: 1px solid gray; margin: 20px auto;">
                    <p style="font-size: 0.85rem; "> <span style="text-decoration: underline;"> <strong>שינויים שבוצעו: </strong> </span><br>
                        1.	הוספת עמוד פרופיל לקוח וקישורו למערכת. <br>
                        2.	הוספת עמודי היסטוריית תורים והיסטוריית הזמנות ללקוח. <br>
                        3.	הוספת שם משתמש בכותרת לאחר התחברות / הרשמה.  <br>
                        4.	עמוד מוצרים – הוספת התמונה של המוצר ב quick view באופן אוטומטי. <br>
                        5.	הוספת הודעה על הוספת מוצר לעגלת הקניות. <br>
                        6. הוספת עמוד דוחות. <br>
                        7. הוספת אפשרות להעלאת תמונה בעמוד פרופיל. <br>
                        8. הוספת עמוד מנהל - הכולל אפשרות לניהול משתמשים והוספת מוצרים (כולל קישורם לעמוד מוצרים) <br>
                        9. הוספת עמוד כניסת ספר.
                        </p>
                    
                </p> <br>
                <h3 style="font-size: 1.5rem;">הכירו את משתתפי הפרוייקט:</h3>
                <div class="divider"></div>
                
            </div>
            <div class="team-grid">
                <!-- Team Member 1 -->
                <div class="team-member">
                    <div class="team-img">
                        <img src="picturs/ran.jpg" alt="רן ברסימנטוב" class="member-img">
                    </div>
                    <h3>רן ברסימנטוב</h3>
                    <p> <span style="text-decoration: underline;">תפקיד בפרוייקט:</span> מאפיין ומפתח המערכת</p>
                    <p>פרטי קשר: <a href="mailto:ran@example.com">050-4380020</a></p>
                </div>
                <!-- Team Member 2 -->
                <div class="team-member">
                    <div class="team-img">
                        <img src="picturs/or.JPG" alt="אור שושן" class="member-img">
                    </div>
                    <h3>אור שושן</h3>
                    <p> <span style="text-decoration: underline;">תפקיד בפרוייקט:</span> מאפיין ומפתח המערכת</p>
                    <p>פרטי קשר: <a href="mailto:or@example.com">052-6606261</a></p>
                </div>
                <!-- Team Member 3 -->
                <div class="team-member">
                    <div class="team-img">
                        <img src="picturs/lior.jpg" alt="ליאור טקצ'נקו" class="member-img">
                    </div>
                    <h3>ליאור טקצ'נקו</h3>
                    <p> <span style="text-decoration: underline;">תפקיד בפרוייקט:</span> מאפיין ומפתח המערכת</p>
                    <p>פרטי קשר: <a href="mailto:lior@example.com">052-8133987</a></p>
                </div>
                <!-- Team Member 4 -->
                <div class="team-member">
                    <div class="team-img">
                        <img src="picturs/akalo.jpg" alt="נגוסו אקלו" class="member-img">
                    </div>
                    <h3>נגוסו אקלו</h3>
                    <p> <span style="text-decoration: underline;">תפקיד בפרוייקט:</span> מאפיין ומפתח המערכת</p>
                    <p>פרטי קשר: <a href="mailto:neguso@example.com">054-3164202</a></p>
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
                        <li><a href="about.html">אודות</a></li>
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
    <script src="js/appointments-history.js"></script>
</body>
</html>