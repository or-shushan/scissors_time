document.addEventListener('DOMContentLoaded', function () {
  const usersTable = document.getElementById('users-table');
  const userSearchInput = document.getElementById('user-search');
  const editModal = document.getElementById('editModal');
  const editForm = document.getElementById('edit-form');

  if (!usersTable) return;

  // טען את המשתמשים מהשרת
  function loadUsers(search = '') {
    fetch('get-users.php?q=' + encodeURIComponent(search))
      .then(res => res.json())
      .then(users => {
        usersTable.innerHTML = '';

        if (users.length === 0) {
          usersTable.innerHTML = '<tr><td colspan="5">לא נמצאו משתמשים תואמים</td></tr>';
          return;
        }

        users.forEach(user => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><input type="text" value="${user.full_name}" readonly style="border:none"></td>
            <td><input type="text" value="${user.email}" readonly style="border:none"></td>
            <td><input type="text" value="${user.phone}" readonly style="border:none"></td>
            <td><input type="text" value="${user.role}" readonly style="border:none"></td>
            <td>
              <button class="edit-btn" data-id="${user.id}" data-fullname="${user.full_name}" data-email="${user.email}" data-phone="${user.phone}" data-role="${user.role}">ערוך</button>
              <button class="delete-btn" data-id="${user.id}">מחק</button>
            </td>
          `;
          usersTable.appendChild(row);
        });

        attachUserActions(); // חיבור כפתורים אחרי טעינה
      });
  }

  // חיבור כפתורי עריכה ומחיקה
  function attachUserActions() {
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const full_name = btn.dataset.fullname;
        const email = btn.dataset.email;
        const phone = btn.dataset.phone;
        const role = btn.dataset.role;

        const [first_name, last_name = ''] = full_name.split(' ');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-fname').value = first_name;
        document.getElementById('edit-lname').value = last_name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-phone').value = phone;
        document.getElementById('edit-role').value = role;
        document.getElementById('edit-password').value = '';

        editModal.style.display = 'block';
      });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        if (confirm("אתה בטוח שברצונך למחוק את המשתמש?")) {
          fetch('delete-user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
          })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                loadUsers(userSearchInput.value.trim());
              } else {
                alert("שגיאה במחיקה");
              }
            });
        }
      });
    });
  }

  // שליחת טופס עריכה
  editForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('update-user.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if (result.success) {
          alert('המשתמש עודכן בהצלחה');
          editModal.style.display = 'none';
          loadUsers(userSearchInput.value.trim());
        } else {
          alert('שגיאה בעדכון');
        }
      });
  });

  // סגירת חלון עריכה
  document.getElementById('close-modal').addEventListener('click', () => {
    editModal.style.display = 'none';
  });

  // חיפוש דינמי
  if (userSearchInput) {
    userSearchInput.addEventListener('input', function () {
      const query = this.value.trim();
      loadUsers(query);
    });
  }

  // טעינה ראשונית
  loadUsers();
});



document.addEventListener('DOMContentLoaded', function () {
  const openBtn = document.getElementById('open-add-user-modal');
  const modal = document.getElementById('add-user-modal');
  const closeBtn = document.getElementById('close-add-modal');
  const form = document.getElementById('add-user-form');

  // פתיחה וסגירה
  if (openBtn && modal && closeBtn) {
    openBtn.addEventListener('click', () => {
      modal.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
      modal.classList.remove('active');
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('active');
      }
    });
  }

  // שליחה
  if (form && modal) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      const formData = new FormData(form);
      try {
        const response = await fetch('add-user.php', {
          method: 'POST',
          body: formData
        });
        const text = await response.text();
        console.log("תשובת השרת:", text);
        
        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          alert("התגובה מהשרת אינה בפורמט JSON");
          console.error("JSON parse error:", err);
          return;
        }        if (result.success) {
          alert("המשתמש נוסף בהצלחה");
          modal.classList.remove('active');
          form.reset();
          if (typeof fetchUsers === 'function') fetchUsers();
        } else {
          alert(result.error || 'שגיאה בהוספת משתמש');
        }
      } catch (err) {
        alert("שגיאה בתקשורת עם השרת");
        console.error(err);
      }
    });
  }
});

