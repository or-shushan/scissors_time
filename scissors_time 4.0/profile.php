<?php
session_start();
include 'components/header.php';
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone, image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?> 

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>הפרופיל שלי - Scissors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!--קישור לאייקונים של VS-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    
    <section class="profile-container" id="profile">
        
        <div class="container">
            <div class="section-header">
                <h1>הפרופיל שלי <span class="fas fa-user-circle"></span></h1>
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
                    <li class="active" data-tab="personal-info">
                        <a href="profile.php"><i class="fas fa-user"></i> פרטים אישיים</a>
                    </li>

                    <li data-tab="haircuts"> 
                        <a href="appointments-history.php"><i class="fas fa-cut"></i> התורים שלי</a>
                    </li>

                    <li data-tab="orders"> 
                        <a href="order-history.php"><i class="fas fa-shopping-bag"></i> היסטוריית הזמנות</a>
                    </li>
                    </li>


                </ul>
            </div>
           
            <!-- Main Content -->
            <div class="profile-content">
                <!-- Personal Info Tab -->
                <div class="tab-content active" id="personal-info">
                    <div class="card">
                        <div class="card-header">
                            <h3>פרטים אישיים</h3>
                            <p>עדכן את הפרטים האישיים שלך</p>
                        </div>
                        <div class="card-body">
                            <form id="personal-info-form">
                                <div class="form-grid">
                                <div class="form-group">
                                    <label for="firstName">שם פרטי</label>
                                    <input type="text" id="firstName" name="first_name"
                                    placeholder="שם פרטי"
                                    pattern="[a-z A-z א-ת]{1,10}"
                                    title="הקלד אותיות בעברית / אנגלית בלבד."
                                    value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">

                                    <p style="font-size: 0.8rem; color: grey;">אותיות בעברית / אנגלית בלבד</p>
                                </div>

                                <div class="form-group">
                                    <label for="last_Name">שם משפחה</label>
                                    <input type="text" id="lastName" name="last_name"
                                    placeholder="שם משפחה"
                                    pattern="[a-zA-zא-ת]{1,10}"
                                    title="הקלד אותיות בעברית / אנגלית בלבד."
                                    value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">

                                    <p style="font-size: 0.8rem; color: grey;">אותיות בעברית / אנגלית בלבד</p>
                                </div>

                                <div class="form-group">
                                    <label for="email">אימייל</label>
                                    <input type="email" id="email" name="email"
                                    placeholder="your@email.com"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">

                                </div>

                                <div class="form-group">
                                    <label for="phone">טלפון</label>
                                    <input type="tel" id="phone" name="phone"
                                    placeholder="050-0000000"
                                    pattern="[0-9]{10}"
                                    title="יש להזין מספרים תקינים בלבד (10 ספרות) ללא מקף"
                                    value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

                                </div>
                                <div class="form-group">
                                    <label for="password">סיסמה חדשה</label>
                                    <input type="password" id="password" name="password"
                                        placeholder="••••••••"
                                        minlength="5"
                                        title="לפחות 5 תווים">
                                </div>
                                <div class="form-group upload-wrapper">
                                    <label for="user-image" class="custom-file-upload" id="upload-label">
                                        <i class="fas fa-upload"></i> העלה תמונה
                                    </label>
                                    <input type="file" id="user-image" name="user-image" accept="image/*" />
                                    <!-- כאן יופיע שם הקובץ -->
                                    <span id="file-name" class="file-name"></span>
                                </div>
                            </div>
                                <button type="submit" class="btn">שמור שינויים</button>
                            </form>
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


    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/appointments.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/admin.js"></script>

    <script src="js/profile.js"></script>
    <script src="js/appointments-history.js"></script>
</body>
</html>