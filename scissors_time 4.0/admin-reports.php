<?php include 'components/header.php'; ?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>דוחות מנהל - Scissors</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin-reports.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header --> 
    <header class="header">
        <div class="container1">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">SCISSORS <span class="fas fa-scissors"></span> TIME</a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="about.html">אודות</a></li>
                        <li><a href="index.php">דף הבית</a></li>
                        <li><a href="appointments.php">הזמן תור</a></li>
                        <li><a href="products.php">מוצרים</a></li>
                        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li>
                    </ul>
                </nav>
                <div class="auth-buttons">
                    <a href="login.php" class="btn btn-primary">התחברות</a>
                    <a href="register.php" class="btn btn-primary">הרשמה</a>
                </div>
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="profile-container" id="profile">
        <div class="container">
            <!-- Header Section -->
            <header class="reports-header">
                <h1>דוחות מנהל מערכת</h1>
                <div class="date-filter">
                    <label for="startDate">מתאריך:</label>
                    <input type="date" id="startDate">
                    <label for="endDate">עד תאריך:</label>
                    <input type="date" id="endDate">
                    <button class="btn btn-primary" id="filterBtn">סנן</button>
                    <div class="report-type-dropdown">
                        <button class="btn btn-primary" id="reportTypeBtn">בחר סוג דוח <i class="fas fa-chevron-down"></i></button>
                        <div class="dropdown-content" id="reportTypeDropdown">
                            <ul class="report-type-list">
                                <li><a href="#" data-report="all" onclick="filterReportType('all'); document.getElementById('reportTypeDropdown').style.display='none';">כל הדוחות</a></li>
                                <li><a href="#" data-report="revenue" onclick="filterReportType('revenue'); document.getElementById('reportTypeDropdown').style.display='none';">הכנסות</a></li>
                                <li><a href="#" data-report="appointments" onclick="filterReportType('appointments'); document.getElementById('reportTypeDropdown').style.display='none';">תורים</a></li>
                                <li><a href="#" data-report="products" onclick="filterReportType('products'); document.getElementById('reportTypeDropdown').style.display='none';">מוצרים</a></li>
                                <li><a href="#" data-report="services" onclick="filterReportType('services'); document.getElementById('reportTypeDropdown').style.display='none';">שירותים פופולריים</a></li>
                                <li><a href="#" data-report="inventory" onclick="filterReportType('inventory'); document.getElementById('reportTypeDropdown').style.display='none';"> מלאי</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Reports Grid -->
            <div class="reports-grid">
                <!-- Revenue Card -->
                <div class="report-card" data-report="revenue">
                    <div class="report-header">
                        <h3>הכנסות</h3>
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-number" id="totalRevenue">₪0</div>
                        <div class="report-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span id="revenueTrend">0%</span>
                        </div>
                    </div>
                </div>

                <!-- Appointments Card -->
                <div class="report-card" data-report="appointments">
                    <div class="report-header">
                        <h3>תורים</h3>
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-number" id="totalAppointments">0</div>
                        <div class="report-trend" id="appointmentsTrend">
                            <i class="fas fa-arrow-right"></i>
                            <span>0%</span>
                        </div>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="report-card" data-report="products">
                    <div class="report-header">
                        <h3>מוצרים שנמכרו</h3>
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-number" id="totalProducts">0</div>
                        <div class="report-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span id="productsTrend">0%</span>
                        </div>
                    </div>
                </div>

                <!-- Services Card -->
                <div class="report-card" data-report="services">
                    <div class="report-header">
                        <h3>שירותים פופולריים</h3>
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="report-content">
                        <ul class="services-list" id="popularServices">
                            <li>טוען נתונים...</li>
                        </ul>
                    </div>
                </div>
            </div>
                            <!-- inventory Card -->
                            <div class="report-card" data-report="inventory">
                                <div class="report-header">
                                    <h3>מלאי</h3>
                                    <i class="fas fa-file-excel"></i>
                                </div>
                                <div class="report-content">
                                    <div class="report-number" id="totalinventory">נתונים בטעינה...</div>

                                    <input type="button"  class="btn btn-primary" value="הפק דוח">
                                    </div>
                                </div>
                            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-container" data-report="revenue">
                    <h3>הכנסות לפי חודש</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="chart-container" data-report="appointments">
                    <h3>תורים לפי יום</h3>
                    <canvas id="appointmentsChart"></canvas>
                </div>
            </div>

            <!-- Notification Element -->
            <div id="notification" class="notification"></div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/appointments.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/profile.js"></script>
    <script src="js/appointments-history.js"></script>
    <script src="js/admin-reports.js" type="module" defer></script>
    <script>
        // Minimal JavaScript for dropdown and report type filtering
        function filterReportType(reportType) {
            const reportCards = document.querySelectorAll('.report-card');
            const chartContainers = document.querySelectorAll('.chart-container');

            reportCards.forEach(card => {
                card.style.display = (reportType === 'all' || card.dataset.report === reportType) ? 'block' : 'none';
            });

            chartContainers.forEach(chart => {
                chart.style.display = (reportType === 'all' || chart.dataset.report === reportType) ? 'block' : 'none';
            });
        }

        document.getElementById('reportTypeBtn').addEventListener('click', () => {
            const dropdown = document.getElementById('reportTypeDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (event) => {
            const dropdown = document.getElementById('reportTypeDropdown');
            const button = document.getElementById('reportTypeBtn');
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>