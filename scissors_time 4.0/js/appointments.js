
document.addEventListener('DOMContentLoaded', function() {
    // Calendar functionality
    const calendarContainer = document.getElementById('calendar-container');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const appointmentForm = document.getElementById('appointment-form');
    
    // If not on appointment page, return
    if (!calendarContainer) return;
    
    // Initialize calendar
    initCalendar();
    
    // Initialize time slots
    initTimeSlots();
    
    // Handle form submission
if (appointmentForm) {
  appointmentForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const selectedBarber = document.querySelector('input[name="barber"]:checked');
    const selectedService = document.querySelector('input[name="service"]:checked');
    const selectedDate = calendarContainer.getAttribute('data-selected-date');
    const selectedTime = document.querySelector('.time-slot.selected');

    if (!selectedBarber || !selectedService || !selectedDate || !selectedTime) {
      showNotification('אנא מלא את כל פרטי ההזמנה', 'error');
      return;
    }

    const formData = new FormData();
    formData.append('barber', selectedBarber.value);
    formData.append('service', selectedService.value);
    formData.append('date', selectedDate);
    formData.append('time', selectedTime.textContent);

    fetch('api/book-appointment.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if (result.success) {
          showNotification(`התור נקבע בהצלחה עם ${selectedBarber.value} בתאריך ${selectedDate} בשעה ${selectedTime.textContent}`, 'success');
          appointmentForm.reset();
          resetCalendar();
          resetTimeSlots();
        } else {
          showNotification(result.message || 'שגיאה בקביעת תור', 'error');
        }
      })
      .catch(() => {
        showNotification('שגיאה בתקשורת עם השרת', 'error');
      });
  });
}
    
    // Initialize calendar
    function initCalendar() {
      // Create calendar header
      const calendarHeader = document.createElement('div');
      calendarHeader.className = 'calendar-header';
      
      const currentDate = new Date();
      const currentMonth = currentDate.getMonth();
      const currentYear = currentDate.getFullYear();
      
      // Set calendar data attributes
      calendarContainer.setAttribute('data-month', currentMonth);
      calendarContainer.setAttribute('data-year', currentYear);
      
      // Create month and year display
      const monthYearDisplay = document.createElement('div');
      monthYearDisplay.className = 'month-year';
      monthYearDisplay.textContent = getMonthName(currentMonth) + ' ' + currentYear;
      
      // Create navigation buttons
      const prevBtn = document.createElement('button');
      prevBtn.className = 'calendar-nav prev';
      prevBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
      prevBtn.addEventListener('click', function() {
        navigateMonth(-1);
      });
      
      const nextBtn = document.createElement('button');
      nextBtn.className = 'calendar-nav next';
      nextBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
      nextBtn.addEventListener('click', function() {
        navigateMonth(1);
      });
      
      // Append header elements
      calendarHeader.appendChild(prevBtn);
      calendarHeader.appendChild(monthYearDisplay);
      calendarHeader.appendChild(nextBtn);
      
      calendarContainer.appendChild(calendarHeader);
      
      // Create calendar grid
      createCalendarGrid(currentYear, currentMonth);
      
      // Add calendar styles
      const calendarStyle = document.createElement('style');
      calendarStyle.textContent = `
        .calendar-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 1rem;
        }
        
        .calendar-nav {
          background: none;
          border: none;
          font-size: 1.25rem;
          cursor: pointer;
          color: var(--gray-color);
          width: 30px;
          height: 30px;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: var(--transition);
        }
        
        .calendar-nav:hover {
          color: var(--primary-color);
        }
        
        .month-year {
          font-weight: 500;
          font-size: 1.125rem;
        }
        
        .calendar-grid {
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          gap: 0.5rem;
        }
        
        .calendar-day-header {
          text-align: center;
          font-weight: 500;
          font-size: 0.875rem;
          padding: 0.5rem 0;
        }
        
        .calendar-day {
          text-align: center;
          padding: 0.5rem;
          border-radius: 50%;
          cursor: pointer;
          transition: var(--transition);
        }
        
        .calendar-day:hover:not(.disabled) {
          background-color: rgba(59, 130, 246, 0.1);
        }
        
        .calendar-day.today {
          font-weight: 700;
          border: 1px dashed var(--primary-color);
        }
        
        .calendar-day.selected {
          background-color: var(--primary-color);
          color: white;
        }
        
        .calendar-day.disabled {
          opacity: 0.3;
          cursor: not-allowed;
        }
        
        .calendar-day.empty {
          pointer-events: none;
        }
      `;
      document.head.appendChild(calendarStyle);
    }
    
    // Create calendar grid for given month and year
    function createCalendarGrid(year, month) {
      // Remove previous grid if exists
      const existingGrid = calendarContainer.querySelector('.calendar-grid');
      if (existingGrid) {
        existingGrid.remove();
      }
      
      const grid = document.createElement('div');
      grid.className = 'calendar-grid';
      
      // Add day headers
      const daysOfWeek = ['א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ש'];
      
      daysOfWeek.forEach(day => {
        const dayHeader = document.createElement('div');
        dayHeader.className = 'calendar-day-header';
        dayHeader.textContent = day;
        grid.appendChild(dayHeader);
      });
      
      // Get first day of month and number of days
      const firstDayOfMonth = new Date(year, month, 1);
      const lastDayOfMonth = new Date(year, month + 1, 0);
      const numDays = lastDayOfMonth.getDate();
      
      // Get day of week index (0 is Sunday in JS but Sunday is the last day in Hebrew calendar)
      let startDay = firstDayOfMonth.getDay();
      startDay = startDay === 0 ? 6 : startDay - 1; // Adjust for Hebrew calendar (0 = Sunday, 6 = Saturday)
      
      // Add empty cells for days before the first of the month
      for (let i = 0; i < startDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day empty';
        grid.appendChild(emptyDay);
      }
      
      // Add days of the month
      const today = new Date();
      const currentDateString = formatDate(today);
      
      for (let day = 1; day <= numDays; day++) {
        const date = new Date(year, month, day);
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;
        
        // Check if date is in the past or is Saturday (day 0)
        const isPast = date < new Date(today.setHours(0, 0, 0, 0));
        const isSaturday = date.getDay() === 0; // Saturday
        
        if (isPast || isSaturday) {
          dayElement.classList.add('disabled');
        } else {
          // Add date attribute
          const dateString = formatDate(date);
          dayElement.setAttribute('data-date', dateString);
          
          // Check if it's today
          if (dateString === currentDateString) {
            dayElement.classList.add('today');
          }
          
          // Add click event
          dayElement.addEventListener('click', function() {
            selectDate(this);
          });
        }
        
        grid.appendChild(dayElement);
      }
      
      calendarContainer.appendChild(grid);
    }
    
    // Handle navigation between months
    function navigateMonth(direction) {
      let month = parseInt(calendarContainer.getAttribute('data-month'));
      let year = parseInt(calendarContainer.getAttribute('data-year'));
      
      month += direction;
      
      // Adjust year if needed
      if (month < 0) {
        month = 11;
        year--;
      } else if (month > 11) {
        month = 0;
        year++;
      }
      
      // Update calendar attributes
      calendarContainer.setAttribute('data-month', month);
      calendarContainer.setAttribute('data-year', year);
      
      // Update month year display
      const monthYearDisplay = calendarContainer.querySelector('.month-year');
      monthYearDisplay.textContent = getMonthName(month) + ' ' + year;
      
      // Recreate calendar grid
      createCalendarGrid(year, month);
      
      // Reset time slots when changing month
      resetTimeSlots();
    }
    
    // Select a date
    function selectDate(dateElement) {
      // Remove selected class from all dates
      const allDates = calendarContainer.querySelectorAll('.calendar-day');
      allDates.forEach(date => date.classList.remove('selected'));
      
      // Add selected class to clicked date
      dateElement.classList.add('selected');
      
      // Store selected date
      const selectedDate = dateElement.getAttribute('data-date');
      calendarContainer.setAttribute('data-selected-date', selectedDate);
      
      // Generate time slots for the selected date
      generateTimeSlots();
    }
    
    // Initialize time slots
    function initTimeSlots() {
      // Add time slots styles
      const timeSlotsStyle = document.createElement('style');
      timeSlotsStyle.textContent = `
        .time-slots {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
          gap: 0.5rem;
        }
        
        .time-slot {
          text-align: center;
          padding: 0.5rem;
          border-radius: var(--border-radius);
          background-color: var(--light-color);
          cursor: pointer;
          transition: var(--transition);
        }
        
        .time-slot:hover:not(.disabled) {
          background-color: rgba(59, 130, 246, 0.1);
        }
        
        .time-slot.selected {
          background-color: var(--primary-color);
          color: white;
        }
        
        .time-slot.disabled {
          opacity: 0.5;
          cursor: not-allowed;
        }
        
        .time-slots-message {
          grid-column: 1 / -1;
          text-align: center;
          padding: 2rem;
          color: var(--gray-color);
        }
      `;
      document.head.appendChild(timeSlotsStyle);
      
      // Add initial message
      const message = document.createElement('div');
      message.className = 'time-slots-message';
      message.textContent = 'אנא בחר תאריך לראות שעות זמינות';
      timeSlotsContainer.appendChild(message);
    }
    
    // Generate time slots for selected date
    function generateTimeSlots() {
      // Clear previous time slots
      timeSlotsContainer.innerHTML = '';
      
      // Generate time slots (9:00 AM to 7:00 PM, 30 min intervals)
      const startHour = 9;
      const endHour = 19;
      
      for (let hour = startHour; hour <= endHour; hour++) {
        // Full hour slot
        createTimeSlot(`${hour}:00`);
        
        // Half hour slot (except for last hour)
        if (hour < endHour) {
          createTimeSlot(`${hour}:30`);
        }
      }
    }
    
    // Create a single time slot
    function createTimeSlot(time) {
      const timeSlot = document.createElement('div');
      timeSlot.className = 'time-slot';
      
      // Format the time for display (9:00 => 09:00)
      const [hours, minutes] = time.split(':');
      const formattedTime = `${hours.padStart(2, '0')}:${minutes}`;
      timeSlot.textContent = formattedTime;
      
      // Randomly disable some slots to simulate unavailable times
      if (Math.random() < 0.3) {
        timeSlot.classList.add('disabled');
      } else {
        timeSlot.addEventListener('click', function() {
          selectTimeSlot(this);
        });
      }
      
      timeSlotsContainer.appendChild(timeSlot);
    }
    
    // Select a time slot
    function selectTimeSlot(timeSlotElement) {
      // Remove selected class from all time slots
      const allTimeSlots = timeSlotsContainer.querySelectorAll('.time-slot');
      allTimeSlots.forEach(slot => slot.classList.remove('selected'));
      
      // Add selected class to clicked time slot
      timeSlotElement.classList.add('selected');
    }
    
    // Reset calendar selection
    function resetCalendar() {
      const allDates = calendarContainer.querySelectorAll('.calendar-day');
      allDates.forEach(date => date.classList.remove('selected'));
      calendarContainer.removeAttribute('data-selected-date');
    }
    
    // Reset time slots
    function resetTimeSlots() {
      timeSlotsContainer.innerHTML = '';
      const message = document.createElement('div');
      message.className = 'time-slots-message';
      message.textContent = 'אנא בחר תאריך לראות שעות זמינות';
      timeSlotsContainer.appendChild(message);
    }
    
    // Helper Functions
    
    // Get month name in Hebrew
    function getMonthName(monthIndex) {
      const months = [
        'ינואר', 'פברואר', 'מרץ', 'אפריל', 'מאי', 'יוני',
        'יולי', 'אוגוסט', 'ספטמבר', 'אוקטובר', 'נובמבר', 'דצמבר'
      ];
      return months[monthIndex];
    }
    
    // Format date as YYYY-MM-DD
    function formatDate(date) {
      const year = date.getFullYear();
      const month = (date.getMonth() + 1).toString().padStart(2, '0');
      const day = date.getDate().toString().padStart(2, '0');
      return `${year}-${month}-${day}`;
    }
    
    // Show notification
    function showNotification(message, type = 'info') {
      // Create notification element if it doesn't exist
      let notification = document.querySelector('.notification');
      
      if (!notification) {
        notification = document.createElement('div');
        notification.className = 'notification';
        document.body.appendChild(notification);
        
        // Add styles
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
          .notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #3b82f6;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 1000;
          }
          
          .notification.success {
            background-color: #10b981;
          }
          
          .notification.error {
            background-color: #ef4444;
          }
          
          .notification.active {
            transform: translateY(0);
            opacity: 1;
          }
        `;
        document.head.appendChild(notificationStyle);
      }
      
      // Set notification type
      notification.className = 'notification';
      if (type === 'success' || type === 'error') {
        notification.classList.add(type);
      }
      
      // Update notification text and show
      notification.textContent = message;
      notification.classList.add('active');
      
      // Hide notification after 3 seconds
      setTimeout(() => {
        notification.classList.remove('active');
      }, 3000);
    }
  });
  