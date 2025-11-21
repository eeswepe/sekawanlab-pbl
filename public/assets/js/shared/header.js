// Enable hover dropdown for Profile menu
(function() {
  const dropdowns = document.querySelectorAll('.navbar .dropdown');
  dropdowns.forEach(dd => {
    const toggle = dd.querySelector('.dropdown-toggle');
    const menu = dd.querySelector('.dropdown-menu');
    if (!toggle || !menu) return;

    // Show on hover
    dd.addEventListener('mouseenter', () => {
      dd.classList.add('show');
      toggle.setAttribute('aria-expanded', 'true');
      menu.classList.add('show');
    });

    // Hide when mouse leaves dropdown area
    dd.addEventListener('mouseleave', () => {
      dd.classList.remove('show');
      toggle.setAttribute('aria-expanded', 'false');
      menu.classList.remove('show');
    });

    // Prevent click from immediately closing when using touch
    toggle.addEventListener('click', (e) => {
      // Allow normal toggle on small screens (<992px) for accessibility
      if (window.innerWidth >= 992) {
        e.preventDefault();
      }
    });
  });
})();