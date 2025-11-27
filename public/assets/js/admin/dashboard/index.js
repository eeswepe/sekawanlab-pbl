// Counter animation for stats
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000;
    const increment = target / (duration / 16);
    let current = 0;

    const updateCounter = () => {
        current += increment;
        if (current < target) {
            element.textContent = Math.floor(current) + '+';
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target + '+';
        }
    };

    updateCounter();
}

// Intersection Observer for counter animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                if (!counter.classList.contains('animated')) {
                    animateCounter(counter);
                    counter.classList.add('animated');
                }
            });
        }
    });
}, observerOptions);

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    observer.observe(statsSection);
}

// Scroll reveal animation
const scrollReveal = () => {
    const elements = document.querySelectorAll('.about-card, .service-card, .research-card, .stat-card');

    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;

        if (elementTop < window.innerHeight && elementBottom > 0) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

// Initial state for animated elements
document.querySelectorAll('.about-card, .service-card, .research-card, .stat-card').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'all 0.6s ease-out';
});

window.addEventListener('scroll', scrollReveal);
window.addEventListener('load', scrollReveal);

// Update navigation dots based on scroll position
const sections = document.querySelectorAll('section');
const dots = document.querySelectorAll('.hero-nav-dots .dot');

function updateActiveDot() {
    if (sections.length === 0 || dots.length === 0) return;
    
    // Get current scroll position (middle of viewport for better detection)
    const scrollPosition = window.scrollY + (window.innerHeight / 2);
    
    let currentSectionIndex = 0;
    
    // Find which section we're currently in
    sections.forEach((section, index) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        const sectionBottom = sectionTop + sectionHeight;
        
        // Check if scroll position is within this section
        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            currentSectionIndex = index;
        }
    });
    
    // Update dots active state
    dots.forEach((dot, index) => {
        if (index === currentSectionIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

// Navigation dots click - scroll to section
dots.forEach((dot, index) => {
    dot.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (sections[index]) {
            // Smooth scroll to section
            sections[index].scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
            
            // Update active state immediately for better UX
            dots.forEach(d => d.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// Listen to scroll events for dots (with throttle for performance)
let scrollTimeout;
window.addEventListener('scroll', function() {
    if (scrollTimeout) {
        window.cancelAnimationFrame(scrollTimeout);
    }
    
    scrollTimeout = window.requestAnimationFrame(function() {
        updateActiveDot();
    });
});

// Initial update on page load
window.addEventListener('load', function() {
    updateActiveDot();
    console.log('Navigation dots initialized:', dots.length, 'dots for', sections.length, 'sections');
});

// Play button functionality
const playButton = document.querySelector('.play-button');
if (playButton) {
    playButton.addEventListener('click', function() {
        // Add your video modal or video play functionality here
        console.log('Play button clicked');
    });
}

// Scroll down button
const scrollDownBtn = document.querySelector('.scroll-down');
if (scrollDownBtn) {
    scrollDownBtn.addEventListener('click', function() {
        const nextSection = document.querySelectorAll('section')[1];
        if (nextSection) {
            nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
}