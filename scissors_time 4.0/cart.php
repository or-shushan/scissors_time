<?php
session_start();
include 'components/header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('אנא התחבר כדי לצפות בעגלה שלך'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT ci.id, ci.quantity, p.name, p.image, p.price 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;
$total_items = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
    $total_items += $row['quantity'];
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>עגלת קניות - SCISSORS TIME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Cart Section -->
<section class="cart-section">
    <div class="container">
        <div class="section-header">
            <h1>עגלת קניות <span class="fas fa-shopping-cart"></span></h1>
            <div class="divider"></div>
            <p>פריטים שנוספו לעגלת הקניות שלך</p>
        </div>
        
        <div class="cart-container">
            <div class="cart-items" id="cart-items">
            <?php if (count($cart_items) === 0): ?>
                <div class="empty-cart" id="empty-cart-message">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>העגלה שלך ריקה</h3>
                    <p>נראה שעדיין לא הוספת פריטים לעגלה שלך</p>
                    <a href="products.php" class="btn btn-primary">התחל לקנות</a>
                </div>
            <?php else: ?>
                <?php foreach ($cart_items as $index => $item): ?>
                <div class="cart-item" data-item-id="<?php echo $item['id']; ?>">
                    <div class="cart-item-number">
                        <span class="item-number"><?php echo $index + 1; ?></span>
                    </div>
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--border-radius); margin-left: 1rem;">
                    <div class="cart-item-info">
                        <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="cart-item-price">מחיר ליחידה: ₪<?php echo number_format($item['price'], 2); ?></div>
                        <div class="cart-item-price">סה"כ: ₪<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>

                        <div class="cart-item-actions">
                            <div class="item-quantity">
                                <button class="qty-btn decrease-btn" data-id="<?php echo $item['id']; ?>">−</button>
                                <input type="text" class="qty-input" value="<?php echo $item['quantity']; ?>" readonly>
                                <button class="qty-btn increase-btn" data-id="<?php echo $item['id']; ?>">+</button>
                            </div>
                            <button class="remove-item" data-id="<?php echo $item['id']; ?>">הסר</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
            
            <div class="cart-summary" id="cart-summary">
                <h3>סיכום הזמנה</h3>
                
                <div class="summary-details">
                    <div class="summary-row">
                        <span>סה"כ פריטים:</span>
                        <span id="items-count"><?php echo $total_items; ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>סה"כ לתשלום:</span>
                        <span id="total">₪<?php echo number_format($total_price, 2); ?></span>
                    </div>
                </div>
                
                <button class="btn btn-primary checkout-btn" id="checkout-btn">המשך לתשלום</button>
                <a href="products.php" class="btn btn-outline continue-shopping-btn">המשך לקנות</a>
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

<!-- Thank You Modal -->
<div id="thankyou-modal" class="modal-overlay" style="display:none;">
  <div class="product-modal">
    <button class="modal-close" id="close-thankyou"><i class="fas fa-times"></i></button>
    <div class="modal-content">
      <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
      <h2>תודה על ההזמנה!</h2>
      <p>ההזמנה שלך נקלטה בהצלחה ותטופל בהקדם.</p>
      <a href="index.php" class="btn btn-primary" style="margin-top: 1.5rem;">חזרה לדף הבית</a>
    </div>
  </div>
</div>

<script src="js/main.js"></script>
<script src="js/cart.js"></script>
<script src="js/auth.js"></script>
<script src="js/products.js"></script>
<script src="js/appointments-history.js"></script>

</body>
</html>
