// Import auth core functions
import { getCurrentUser } from './auth/auth-core.js';

document.addEventListener('DOMContentLoaded', function() {
    // Check if user is admin
    const user = getCurrentUser();
    if (!user || !user.isAdmin) {
        window.location.href = 'login.html';
        return;
    }

    // Initialize date filters with current month
    initializeDateFilters();
   
    // Load initial data
    loadReportsData();
   
    // Setup event listeners
    setupEventListeners();
});

/**
 * Initialize date filters with current month
 */
function initializeDateFilters() {
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
   
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
   
    startDateInput.value = formatDate(firstDay);
    endDateInput.value = formatDate(today);
}

/**
 * Format date to YYYY-MM-DD
 */
function formatDate(date) {
    return date.toISOString().split('T')[0];
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    const filterBtn = document.getElementById('filterBtn');
    filterBtn.addEventListener('click', loadReportsData);
}

/**
 * Load reports data based on selected date range
 */
function loadReportsData() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
   
    // In a real app, this would fetch data from a server
    // For demo purposes, we'll use mock data
    const mockData = generateMockData(startDate, endDate);
   
    updateDashboard(mockData);
    initializeCharts(mockData);
}

/**
 * Generate mock data for demo purposes
 */
function generateMockData(startDate, endDate) {
    return {
        revenue: {
            total: 15750,
            trend: 12.5,
            monthly: [12000, 13500, 15750, 14800, 16200, 15750]
        },
        appointments: {
            total: 245,
            trend: 0,
            daily: [28, 32, 35, 27, 30, 33, 35]
        },
        products: {
            total: 78,
            trend: 8.3
        },
        popularServices: [
            "תספורת גברים - 85 הזמנות",
            "תספורת ועיצוב זקן - 65 הזמנות",
            "צביעת שיער - 45 הזמנות",
            "תספורת ילדים - 35 הזמנות"
        ]
    };
}

/**
 * Update dashboard with new data
 */
function updateDashboard(data) {
    // Update revenue
    document.getElementById('totalRevenue').textContent = `₪${data.revenue.total}`;
    updateTrend('revenueTrend', data.revenue.trend);
   
    // Update appointments
    document.getElementById('totalAppointments').textContent = data.appointments.total;
    updateTrend('appointmentsTrend', data.appointments.trend);
   
    // Update products
    document.getElementById('totalProducts').textContent = data.products.total;
    updateTrend('productsTrend', data.products.trend);
   
    // Update popular services
    const servicesList = document.getElementById('popularServices');
    servicesList.innerHTML = data.popularServices
        .map(service => `<li>${service}</li>`)
        .join('');
}

/**
 * Update trend indicators
 */
function updateTrend(elementId, value) {
    const element = document.getElementById(elementId);
    if (!element) return;
   
    const parent = element.closest('.report-trend');
    const icon = parent.querySelector('i');
   
    parent.className = 'report-trend ' + (value > 0 ? 'positive' : value < 0 ? 'negative' : '');
    icon.className = 'fas fa-arrow-' + (value > 0 ? 'up' : value < 0 ? 'down' : 'right');
    element.textContent = `${Math.abs(value)}%`;
}

/**
 * Initialize charts using Chart.js
 */
function initializeCharts(data) {
    // Load Chart.js from CDN
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
    script.onload = () => {
        createRevenueChart(data.revenue.monthly);
        createAppointmentsChart(data.appointments.daily);
    };
    document.head.appendChild(script);
}

/**
 * Create revenue chart
 */
function createRevenueChart(data) {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['ינואר', 'פברואר', 'מרץ', 'אפריל', 'מאי', 'יוני'],
            datasets: [{
                label: 'הכנסות חודשיות',
                data: data,
                borderColor: '#0A84FF',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

/**
 * Create appointments chart
 */
function createAppointmentsChart(data) {
    const ctx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['ראשון', 'שני', 'שלישי', 'רביעי', 'חמישי', 'שישי', 'שבת'],
            datasets: [{
                label: 'תורים יומיים',
                data: data,
                backgroundColor: '#0A84FF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}
