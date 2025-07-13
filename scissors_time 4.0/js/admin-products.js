document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('products-container');
    const searchInput = document.getElementById('product-search');
    const filterButtons = document.querySelectorAll('.btn-filter');
  
    if (!container) return;
  
    fetch('get-products.php')
      .then(res => res.json())
      .then(products => {
        container.innerHTML = '';
        products.forEach(product => {
          const imageSrc = product.image && product.image.trim() !== '' ? product.image : '';
          const imageAlt = product.image && product.image.trim() !== '' ? product.name : 'תמונה חסרה';
  
          const card = document.createElement('div');
          card.className = 'product-card';
          card.setAttribute('data-category', product.category.toLowerCase());
  
          card.innerHTML = `
            <div class="product-image">
              ${imageSrc 
                ? `<img src="${imageSrc}" alt="${imageAlt}" class="placeholder-img">` 
                : `<div class="placeholder-img">תמונה חסרה</div>`}
              <div class="product-actions">
                <button class="quick-view-btn"
                  data-id="${product.id}"
                  data-name="${product.name}"
                  data-description="${product.description}"
                  data-image="${imageSrc}"
                  data-price="${product.price}">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <div class="product-info">
              <h3 class="product-title">${product.name}</h3>
              <p class="product-desc">${product.description}</p>
              <div class="product-price-action" >
                <span class="product-price">₪${parseFloat(product.price).toFixed(2)}</span>
                <button class="btn btn-primary btn-add-cart"
                  onclick="addToCart('${product.name}', ${product.price}, '${imageSrc}', 1)">
                  <i class="fas fa-cart-plus"></i> הוסף לעגלה
                </button>
              </div>
            </div>
          `;
          container.appendChild(card);
        });
  
        enableQuickView();
        enableFilter();
        enableSearch();
      });
  
    function enableFilter() {
      const cards = container.querySelectorAll('.product-card');
      filterButtons.forEach(button => {
        button.addEventListener('click', () => {
          const category = button.getAttribute('data-category').toLowerCase();
          filterButtons.forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');
          cards.forEach(card => {
            card.style.display = (category === 'all' || card.dataset.category === category) ? 'block' : 'none';
          });
        });
      });
    }
  
    function enableSearch() {
      const cards = container.querySelectorAll('.product-card');
      if (searchInput) {
        searchInput.addEventListener('input', () => {
          const search = searchInput.value.toLowerCase();
          cards.forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            card.style.display = name.includes(search) ? 'block' : 'none';
          });
        });
      }
    }
  
    function enableQuickView() {
      container.addEventListener('click', function (e) {
        const btn = e.target.closest('.quick-view-btn');
        if (!btn) return;
  
        const name = btn.dataset.name;
        const description = btn.dataset.description;
        const image = btn.dataset.image;
        const price = parseFloat(btn.dataset.price).toFixed(2);
  
        const modal = document.createElement('div');
        modal.className = 'modal-overlay';
        modal.innerHTML = `
          <div class="product-modal active" style="max-width: 420px;">
            <button class="modal-close"><i class="fas fa-times"></i></button>
            <div class="modal-content">
              <img src="${image}" alt="${name}" class="modal-image" >
              <div class="modal-details">
                <h2>${name}</h2>
                <p>${description}</p>
                <div class="qty-control">
                  <button class="qty-btn" id="decrease-qty">-</button>
                  <input type="text" id="qty-value" value="1" class="qty-value" readonly>
                  <button class="qty-btn" id="increase-qty">+</button>
                </div>
                <div style="margin-top: 1rem;">
                  <button class="btn btn-primary" id="add-modal-cart">
                    <i class="fas fa-cart-plus"></i> הוסף לעגלה
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;
  
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.add('active'), 10);
  
        const qtyValue = modal.querySelector('#qty-value');
        modal.querySelector('#increase-qty').addEventListener('click', () => {
          qtyValue.value = parseInt(qtyValue.value) + 1;
        });
        modal.querySelector('#decrease-qty').addEventListener('click', () => {
          qtyValue.value = Math.max(1, parseInt(qtyValue.value) - 1);
        });
  
        modal.querySelector('#add-modal-cart').addEventListener('click', () => {
          addToCart(name, price, image, parseInt(qtyValue.value));
          modal.classList.remove('active');
          setTimeout(() => modal.remove(), 300);
        });
  
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
  
        document.addEventListener('keydown', function escListener(event) {
          if (event.key === "Escape") {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
            document.removeEventListener('keydown', escListener);
          }
        });
      });
    }
  
    window.addToCart = function(name, price, imageUrl, quantity = 1) {
      showNotification(`${name} נוסף לעגלה`, 'success');
      // כאן תוכל להוסיף שמירה ל־DB בעתיד
    };
  
    function showNotification(message, type = 'success') {
      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      toast.textContent = message;
      document.body.appendChild(toast);
  
      const style = document.createElement('style');
      style.textContent = `
        .toast {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background-color: ${type === 'success' ? '#10b981' : '#dc2626'};
          color: white;
          padding: 1rem 1.5rem;
          border-radius: 0.5rem;
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
          z-index: 1100;
          opacity: 0;
          transform: translateY(20px);
          transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .toast.active {
          opacity: 1;
          transform: translateY(0);
        }
      `;
      document.head.appendChild(style);
  
      setTimeout(() => toast.classList.add('active'), 10);
      setTimeout(() => {
        toast.classList.remove('active');
        setTimeout(() => {
          toast.remove();
          style.remove();
        }, 300);
      }, 3000);
    }
  });
  