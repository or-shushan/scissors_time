<?php
include 'components/header.php';
include 'db.php';
session_start();

// AJAX: אם מבקשים פרטי הזמנה
if (isset($_GET['action']) && $_GET['action'] === 'get_order_details') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'משתמש לא מחובר']);
        exit;
    }

    $order_id = $_GET['order_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if (!$order_id) {
        echo json_encode(['success' => false, 'message' => 'מספר הזמנה לא סופק']);
        exit;
    }

    // שליפת פרטי ההזמנה
    $sql = "SELECT o.id, o.created_at, SUM(oi.price * oi.quantity) AS total
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            WHERE o.id = ? AND o.user_id = ?
            GROUP BY o.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'הזמנה לא נמצאה']);
        exit;
    }

    $order = $result->fetch_assoc();

    // שליפת המוצרים
    $sql_items = "SELECT p.name, oi.quantity, oi.price
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = ?";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();

    $items = [];
    while ($row = $result_items->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode([
        'success' => true,
        'order' => [
            'id' => $order['id'],
            'date' => date('d.m.Y', strtotime($order['created_at'])),
            'total' => number_format($order['total'], 2),
            'items' => $items
        ]
    ]);
    exit;
}

// --- הצגת ההזמנות לעמוד ---
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

$sql = "SELECT o.id AS order_id, o.created_at AS order_date, SUM(oi.price * oi.quantity) AS total_price,
               GROUP_CONCAT(CONCAT(oi.quantity, ' × ', p.name) SEPARATOR ', ') AS items
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>היסטוריית הזמנות - Scissors</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/order-history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

<section class="history-container" id="order-history">
    <h1 class="heading">היסטוריית הזמנות</h1>
    <div class="divider"></div>

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
    <a href="appointments-history.php"><i class="fas fa-cut"></i> התורים שלי</a>
  </li>

  <li class="active" data-tab="orders"> 
    <a href="order-history.php"><i class="fas fa-shopping-bag"></i> היסטוריית הזמנות</a>
  </li>
</ul>

            </div>

        <div class="history-grid">
            <?php if (count($orders) > 0): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="history-item">
                        <div class="history-info">
                            <h3 class="history-title">הזמנה #<?= $order['order_id'] ?></h3>
                            <div class="history-meta">
                                <div class="history-meta-item"><i class="fas fa-calendar"></i> תאריך ביצוע ההזמנה: 
                                    <?= date('d.m.Y', strtotime($order['order_date'])) ?>
                                </div> 
                                <br><div class="history-meta-item">סה"כ עלות הזמנה:  
                                  
                                    <?= number_format($order['total_price'], 2) ?> ₪
                                </div>
                            </div>
                            <div class="history-description">
                                <p><?= htmlspecialchars($order['items']) ?></p>
                            </div>
                            <span class="history-status status-completed">נשלח</span>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-shopping-bag fa-3x"></i>
                    <h4>אין לך הזמנות קודמות</h4>
                    <p>נראה שעדיין לא ביצעת הזמנות במערכת</p>
                    <a href="products.php" class="btn">צפה במוצרים</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- מודל פרטי הזמנה -->
<div id="order-details-modal" class="modal hidden">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h2>פרטי ההזמנה</h2>
        <div id="order-details-body">
            <!-- נטען דרך JS -->
        </div>
    </div>
</div>

<div class="notification" id="notification"></div>

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
<script src="js/cart.js"></script>
<script src="js/profile.js"></script>
<script src="js/order-history.js"></script>

</body>
</html>
