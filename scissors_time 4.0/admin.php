<?php
include 'components/header.php';
include 'db.php';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>עמוד מנהל - SCISSORS TIME</title>
 <link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/admin-users.css?v=1"> <!--?v=1 - החלק הזה אחראי על ניקוי מטמון באתר -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<section class="admin-section">
  <div class="container">
    <div class="section-header">
      <h1>עמוד מנהל <span class="fas fa-user-shield"></span></h1>
      <div class="divider"></div>
      <p>נהל משתמשים, מוצרים, והפק דוחות עבור העסק שלך</p>
    </div>
    
    <!-- Tabs Navigation -->
    <div class="admin-tabs">
      <button class="tab-btn active" data-tab="users">ניהול משתמשים</button>
      <button class="tab-btn" data-tab="products">ניהול מוצרים</button>
      <button class="tab-btn" data-tab="reports">דוחות</button>
    </div>

    <!-- ניהול משתמשים -->
    <div class="tab-content" id="users">
    <h2>ניהול משתמשים</h2>

<button id="open-add-user-modal" class="add-user-btn">➕ הוסף משתמש חדש</button>
<div class="modal-overlay" id="add-user-modal">
  <div class="product-modal">
    <button type="button" class="modal-close" id="close-add-modal">&times;</button>
    <h3>הוספת משתמש חדש</h3>
    <form id="add-user-form" class="admin-form">
      <div class="form-group">
        <label for="add-fname">שם פרטי</label>
        <input type="text" name="first_name" id="add-fname" required>
      </div>
      <div class="form-group">
        <label for="add-lname">שם משפחה</label>
        <input type="text" name="last_name" id="add-lname">
      </div>
      <div class="form-group">
        <label for="add-email">אימייל</label>
        <input type="email" name="email" id="add-email" required>
      </div>
      <div class="form-group">
        <label for="add-phone">טלפון</label>
        <input type="text" name="phone" id="add-phone">
      </div>
      <div class="form-group">
        <label for="add-role">הרשאה</label>
        <select name="role" id="add-role" required>
          <option value="">בחר הרשאה</option>
          <option value="מנהל">מנהל</option>
          <option value="ספר">ספר</option>
          <option value="לקוח">לקוח</option>
        </select>
      </div>
      <div class="form-group">
        <label for="add-password">סיסמה</label>
        <input type="password" name="password" id="add-password" required>
      </div>
      <button type="submit" class="save-btn">צור משתמש</button>
    </form>
  </div>
</div>

      <div class="search-box" style="margin-bottom: 1.5rem;">
        <input type="text" id="user-search" placeholder="חפש משתמש לפי שם...">
        <i class="fas fa-search"></i>
      </div>
      <table class="admin-table">
        <thead>
          <tr>
            <th>שם משתמש</th>
            <th>אימייל</th>
            <th>מספר פלאפון</th>
            <th>הרשאה</th>
            <th>פעולות</th>
          </tr>
        </thead>
        <tbody id="users-table"></tbody>
      </table>

      <!-- Modal לעדכון משתמש -->
      <div class="modal-overlay" id="editModal" style="display: none;">
        <div class="product-modal">
          <button type="button" class="modal-close" id="close-modal">&times;</button>
          <h3>עריכת משתמש</h3>
          <form id="edit-form" class="admin-form">
            <input type="hidden" name="id" id="edit-id">

            <div class="form-group">
              <label for="edit-fname">שם פרטי</label>
              <input type="text" name="first_name" id="edit-fname" required>
            </div>

            <div class="form-group">
              <label for="edit-lname">שם משפחה</label>
              <input type="text" name="last_name" id="edit-lname">
            </div>

            <div class="form-group">
              <label for="edit-email">אימייל</label>
              <input type="email" name="email" id="edit-email" required>
            </div>

            <div class="form-group">
              <label for="edit-phone">טלפון</label>
              <input type="text" name="phone" id="edit-phone">
            </div>

            <div class="form-group">
              <label for="edit-role">הרשאה</label>
              <select name="role" id="edit-role">
                <option value="לקוח">לקוח</option>
                <option value="ספר">ספר</option>
                <option value="מנהל">מנהל</option>
              </select>
            </div>

            <div class="form-group">
              <label for="edit-password">סיסמה חדשה</label>
              <input type="password" name="password" id="edit-password" placeholder="(לא חובה)">
            </div>

            <button type="submit" class="btn btn-primary">שמור</button>
          </form>
        </div>
      </div>
    </div>

    <!-- ניהול מוצרים -->
    <div class="tab-content" id="products" style="display: none;">
      <h2>ניהול מוצרים</h2>
      <button class="btn btn-primary" id="add-product-btn">הוסף מוצר חדש</button>
      <table class="admin-table">
        <thead>
          <tr>
            <th>תמונה</th>
            <th>שם המוצר</th>
            <th>קטגוריה</th>
            <th>מחיר</th>
            <th>תיאור</th>
            <th>מלאי זמין</th>
            <th>פעולות</th>
          </tr>
        </thead>
        <tbody id="products-table"></tbody>
      </table>
    </div>

    <!-- הוספת משתמש חדש -->
    <div class="tab-content" id="new-user" style="display: none;">
      <h2>הוספת משתמש חדש</h2>
      <form id="new-user-form" class="admin-form">
        <div class="form-group">
          <label for="user-Fname">שם פרטי</label>
          <input type="text" id="user-Fname" required>
        </div>
        <div class="form-group">
          <label for="user-Lname">שם משפחה</label>
          <input type="text" id="user-Lname" required>
        </div>
        <div class="form-group">
          <label for="user-email">אימייל</label>
          <input type="email" id="user-email" required>
        </div>
        <div class="form-group">
          <label for="user-phone">מספר פלאפון</label>
          <input type="tel" id="user-phone" required>
        </div>
        <div class="form-group">
          <label for="user-password">סיסמה</label>
          <input type="password" id="user-password" required>
        </div>
        <div class="form-group">
          <label for="user-role">הרשאה</label>
          <select id="user-role">
            <option value="admin">מנהל</option>
            <option value="barber">ספר</option>
            <option value="customer">לקוח</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">צור משתמש</button>
      </form>
    </div>

    <!-- דוחות -->
    <div class="tab-content" id="reports" style="display: none;">
      <h2>דוחות</h2>
      <p>צפה והפק דוחות מפורטים על פעילות המספרה.</p>
      <a href="admin-reports.html" class="btn btn-primary">עבור לעמוד הדוחות</a>
    </div>
  </div>
</section>


<!-- footer -->
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
<script src="js/admin.js"></script>
<script src="js/admin-users.js"></script>
<script src="js/admin-products.js"></script>


</body>
</html>
