/**

 * Profile Page JavaScript

 * Handles user profile functionality including tabs, form submissions, and UI updates

 */

document.addEventListener('DOMContentLoaded', function() {

    // DOM Elements

    const profileTabs = document.querySelectorAll('.profile-nav li');

    const tabContents = document.querySelectorAll('.tab-content');

    const personalInfoForm = document.getElementById('personal-info-form');

    const settingsForm = document.getElementById('settings-form');

    const logoutBtn = document.getElementById('logout-btn');

    const passwordToggles = document.querySelectorAll('.password-toggle');

    const notificationElement = document.getElementById('notification');

   

    // Initialize profile

  if (typeof initProfile === "function") initProfile();
   

    // Tab switching

    profileTabs.forEach(tab => {

        tab.addEventListener('click', function(e) {

            if (this.id === 'logout-btn' || this.querySelector('a')?.getAttribute('href')?.includes('.html')) return;

           

        

            const tabId = this.getAttribute('data-tab');

           

            // Update active tab

            profileTabs.forEach(t => t.classList.remove('active'));

            this.classList.add('active');

           

            // Show active content

            tabContents.forEach(content => content.classList.remove('active'));

            const activeContent = document.getElementById(tabId);

            if (activeContent) {

                activeContent.classList.add('active');

            }

           

            // Update URL hash

            window.location.hash = tabId;

        });

    });

   

    // Handle form submissions

    personalInfoForm?.addEventListener('submit', function(e) {

        e.preventDefault();

        updatePersonalInfo();

    });

   

    settingsForm?.addEventListener('submit', function(e) {

        e.preventDefault();

        updateSettings();

    });

   

    // Logout functionality

    logoutBtn?.addEventListener('click', function(e) {

        e.preventDefault();

        logout();

    });

   

    // Password toggle functionality

    passwordToggles.forEach(toggle => {

        toggle.addEventListener('click', function() {

            const passwordInput = this.previousElementSibling;

            if (passwordInput && passwordInput.type === 'password') {

                passwordInput.type = 'text';

                this.innerHTML = '<i class="fas fa-eye-slash"></i>';

            } else if (passwordInput) {

                passwordInput.type = 'password';

                this.innerHTML = '<i class="fas fa-eye"></i>';

            }

        });

    });

   

    // Check URL hash for tab selection on page load

    checkUrlHash();

   

    // Listen for hash changes

    window.addEventListener('hashchange', checkUrlHash);

});



/**

 * Check URL hash and activate corresponding tab

 */

function checkUrlHash() {

    const hash = window.location.hash.substring(1);

    if (hash) {

        const tab = document.querySelector(`.profile-nav li[data-tab="${hash}"]`);

        tab?.click();

    }

}

document.addEventListener('DOMContentLoaded', function() {

    // DOM Elements

    const userImageInput = document.getElementById('user-image');

    const fileNameDisplay = document.getElementById('file-name');

    const uploadLabel = document.getElementById('upload-label');



    // Handle image upload

    userImageInput?.addEventListener('change', function(e) {

        const file = e.target.files[0];

        

        if (file) {

            // הצגת שם הקובץ רק ב-<span> ולא בלייבל

            fileNameDisplay.textContent = file.name;



            // עדכון הלייבל כך שיכיל את שם הקובץ, אך לא יופיע פעמיים

            uploadLabel.textContent = "רוצה לשנות תמונה? עוד לא מאוחר... לחץ כאן";

        }

    });

});


document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('personal-info-form');
  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const formData = new FormData(form);
      try {
        const response = await fetch('update-profile.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();
        if (result.success) {
          alert('הפרטים עודכנו בהצלחה');
        } else {
          alert('שגיאה: ' + (result.error || 'אירעה שגיאה'));
        }
      } catch (err) {
        alert('שגיאה בתקשורת עם השרת');
        console.error(err);
      }
    });
  }
});
