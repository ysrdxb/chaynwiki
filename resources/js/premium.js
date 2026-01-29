/**
 * ChaynWiki Premium Interactions
 * Scroll reveal, parallax, and reading progress
 */

// Initialize scroll reveal
function initScrollReveal() {
    const elements = document.querySelectorAll('[data-reveal]');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    elements.forEach(el => observer.observe(el));
}

// Initialize staggered animations
function initStaggeredAnimations() {
    const groups = document.querySelectorAll('[data-stagger]');

    groups.forEach(group => {
        const children = group.children;
        Array.from(children).forEach((child, index) => {
            child.style.animationDelay = `${index * 100}ms`;
        });
    });
}

// Reading progress bar
function initReadingProgress() {
    const progressBar = document.querySelector('.reading-progress');
    if (!progressBar) return;

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;
        progressBar.style.width = `${Math.min(progress, 100)}%`;
    });
}

// Parallax effect (subtle)
function initParallax() {
    const parallaxElements = document.querySelectorAll('[data-parallax]');

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;

        parallaxElements.forEach(el => {
            const speed = parseFloat(el.dataset.parallax) || 0.5;
            const yPos = -(scrolled * speed);
            el.style.transform = `translateY(${yPos}px)`;
        });
    });
}

// Counter animation
function animateCounters() {
    const counters = document.querySelectorAll('[data-counter]');

    counters.forEach(counter => {
        const target = parseInt(counter.dataset.counter);
        const duration = parseInt(counter.dataset.duration) || 2000;
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };

        // Trigger when visible
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                updateCounter();
                observer.disconnect();
            }
        });
        observer.observe(counter);
    });
}

// Hover tilt effect for cards
function initTiltEffect() {
    const cards = document.querySelectorAll('[data-tilt]');

    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });
}

// Initialize all premium effects
function initPremiumEffects() {
    initScrollReveal();
    initStaggeredAnimations();
    initReadingProgress();
    initParallax();
    animateCounters();
    initTiltEffect();
}

// Run on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPremiumEffects);
} else {
    initPremiumEffects();
}

// Re-init on Livewire navigation
document.addEventListener('livewire:navigated', initPremiumEffects);
