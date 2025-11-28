// Navbar scroll effect
window.addEventListener("scroll", function () {
  const navbar = document.querySelector(".navbar-custom");
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Counter animation for stats
function animateCounter(element) {
  const target = parseInt(element.getAttribute("data-target"));
  const duration = 1200; // faster animation
  const increment = Math.max(1, Math.ceil(target / (duration / 16)));
  let current = 0;

  const updateCounter = () => {
    current += increment;
    if (current < target) {
      element.textContent = Math.floor(current) + "+";
      requestAnimationFrame(updateCounter);
    } else {
      element.textContent = target + "+";
    }
  };

  updateCounter();
}

// Intersection Observer for counter animation
const observerOptions = {
  threshold: 0.5,
  rootMargin: "0px",
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const counters = entry.target.querySelectorAll(".stat-number");
      counters.forEach((counter) => {
        if (!counter.classList.contains("animated")) {
          animateCounter(counter);
          counter.classList.add("animated");
        }
      });
    }
  });
}, observerOptions);

const statsSection = document.querySelector(".stats-section");
if (statsSection) {
  observer.observe(statsSection);
}

// Dropdown hover effect (desktop only)
if (window.innerWidth > 768) {
  const dropdownElements = document.querySelectorAll(".dropdown");

  dropdownElements.forEach((dropdown) => {
    let timeout;

    dropdown.addEventListener("mouseenter", function () {
      clearTimeout(timeout);
      const menu = this.querySelector(".dropdown-menu");
      const toggle = this.querySelector(".dropdown-toggle");
      if (menu && toggle) {
        menu.classList.add("show");
        toggle.setAttribute("aria-expanded", "true");
      }
    });

    dropdown.addEventListener("mouseleave", function () {
      const menu = this.querySelector(".dropdown-menu");
      const toggle = this.querySelector(".dropdown-toggle");

      timeout = setTimeout(() => {
        if (menu && toggle) {
          menu.classList.remove("show");
          toggle.setAttribute("aria-expanded", "false");
        }
      }, 100);
    });
  });
}

// Active link highlighting
const sections = document.querySelectorAll("section[id]");
const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

window.addEventListener("scroll", () => {
  let current = "";
  sections.forEach((section) => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;
    if (scrollY >= sectionTop - 200) {
      current = section.getAttribute("id");
    }
  });

  navLinks.forEach((link) => {
    link.classList.remove("active");
    if (link.getAttribute("href").includes(current)) {
      link.classList.add("active");
    }
  });
});

// Parallax effect for hero section
window.addEventListener("scroll", function () {
  const heroSection = document.querySelector(".hero-section");
  const scrolled = window.pageYOffset;
  const parallax = scrolled * 0.5;

  if (heroSection) {
    heroSection.style.backgroundPositionY = parallax + "px";
  }
});

// Add animation on scroll
const animateOnScroll = () => {
  const elements = document.querySelectorAll(".feature-card, .research-card");

  elements.forEach((element) => {
    const elementTop = element.getBoundingClientRect().top;
    const elementBottom = element.getBoundingClientRect().bottom;

    if (elementTop < window.innerHeight && elementBottom > 0) {
      element.style.opacity = "1";
      element.style.transform = "translateY(0)";
    }
  });
};

// Initial state for animated elements
document
  .querySelectorAll(".feature-card, .research-card")
  .forEach((element) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(30px)";
    element.style.transition = "all 0.6s ease-out";
  });

window.addEventListener("scroll", animateOnScroll);
window.addEventListener("load", animateOnScroll);

// Mobile menu close on link click
const navbarLinks = document.querySelectorAll(".navbar-nav .nav-link");
const navbarCollapse = document.querySelector(".navbar-collapse");

navbarLinks.forEach((link) => {
  link.addEventListener("click", () => {
    if (navbarCollapse.classList.contains("show")) {
      navbarCollapse.classList.remove("show");
    }
  });
});

// Initialize tooltips (if needed in future)
document.addEventListener("DOMContentLoaded", function () {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]'),
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
