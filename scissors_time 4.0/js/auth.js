// Authentication logic for SCISSORS TIME
document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');

  // Handle login
  if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const formData = new FormData(loginForm);
      const response = await fetch('login-api.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        showNotification('התחברת בהצלחה! מועבר לדף הבית...', 'success');
        setTimeout(() => {
          window.location.href = 'index.php';
        }, 1500);
      } else {
        showNotification(result.message, 'error');
      }
    });
  }

  // Handle register
  if (registerForm) {
    registerForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const formData = new FormData(registerForm);

      // Validation
      const password = formData.get('password');
      const confirmPassword = formData.get('confirm-password');
      const terms = document.getElementById('terms')?.checked;

      if (password !== confirmPassword) {
        showNotification('הסיסמאות אינן תואמות', 'error');
        return;
      }

      if (!terms) {
        showNotification('אנא אשר את תנאי השימוש', 'error');
        return;
      }

      const response = await fetch('register-api.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        showNotification('נרשמת בהצלחה! מועבר לדף הבית...', 'success');
        setTimeout(() => {
          window.location.href = 'index.php';
        }, 1500);
      } else {
        showNotification(result.message, 'error');
      }
    });
  }

  // Handle user dropdown based on session
  const authContainer = document.querySelector('.auth-buttons');
  if (typeof window.loggedInUser !== 'undefined' && authContainer) {
    authContainer.innerHTML = `
      <div class="user-dropdown">
        <button class="btn btn-outline user-btn">
          <i class="fas fa-user"></i>
          <span>${window.loggedInUser.firstName} ${window.loggedInUser.lastName}</span>
          <i class="fas fa-chevron-down"></i>
        </button>
        <div class="dropdown-menu">
          <a href="profile.html"><i class="fas fa-user-circle"></i> פרופיל</a>
          <a href="order-history.html"><i class="fas fa-history"></i> היסטוריית הזמנות</a>
          <a href="appointments-history.html"><i class="fas fa-cut"></i> התורים שלי</a>
          <hr>
          <a href="admin.html"><i class="fas fa-user-shield"></i> כניסת מנהל</a>
          <a href="barber-login.html"><i class="fas fa-user-shield"></i> כניסת ספר</a>
          <a href="admin-reports.html"><i class="fas fa-book"></i> דו\'חות</a>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i> התנתק</a>
        </div>
      </div>
    `;

    const userBtn = document.querySelector('.user-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    userBtn.addEventListener('click', function (e) {
      e.preventDefault();
      dropdownMenu.classList.toggle('active');
    });

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.user-dropdown')) {
        dropdownMenu.classList.remove('active');
      }
    });
  }

  // Notification handler
  function showNotification(message, type = 'info') {
    let notification = document.querySelector('.notification');
    if (!notification) {
      notification = document.createElement('div');
      notification.className = 'notification';
      document.body.appendChild(notification);

      const style = document.createElement('style');
      style.textContent = /*`
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

        .notification.success { background-color: #10b981; }
        .notification.error { background-color: #ef4444; }
        .notification.active {
          transform: translateY(0);
          opacity: 1;
        }
      */
      document.head.appendChild(style);
    }

    notification.className = 'notification ' + type;
    notification.textContent = message;
    notification.classList.add('active');

    setTimeout(() => {
      notification.classList.remove('active');
    }, 3000);
  }

}); 