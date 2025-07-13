document.addEventListener('DOMContentLoaded', function () {
    fetchAppointmentsFromServer();
});

function fetchAppointmentsFromServer() {
    fetch('api/book-appointment.php') // נקרא לקובץ PHP שמחזיר JSON
        .then(response => response.json())
        .then(data => {
            if (data.success && data.appointments.length > 0) {
                renderAppointments(data.appointments);
            } else {
                showEmptyState();
            }
        })
        .catch(error => {
            console.error('שגיאה בטעינת התורים:', error);
            showEmptyState();
        });
}

function renderAppointments(appointments) {
    const container = document.querySelector('.appointments-list');
    if (!container) return;

    container.innerHTML = ''; // ניקוי קודם

    appointments.forEach(appointment => {
        const item = document.createElement('div');
        item.classList.add('history-item');

        item.innerHTML = `
            <div class="history-info">
                <h4 class="history-title">${appointment.barber_name}</h4>
                <div class="history-meta">
                    <div class="history-meta-item"><i class="fas fa-calendar-alt"></i> ${appointment.appointment_date}</div>
                    <div class="history-meta-item"><i class="fas fa-clock"></i> ${appointment.appointment_time}</div>
                    <div class="history-meta-item"><i class="fas fa-star"></i> ${appointment.service}</div>
                </div>
                <div class="history-status status-${appointment.status || 'upcoming'}">${getStatusText(appointment.status)}</div>
            </div>
            <div class="history-actions">
                <button class="cancel-btn">בטל</button>
                <button class="reschedule-btn">שנה</button>
            </div>
        `;

        // אירועים
        item.querySelector('.cancel-btn').addEventListener('click', function () {
            if (confirm(`האם אתה בטוח שברצונך לבטל את התור אצל ${appointment.barber_name}?`)) {
                cancelAppointment(appointment.id, item);
            }
        });

        item.querySelector('.reschedule-btn').addEventListener('click', function () {
            window.location.href = 'appointments.php';
        });

        container.appendChild(item);
    });

    document.querySelector('.empty-state')?.classList.add('hidden');
}

function cancelAppointment(appointmentId, element) {
    fetch('cancel-appointment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: appointmentId })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('התור בוטל בהצלחה', 'success');
                element.querySelector('.history-status').textContent = 'בוטל';
                element.querySelector('.history-status').className = 'history-status status-cancelled';
                element.querySelector('.cancel-btn').textContent = 'קבע תור דומה';
                element.querySelector('.reschedule-btn').style.display = 'none';
            } else {
                showNotification('שגיאה בביטול התור', 'error');
            }
        });
}

function showEmptyState() {
    document.querySelector('.appointments-list')?.classList.add('hidden');
    document.querySelector('.empty-state')?.classList.remove('hidden');
}

function showNotification(message, type = '') {
    const notification = document.getElementById('notification');
    if (!notification) return;

    notification.textContent = message;
    notification.className = 'notification';
    if (type) notification.classList.add(type);
    notification.classList.add('active');

    setTimeout(() => notification.classList.remove('active'), 3000);
}

function getStatusText(status) {
    switch (status) {
        case 'completed': return 'הושלם';
        case 'cancelled': return 'בוטל';
        default: return 'קרוב';
    }
}
