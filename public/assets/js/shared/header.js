// Enable hover dropdown for Profile menu
(function() {
  const dropdowns = document.querySelectorAll('.navbar .dropdown');
  dropdowns.forEach(dd => {
    const toggle = dd.querySelector('.dropdown-toggle');
    const menu = dd.querySelector('.dropdown-menu');
    if (!toggle || !menu) return;

    let hideTimeout;

    // Show on hover
    dd.addEventListener('mouseenter', () => {
      // Clear any pending hide timeout
      if (hideTimeout) {
        clearTimeout(hideTimeout);
        hideTimeout = null;
      }
      
      dd.classList.add('show');
      toggle.setAttribute('aria-expanded', 'true');
      menu.classList.add('show');
    });

    // Hide when mouse leaves dropdown area (with small delay)
    dd.addEventListener('mouseleave', () => {
      // Add small delay to allow mouse movement to menu
      hideTimeout = setTimeout(() => {
        dd.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
        menu.classList.remove('show');
      }, 100); // 100ms delay
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
