document.addEventListener('DOMContentLoaded', function () {
  // Tabs
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', function () {
      const tab = this.getAttribute('data-tab');
      tabButtons.forEach(btn => btn.classList.remove('active'));
      tabContents.forEach(content => content.style.display = 'none');
      this.classList.add('active');
      document.getElementById(tab).style.display = 'block';
    });
  });

  // Load products from DB
  function displayProducts() {
    fetch('get-products.php')
      .then(res => res.json())
      .then(products => {
        const productsTable = document.getElementById('products-table');
        if (!productsTable) return;
        productsTable.innerHTML = '';

        products.forEach(product => {
          const row = document.createElement('tr');
          const quantityClass = product.quantity <= 10 ? 'low-inventory' : '';
          row.innerHTML = `
            <td><img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover;"></td>
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>₪${parseFloat(product.price).toFixed(2)}</td>
            <td>${product.description}</td>
            <td>
              <input type="text" value="${product.quantity || 0}" min="0" data-id="${product.id}" class="inventory-input ${quantityClass}">
            </td>
            <td>
              <button class="btn btn-primary" onclick="editProduct(${product.id})">ערוך</button>
              <button class="btn btn-error" onclick="deleteProduct(${product.id})">מחק</button>
            </td>
          `;
          productsTable.appendChild(row);
        });
      });
  }

  // Add/Edit Product
  document.getElementById('add-product-btn')?.addEventListener('click', () => showProductForm());

  window.editProduct = function(id) {
    fetch('get-products.php')
      .then(res => res.json())
      .then(products => {
        const product = products.find(p => p.id == id);
        if (product) showProductForm(product);
      });
  };

  window.deleteProduct = function(id) {
    if (!confirm("אתה בטוח שברצונך למחוק את המוצר?")) return;
    fetch('delete-product.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + id
    }).then(res => res.json()).then(data => {
      if (data.success) {
        displayProducts();
        alert("המוצר נמחק");
      }
    });
  };

  function showProductForm(product = null) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
      <div class="product-modal">
        <button class="modal-close"><i class="fas fa-times"></i></button>
        <div class="modal-content">
          <h2>${product ? 'עריכת מוצר' : 'הוספת מוצר'}</h2>
          <form id="product-form" class="admin-form" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" id="product-id" value="${product ? product.id : ''}">
            <div class="form-group">
              <label for="product-name">שם המוצר</label>
              <input type="text" name="name" id="product-name" value="${product?.name || ''}" required>
            </div>
            <div class="form-group">
              <label for="product-category">קטגוריה</label>
              <input type="text" name="category" id="product-category" value="${product?.category || ''}" required>
            </div>
            <div class="form-group">
              <label for="product-price">מחיר</label>
              <input type="number" name="price" id="product-price" value="${product?.price || ''}" step="0.01" required>
            </div>
            <div class="form-group">
              <label for="product-quantity">מלאי זמין</label>
              <input type="number" name="quantity" id="product-quantity" value="${product?.quantity || '0'}" min="0" required>
            </div>
            <div class="form-group">
              <label for="product-description">תיאור</label>
              <textarea name="description" id="product-description" required>${product?.description || ''}</textarea>
            </div>
            <div class="form-group">
              <label for="product-image">תמונה</label>
              <input type="file" name="imageFile" id="product-image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">${product ? 'עדכן מוצר' : 'הוסף מוצר'}</button>
          </form>
        </div>
      </div>
    `;

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('active'), 10);

    modal.querySelector('#product-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('update-product.php', {
        method: 'POST',
        body: formData
      }).then(res => res.json()).then(data => {
        if (data.success) {
          displayProducts();
          alert("המוצר נשמר");
          closeModal();
        } else {
          alert("שגיאה בשמירה: " + (data.error || ''));
        }
      });
    });

    modal.querySelector('.modal-close').addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
      if (e.target === modal) closeModal();
    });

    function closeModal() {
      modal.classList.remove('active');
      setTimeout(() => modal.remove(), 300);
    }
  }

  displayProducts();
});
