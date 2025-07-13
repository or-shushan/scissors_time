<?php 
include 'components/header.php';
include 'db.php';
include 'session.php';

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>מוצרים - SCISSORS TIME</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/products.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Products Hero -->
<section class="products-hero">
  <div class="container">
    <div class="section-header">
      <h1>מוצרי הפרימיום שלנו</h1>
      <div class="divider"></div>
      <p>גלו את אוסף מוצרי השיער והזקן האיכותיים שלנו לשמירה על המראה המושלם בין הביקורים.</p>
    </div>
  </div>
</section>

<!-- Products Filter -->
<section class="products-filter">
  <div class="container">
    <div class="filter-container">
      <div class="search-box">
        <i class="fas fa-search" area-label="חיפוש מוצרים" role="img"></i>
        <input type="text" id="product-search" placeholder="חיפוש מוצרים...">
      </div>
      <div class="category-filters">
        <button class="btn btn-filter active" data-category="all">הכל</button>
        <button class="btn btn-filter" data-category="עיצוב">עיצוב</button>
        <button class="btn btn-filter" data-category="טיפוח זקן">טיפוח זקן</button>
        <button class="btn btn-filter" data-category="גילוח">גילוח</button>
        <button class="btn btn-filter" data-category="כלים">כלים</button>
      </div>
    </div>
  </div>
</section>

<!-- Products Grid -->
<section class="products-grid">
  <div class="container">
    <div class="products-container" id="products-container">
      <?php while($product = $products->fetch_assoc()): ?>
        <div class="product-card" data-category="<?php echo htmlspecialchars($product['category']); ?>">
          <div class="product-image">
          <img class="placeholder-img" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
          </div>
          <div class="product-info">
            <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="product-price">₪<?php echo number_format($product['price'], 2); ?></p>
            <div class="product-price-action">
              <label for="quantity-<?php echo $product['id']; ?>">כמות:</label>
              <input type="number" id="quantity-<?php echo $product['id']; ?>" value="1" min="1" style="width: 60px;">
            </div>
            <div class="product-price-action">
              <button class="btn-add-cart btn btn-primary btn-add-to-cart" data-product-id="<?php echo $product['id']; ?>">הוסף לעגלה</button>
              <button class="quick-view-btn"
                      data-id="<?php echo $product['id']; ?>"
                      data-name="<?php echo htmlspecialchars($product['name']); ?>"
                      data-description="<?php echo htmlspecialchars($product['description']); ?>"
                      data-image="<?php echo htmlspecialchars($product['image']); ?>"
                      data-price="<?php echo $product['price']; ?>">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
  <div class="container">
    <div class="section-header">
      <h2>למה כדאי לכם לבחור במוצרים שלנו?</h2>
      <div class="divider"></div>
      <p>אנו בוחרים בקפידה רק את המוצרים הטובים ביותר שאנו משתמשים בהם במספרה שלנו.</p>
    </div>
    <div class="benefits-container">
      <div class="benefit-card">
        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
        <h3>איכות מעולה</h3>
        <p>כל המוצרים הם ברמה מקצועית, משמשים את הספרים שלנו מדי יום.</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><i class="fas fa-award"></i></div>
        <h3>בחירת מומחים</h3>
        <p>נבחרו בקפידה על ידי הספרים המומחים שלנו להבטחת יעילות.</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><i class="fas fa-gem"></i></div>
        <h3>מוצרים בלעדיים</h3>
        <p>גישה למוצרים מיוחדים שאינם זמינים במקומות אחרים.</p>
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
</body>
</html>
