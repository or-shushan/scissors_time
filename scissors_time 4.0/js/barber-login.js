document.addEventListener('DOMContentLoaded', function () {
    const appointmentsTable = document.getElementById('appointments-table');
    const prevDayBtn = document.getElementById('prev-day');
    const nextDayBtn = document.getElementById('next-day');
    const closedDateInput = document.getElementById('closed-date');
    const addClosedDateBtn = document.getElementById('add-closed-date');
    const removeClosedDateBtn = document.getElementById('remove-closed-date');
    const closedDatesList = document.getElementById('closed-dates-list').querySelector('ul');

    let selectedDate = new Date().toISOString().split('T')[0];
    let closedDates = [];

    const calendarPicker = document.getElementById('calendar-picker');
    let flatpickrInstance = flatpickr(calendarPicker, {
        inline: true,
        locale: 'he',
        dateFormat: 'Y-m-d',
        defaultDate: selectedDate,
        disable: closedDates,
        onChange: function (selectedDates, dateStr) {
            selectedDate = dateStr;
            displayAppointments(selectedDate);
        }
    });

    function displayAppointments(date = selectedDate) {
        fetch(`get-barber-appointments.php?date=${date}`)
            .then(res => res.json())
            .then(data => {
                appointmentsTable.innerHTML = '';

                if (!data.success || !Array.isArray(data.appointments) || data.appointments.length === 0) {
                    appointmentsTable.innerHTML = '<tr><td colspan="3">אין תורים ליום זה</td></tr>';
                    return;
                }

                // מיון לפי שעה
                data.appointments.sort((a, b) => a.appointment_time.localeCompare(b.appointment_time));

                data.appointments.forEach(appt => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${appt.appointment_time.slice(0, 5)}</td>
                        <td>${appt.customer_name}</td>
                        <td>${appt.service}</td>
                    `;
                    appointmentsTable.appendChild(row);
                });
            })
            .catch(err => {
                console.error('שגיאה בטעינת תורים:', err);
                appointmentsTable.innerHTML = '<tr><td colspan="3">שגיאה בטעינת התורים</td></tr>';
            });
    }

    function displayClosedDates() {
        closedDatesList.innerHTML = '';

        if (closedDates.length === 0) {
            closedDatesList.innerHTML = '<li>אין ימים סגורים</li>';
            return;
        }

        closedDates.forEach(date => {
            const li = document.createElement('li');
            li.textContent = new Date(date).toLocaleDateString('he-IL');
            closedDatesList.appendChild(li);
        });

        if (flatpickrInstance) {
            flatpickrInstance.set('disable', closedDates);
        }
    }

    prevDayBtn.addEventListener('click', () => {
        const currentDate = new Date(selectedDate);
        currentDate.setDate(currentDate.getDate() - 1);
        selectedDate = currentDate.toISOString().split('T')[0];
        flatpickrInstance.setDate(selectedDate);
        displayAppointments(selectedDate);
    });

    nextDayBtn.addEventListener('click', () => {
        const currentDate = new Date(selectedDate);
        currentDate.setDate(currentDate.getDate() + 1);
        selectedDate = currentDate.toISOString().split('T')[0];
        flatpickrInstance.setDate(selectedDate);
        displayAppointments(selectedDate);
    });

    addClosedDateBtn.addEventListener('click', () => {
        const date = closedDateInput.value;
        if (!date || closedDates.includes(date)) return;

        closedDates.push(date);
        displayClosedDates();
        displayAppointments(selectedDate);
        closedDateInput.value = '';
    });

    removeClosedDateBtn.addEventListener('click', () => {
        const date = closedDateInput.value;
        if (!date || !closedDates.includes(date)) return;

        closedDates = closedDates.filter(d => d !== date);
        displayClosedDates();
        displayAppointments(selectedDate);
        closedDateInput.value = '';
    });

    displayAppointments();
    displayClosedDates();
});
