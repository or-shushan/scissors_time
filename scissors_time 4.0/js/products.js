// Show notification
function showNotification(message, type = 'info') {
  let notification = document.querySelector('.notification');

  if (!notification) {
    notification = document.createElement('div');
    notification.className = 'notification';
    document.body.appendChild(notification);

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

  notification.className = 'notification';
  if (type === 'success' || type === 'error') {
    notification.classList.add(type);
  }

  notification.textContent = message;
  notification.classList.add('active');

  setTimeout(() => {
    notification.classList.remove('active');
  }, 3000);
}
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('products-container');
  if (!container) return;

  const productCards = container.querySelectorAll('.product-card');
  const allProducts = Array.from(productCards);
  const searchInput = document.getElementById('product-search');
  const filterButtons = document.querySelectorAll('.btn-filter');

  // סינון לפי קטגוריה
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const category = button.getAttribute('data-category');
      filterButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      allProducts.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // חיפוש מוצרים
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      const search = searchInput.value.toLowerCase();
      allProducts.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = name.includes(search) ? 'block' : 'none';
      });
    });
  }

  // לחיצה על "הוסף לעגלה" מתוך עמוד ראשי
  document.querySelectorAll('.btn-add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
      const productId = button.getAttribute('data-product-id');
      const quantityInput = document.getElementById(`quantity-${productId}`);
      const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

      addToCart(productId, quantity);
    });
  });

  // צפייה מהירה (אם תמשיך להשתמש בזה – מתוקן לשליחה תקינה)
  container.querySelectorAll('.quick-view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const name = btn.dataset.name;
      const description = btn.dataset.description;
      const image = btn.dataset.image;
      const price = btn.dataset.price;
      const productId = btn.dataset.id;

      const modal = document.createElement('div');
      modal.className = 'modal-overlay';
      modal.innerHTML = `
        <div class="product-modal">
          <button class="modal-close"><i class="fas fa-times"></i></button>
          <div class="modal-content">
            <img src="${image}" alt="${name}">
            <div class="modal-details">
              <h2>${name}</h2>
              <p>${description}</p>
              <p class="price">₪${parseFloat(price).toFixed(2)}</p>
              <label>כמות:
                <input type="number" id="modal-quantity-${productId}" value="1" min="1" style="width: 60px;">
              </label>
              <button class="btn btn-primary" onclick="addToCart(${productId}, getModalQuantity(${productId}))">הוסף לעגלה</button>
            </div>
          </div>
        </div>
      `;

      document.body.appendChild(modal);
      setTimeout(() => modal.classList.add('active'), 10);

      modal.querySelector('.modal-close').addEventListener('click', () => {
        modal.classList.remove('active');
        setTimeout(() => modal.remove(), 300);
      });

      modal.addEventListener('click', e => {
        if (e.target === modal) {
          modal.classList.remove('active');
          setTimeout(() => modal.remove(), 300);
        }
      });
    });
  });
});
function addToCart(productId, quantity = 1) {
fetch('api/add-to-cart.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ product_id: productId, quantity: quantity })
})
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showNotification('המוצר נוסף לעגלה בהצלחה!', 'success');
    } else {
      showNotification('שגיאה בהוספת מוצר: ' + data.message, 'error');
    }
  })
  .catch(err => {
    console.error('שגיאת רשת:', err);
    showNotification('שגיאה בשליחה לשרת', 'error');
  });
 }


function getModalQuantity(productId) {
  const input = document.getElementById(`modal-quantity-${productId}`);
  return input ? parseInt(input.value) : 1;
}
