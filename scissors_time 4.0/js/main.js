document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
  const mainNav = document.querySelector('.main-nav');
  const authButtons = document.querySelector('.auth-buttons');

  if (mobileMenuToggle && mainNav) {
    mobileMenuToggle.addEventListener('click', function() {
      let mobileMenu = document.querySelector('.mobile-menu');

      if (!mobileMenu) {
        mobileMenu = document.createElement('div');
        mobileMenu.className = 'mobile-menu';

        const navClone = mainNav.cloneNode(true);
        mobileMenu.appendChild(navClone);

        if (authButtons && !mobileMenu.querySelector('.user-dropdown')) {
          const authClone = authButtons.cloneNode(true);
          mobileMenu.appendChild(authClone);
        }

        const closeBtn = document.createElement('button');
        closeBtn.className = 'mobile-menu-close';
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        mobileMenu.prepend(closeBtn);

        document.body.appendChild(mobileMenu);

        closeBtn.addEventListener('click', function() {
          mobileMenu.classList.remove('active');
          document.body.classList.remove('menu-open');
        });
      }

      mobileMenu.classList.toggle('active');
      document.body.classList.toggle('menu-open');
    });
  }

  const style = document.createElement('style');
  style.textContent = `
    .mobile-menu {
      position: fixed;
      top: 0;
      right: -100%;
      width: 80%;
      max-width: 320px;
      height: 100%;
      background-color: white;
      z-index: 1000;
      padding: 2rem;
      box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
      transition: right 0.3s ease;
      overflow-y: auto;
    }

    .mobile-menu.active {
      right: 0;
    }

    .body.menu-open {
      overflow: hidden;
    }

    .mobile-menu-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .mobile-menu .main-nav {
      display: block;
      margin-top: 2rem;
    }

    .mobile-menu .main-nav ul {
      flex-direction: column;
      gap: 1rem;
    }

    .mobile-menu .auth-buttons {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-top: 2rem;
    }
  `;
  document.head.appendChild(style);

  const passwordToggles = document.querySelectorAll('.password-toggle');

  passwordToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
      const passwordInput = this.previousElementSibling;
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        passwordInput.type = 'password';
        this.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  });

  function revealOnScroll() {
    const elements = document.querySelectorAll('.feature-card, .service-card, .barber-card, .testimonial-card, .product-card, .benefit-card');
    elements.forEach(element => {
      const elementTop = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      if (elementTop < windowHeight - 100) {
        element.classList.add('revealed');
      }
    });
  }

  const revealStyle = document.createElement('style');
  revealStyle.textContent = `
    .feature-card, .service-card, .barber-card, .testimonial-card, .product-card, .benefit-card {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .feature-card.revealed, .service-card.revealed, .barber-card.revealed, .testimonial-card.revealed, .product-card.revealed, .benefit-card.revealed {
      opacity: 1;
      transform: translateY(0);
    }
  `;
  document.head.appendChild(revealStyle);

  window.addEventListener('scroll', revealOnScroll);
  window.addEventListener('load', revealOnScroll);
});