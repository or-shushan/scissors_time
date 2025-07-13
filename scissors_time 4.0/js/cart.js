document.addEventListener('DOMContentLoaded', function () {
    // עדכון כמות הסל בראש האתר
    fetch('api/get-cart-count.php')
      .then(response => response.json())
      .then(data => {
        const cartCountBadge = document.getElementById('cart-count');
        if (cartCountBadge && data.count !== undefined) {
          cartCountBadge.textContent = data.count;
        }
      })
      .catch(error => console.error('שגיאה בטעינת כמות פריטים מהעגלה:', error));
  
    // שינוי כמות (הוספה / הפחתה)
    document.querySelectorAll('.increase-btn').forEach(button => {
      button.addEventListener('click', () => updateQuantity(button.dataset.id, 1));
    });
  
    document.querySelectorAll('.decrease-btn').forEach(button => {
      button.addEventListener('click', () => updateQuantity(button.dataset.id, -1));
    });
  
    // הסרת פריט מהעגלה
    document.querySelectorAll('.remove-item').forEach(button => {
      button.addEventListener('click', () => removeItem(button.dataset.id));
    });
  
    // לחיצה על "המשך לתשלום"
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', () => {
        fetch('api/checkout.php', {
          method: 'POST',
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
                const modal = document.getElementById('thankyou-modal');
                modal.style.display = 'flex';
                modal.classList.add('active');
            } else {
              alert(data.message || 'שגיאה בביצוע ההזמנה');
            }
          })
          .catch(err => {
            console.error('שגיאה בביצוע ההזמנה:', err);
            alert('אירעה שגיאה');
          });
      });
    }
  
    // פונקציית עדכון כמות
    function updateQuantity(itemId, change) {
      fetch('api/update-cart-quantity.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ item_id: itemId, change: change })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.message || 'שגיאה בעדכון הכמות');
          }
        })
        .catch(error => console.error('שגיאה בעדכון כמות:', error));
    }
  
    // פונקציית הסרה
    function removeItem(itemId) {
      if (!confirm('האם אתה בטוח שברצונך להסיר את הפריט מהעגלה?')) return;
  
      fetch('api/remove-cart-item.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ item_id: itemId })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.message || 'שגיאה בהסרת הפריט');
          }
        })
        .catch(error => console.error('שגיאה בהסרת פריט מהעגלה:', error));
    }
  });
  