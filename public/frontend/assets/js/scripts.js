// ========================================
// SHARED SCRIPTS FOR KL MOBILE EVENTS
// ========================================

// Global Variables
let mouseFollower, cursorOutline, cursorDot;
let mouseX = 0, mouseY = 0;
let outlineX = 0, outlineY = 0;
let dotX = 0, dotY = 0;
let testimonialSwiper, testimonialImagesSwiper;
let autoplayTimer = null;

// ========================================
// INITIALIZE ON DOM LOAD
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize loading screen
    initLoadingScreen();
    
    // Initialize common components
    initCustomCursor();
    initScrollToTop();
    initNavbar();
    initSmoothScrolling();

    // Removed initAnimations() to remove scroll animations
    
    // Initialize page-specific components
    initPageSpecificComponents();
});

// ========================================
// LOADING SCREEN
// ========================================

function initLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    
    if (loadingScreen) {
        // Hide loading screen when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                loadingScreen.classList.add('loaded');
                document.body.classList.add('loaded');
                
                // Initialize page animations after loading
                initPageLoadAnimations();
            }, 500);
        });
    }
}

// ========================================
// CUSTOM CURSOR
// ========================================

function initCustomCursor() {
    mouseFollower = document.querySelector('.mouse-follower');
    cursorOutline = document.querySelector('.cursor-outline');
    cursorDot = document.querySelector('.cursor-dot');

    if (!mouseFollower) return;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        // Move cursor dot immediately
        dotX = mouseX;
        dotY = mouseY;
        cursorDot.style.left = dotX + 'px';
        cursorDot.style.top = dotY + 'px';
    });

    // Smooth animation for cursor outline
    function animateCursor() {
        outlineX += (mouseX - outlineX) * 0.1;
        outlineY += (mouseY - outlineY) * 0.1;
        
        cursorOutline.style.left = outlineX + 'px';
        cursorOutline.style.top = outlineY + 'px';
        
        requestAnimationFrame(animateCursor);
    }
    animateCursor();

    // Hover effects for interactive elements
    const interactiveElements = document.querySelectorAll('a, button, input, textarea, select, .category-card, .subcategory-card, .gallery-item');
    
    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => {
            mouseFollower.classList.add('highlight-cursor');
        });
        
        el.addEventListener('mouseleave', () => {
            mouseFollower.classList.remove('highlight-cursor');
        });
    });

    // Hide cursor when leaving window
    document.addEventListener('mouseleave', () => {
        cursorOutline.style.opacity = '0';
        cursorDot.style.opacity = '0';
    });

    document.addEventListener('mouseenter', () => {
        cursorOutline.style.opacity = '1';
        cursorDot.style.opacity = '1';
    });
}

// ========================================
// SCROLL TO TOP
// ========================================

function initScrollToTop() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (!scrollToTopBtn) return;

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });

    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ========================================
// NAVBAR
// ========================================

function initNavbar() {
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;
        
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // Mobile menu close on link click
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
}

// ========================================
// SMOOTH SCROLLING
// ========================================

function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ========================================
// FORM HANDLERS
// ========================================



// ========================================
// PAGE LOAD ANIMATIONS (NO SCROLL)
// ========================================

function initPageLoadAnimations() {
    // Animate header elements on page load only
    const headerElements = document.querySelectorAll('.hero-badge, .hero-title, .hero-description, .box-style, .category-title, .category-subtitle, .page-title, .page-subtitle');
    headerElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        setTimeout(() => {
            el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });
}

// ========================================
// PAGE SPECIFIC COMPONENTS
// ========================================

function initPageSpecificComponents() {
    // Check which page we're on and initialize appropriate components
    
    // Index page components
    if (document.querySelector('.hero-section')) {
        initHeroSection();
    }
    
    if (document.querySelector('.clients-section')) {
        initClientsSection();
    }
    
    if (document.querySelector('.testimonial-carousel')) {
        initTestimonials();
    }
    
    if (document.querySelector('.stat-number')) {
        initCounterAnimation();
    }
    
    // Category page components
    if (document.querySelector('.category-header')) {
        initCategoryPage();
    }
    
    // Event page components
    if (document.querySelector('.gallery-section')) {
        initGallerySection();
    }
    
    if (document.querySelector('.lightbox')) {
        initLightbox();
    }
    
    if (document.querySelector('.sparkles')) {
        initSparkles();
    }
    
    // Blog section
    if (document.querySelector('.blog-section')) {
        initBlogSection();
    }

    // Contact form AJAX
if (document.querySelector('#contactForm')) {
    initContactFormAjax();
}
}

// ========================================
// INDEX PAGE SPECIFIC
// ========================================

function initHeroSection() {
    // Parallax effect for hero elements
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroContent = document.querySelector('.hero-content');
        const floatingElements = document.querySelectorAll('.float-element');
        
        if (heroContent && scrolled < window.innerHeight) {
            heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
            heroContent.style.opacity = 1 - (scrolled / window.innerHeight);
        }
        
        floatingElements.forEach((el, index) => {
            if (scrolled < window.innerHeight) {
                el.style.transform = `translateY(${scrolled * (0.2 * (index + 1))}px)`;
            }
        });
    });
}

function initClientsSection() {
    // Enhanced client logo hover effect
    document.querySelectorAll('.client-logo-wrapper').forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                background: radial-gradient(circle, rgba(147, 51, 234, 0.3) 0%, transparent 70%);
                width: 200px;
                height: 200px;
                left: ${x - 100}px;
                top: ${y - 100}px;
                transform: scale(0);
                border-radius: 50%;
                pointer-events: none;
                transition: transform 0.6s ease-out, opacity 0.6s ease-out;
            `;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.style.transform = 'scale(2)';
                ripple.style.opacity = '0';
            }, 10);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Pause marquee on individual logo hover
    document.querySelectorAll('.client-logo-wrapper').forEach(wrapper => {
        wrapper.addEventListener('mouseenter', function() {
            const track = this.closest('.clients-track');
            if (track) {
                track.style.animationPlayState = 'paused';
            }
        });

        wrapper.addEventListener('mouseleave', function() {
            const track = this.closest('.clients-track');
            if (track) {
                track.style.animationPlayState = 'running';
            }
        });
    });
}
function initTestimonials() {
    // Initialize testimonial carousel with arrow navigation added
    testimonialSwiper = new Swiper('.testimonial-carousel', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        direction: 'horizontal',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        // Add navigation configuration for arrow buttons
        navigation: {
            nextEl: '.testimonial-next, .testimonial-next-mobile',
            prevEl: '.testimonial-prev, .testimonial-prev-mobile',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        speed: 800,
        // Add keyboard and accessibility support
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        a11y: {
            enabled: true,
            prevSlideMessage: 'Previous testimonial',
            nextSlideMessage: 'Next testimonial',
        },
        on: {
            init: function() {
                // Add accessibility attributes to navigation buttons
                const prevBtn = document.querySelector('.testimonial-prev');
                const nextBtn = document.querySelector('.testimonial-next');
                
                if (prevBtn && nextBtn) {
                    prevBtn.setAttribute('aria-label', 'Previous testimonial');
                    nextBtn.setAttribute('aria-label', 'Next testimonial');
                    prevBtn.setAttribute('role', 'button');
                    nextBtn.setAttribute('role', 'button');
                }
                
                console.log('Testimonial carousel initialized with arrow navigation');
            },
            slideChange: function() {
                // Clear any existing timers when slide changes manually
                if (autoplayTimer) {
                    clearTimeout(autoplayTimer);
                }
                
                // Add slide change animation
                const activeSlide = this.slides[this.activeIndex];
                const quote = activeSlide.querySelector('.fa-quote-left');
                if (quote) {
                    quote.style.transform = 'scale(0.8)';
                    quote.style.transition = 'transform 0.3s ease';
                    setTimeout(() => {
                        quote.style.transform = 'scale(1)';
                    }, 300);
                }
            },
            slideChangeTransitionStart: function() {
                // Animate stars on slide change
                const activeSlide = this.slides[this.activeIndex];
                const stars = activeSlide.querySelectorAll('.fa-star');
                stars.forEach((star, index) => {
                    star.style.opacity = '0';
                    star.style.transform = 'scale(0)';
                    setTimeout(() => {
                        star.style.transition = 'all 0.3s ease';
                        star.style.opacity = '1';
                        star.style.transform = 'scale(1)';
                    }, 100 * (index + 1));
                });
            }
        }
    });

    // Initialize testimonial images carousel (keeping your existing code)
    // testimonialImagesSwiper = new Swiper('.testimonial-images-carousel', {
    //     slidesPerView: 1,
    //     spaceBetween: 0,
    //     loop: true,
    //     direction: 'horizontal',
    //     autoplay: {
    //         delay: 5000,
    //         disableOnInteraction: false
    //     },
    //     effect: 'fade',
    //     fadeEffect: {
    //         crossFade: true
    //     },
    //     speed: 800,
    //     allowTouchMove: false
    // });

    // Sync both carousels (keeping your existing logic)
    if (testimonialSwiper && testimonialImagesSwiper) {
        testimonialSwiper.controller.control = testimonialImagesSwiper;
        testimonialImagesSwiper.controller.control = testimonialSwiper;
    }

    // Pause autoplay on pagination bullet click (keeping your existing logic)
    document.querySelectorAll('.swiper-pagination-bullet').forEach((bullet, index) => {
        bullet.addEventListener('click', () => {
            // Stop both carousels' autoplay
            testimonialSwiper.autoplay.stop();
            if (testimonialImagesSwiper) testimonialImagesSwiper.autoplay.stop();
            
            // Clear any existing timer
            if (autoplayTimer) {
                clearTimeout(autoplayTimer);
            }
            
            // Restart autoplay after 10 seconds
            autoplayTimer = setTimeout(() => {
                testimonialSwiper.autoplay.start();
                if (testimonialImagesSwiper) testimonialImagesSwiper.autoplay.start();
            }, 10000);
        });
    });

    // Pause autoplay on hover (keeping your existing logic)
    const testimonialWrapper = document.querySelector('.testimonial-wrapper');
    if (testimonialWrapper) {
        testimonialWrapper.addEventListener('mouseenter', () => {
            testimonialSwiper.autoplay.stop();
            if (testimonialImagesSwiper) testimonialImagesSwiper.autoplay.stop();
        });

        testimonialWrapper.addEventListener('mouseleave', () => {
            // Only restart if not manually controlled
            if (!autoplayTimer) {
                testimonialSwiper.autoplay.start();
                if (testimonialImagesSwiper) testimonialImagesSwiper.autoplay.start();
            }
        });
    }

    // NEW: Enhanced keyboard navigation for arrow keys
    document.addEventListener('keydown', function(e) {
        const carousel = document.querySelector('.testimonial-carousel');
        if (!carousel) return;
        
        // Check if carousel is in viewport
        const rect = carousel.getBoundingClientRect();
        const isInViewport = rect.top < window.innerHeight && rect.bottom > 0;
        
        if (isInViewport) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                testimonialSwiper.slidePrev();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                testimonialSwiper.slideNext();
            }
        }
    });

    // NEW: Add click tracking for arrow buttons (optional)
    document.querySelector('.testimonial-prev')?.addEventListener('click', function() {
        console.log('Previous testimonial button clicked');
        // Add your analytics tracking here if needed
    });

    document.querySelector('.testimonial-next')?.addEventListener('click', function() {
        console.log('Next testimonial button clicked');
        // Add your analytics tracking here if needed
    });

    // NEW: Mobile navigation event listeners
    document.querySelector('.testimonial-prev-mobile')?.addEventListener('click', function() {
        testimonialSwiper.slidePrev();
    });

    document.querySelector('.testimonial-next-mobile')?.addEventListener('click', function() {
        testimonialSwiper.slideNext();
    });
}

// Keep your existing initCounterAnimation function unchanged
function initCounterAnimation() {
    const animateCounters = () => {
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200; // Animation duration

        counters.forEach(counter => {
            const animate = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animate, 10);
                } else {
                    counter.innerText = target;
                }
            };

            // Start animation when element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && counter.innerText === '0') {
                        animate();
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    };

    animateCounters();
}

// ========================================
// CATEGORY PAGE SPECIFIC
// ========================================

function initCategoryPage() {
    // Add parallax effect to header background
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const headerBg = document.querySelector('.category-bg-image');
        
        if (headerBg && scrolled < window.innerHeight) {
            headerBg.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
}

// ========================================
// EVENT PAGE SPECIFIC
// ========================================

function initGallerySection() {
    // Generate background particles for gallery
    const particlesContainer = document.getElementById('particlesContainer');
    if (!particlesContainer) return;
    
    const particleCount = 50;
    const sizes = ['small', 'medium', 'large'];
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = `particle ${sizes[Math.floor(Math.random() * sizes.length)]}`;
        
        // Random horizontal position
        particle.style.left = Math.random() * 100 + '%';
        
        // Random animation delay
        particle.style.animationDelay = Math.random() * 25 + 's';
        
        // Random opacity
        particle.style.opacity = Math.random() * 0.4 + 0.1;
        
        particlesContainer.appendChild(particle);
    }
}

function initLightbox() {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const galleryItems = document.querySelectorAll('.gallery-item');
    let currentIndex = 0;

    // Gallery data
    const galleryData = [];
    galleryItems.forEach((item, index) => {
        const img = item.querySelector('.gallery-image');
        const caption = item.querySelector('.gallery-caption').textContent;
        galleryData.push({
            src: img.src,
            alt: img.alt,
            caption: caption
        });
        
        item.addEventListener('click', () => openLightbox(index));
    });

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    window.closeLightbox = function() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    window.navigateLightbox = function(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = galleryData.length - 1;
        if (currentIndex >= galleryData.length) currentIndex = 0;
        updateLightbox();
    }

    function updateLightbox() {
        const item = galleryData[currentIndex];
        lightboxImage.src = item.src;
        lightboxImage.alt = item.alt;
        lightboxCaption.textContent = item.caption;
    }

    // Close lightbox on clicking outside
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    });
}

function initSparkles() {
    // Generate sparkles continuously
    function generateSparkle() {
        const sparklesContainer = document.querySelector('.sparkles');
        if (sparklesContainer) {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            sparkle.style.left = Math.random() * 100 + '%';
            sparklesContainer.appendChild(sparkle);
            
            setTimeout(() => {
                sparkle.remove();
            }, 4000);
        }
    }

    // Generate new sparkles every 500ms
    setInterval(generateSparkle, 500);
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Play video function
window.playVideo = function() {
    alert('Video player would open here');
}

// Location card hover effects
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.location-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.borderColor = 'var(--primary-purple)';
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 20px 40px rgba(147, 51, 234, 0.2)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.borderColor = 'var(--border-color)';
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});

// ========================================
// BLOG SECTION SCRIPTS
// ======================================== 

// Blog Section Initialization
function initBlogSection() {
    // Add ripple effect on blog card click
    const blogCards = document.querySelectorAll('.blog-card');
    
    blogCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') return; // Don't trigger on link clicks
            
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                background: radial-gradient(circle, rgba(147, 51, 234, 0.3) 0%, transparent 70%);
                width: 300px;
                height: 300px;
                left: ${x - 150}px;
                top: ${y - 150}px;
                transform: scale(0);
                border-radius: 50%;
                pointer-events: none;
                z-index: 100;
                transition: transform 0.8s ease-out, opacity 0.8s ease-out;
            `;
            
            this.style.position = 'relative';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.style.transform = 'scale(2)';
                ripple.style.opacity = '0';
            }, 10);
            
            setTimeout(() => {
                ripple.remove();
            }, 800);
        });
    });
    
    // Parallax effect for decoration circles
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const decoration1 = document.querySelector('.decoration-1');
        const decoration2 = document.querySelector('.decoration-2');
        
        if (decoration1) {
            decoration1.style.transform = `translate(${scrolled * 0.1}px, ${scrolled * 0.05}px)`;
        }
        
        if (decoration2) {
            decoration2.style.transform = `translate(-${scrolled * 0.1}px, -${scrolled * 0.05}px)`;
        }
    });
    
    // Add hover effect to featured post
    const featuredPost = document.querySelector('.featured-post');
    if (featuredPost) {
        featuredPost.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });
        
        featuredPost.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
    
    // Animate blog meta items on hover
    document.querySelectorAll('.blog-meta span').forEach(meta => {
        meta.addEventListener('mouseenter', function() {
            this.style.color = 'var(--secondary-purple)';
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        meta.addEventListener('mouseleave', function() {
            this.style.color = 'var(--medium-gray)';
            this.style.transform = 'translateX(0)';
        });
    });
}


// ========================================
// CONTACT FORM AJAX - Add this section to your existing scripts.js
// ========================================

function initContactFormAjax() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    const formMessages = document.getElementById('formMessages');
    const alertDiv = formMessages.querySelector('.alert');
    const alertIcon = formMessages.querySelector('.alert-icon');
    const alertMessage = formMessages.querySelector('.alert-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearContactErrors();
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').textContent = 'Sending...';
        submitBtn.querySelector('i').className = 'fas fa-spinner fa-spin me-2';
        
        // Create FormData object
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showContactMessage('success', data.message);
                
                // Reset form
                form.reset();
                
                // Optionally scroll to message
                formMessages.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Optional: Add success animation
                playSuccessAnimation();
            } else {
                // Show error message
                showContactMessage('danger', data.message || 'An error occurred. Please try again.');
                
                // Show field errors if any
                if (data.errors) {
                    showFieldErrors(data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showContactMessage('danger', 'An unexpected error occurred. Please try again later.');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').textContent = 'Send Message';
            submitBtn.querySelector('i').className = 'fas fa-paper-plane me-2';
        });
    });
    
    function showContactMessage(type, message) {
        alertDiv.className = `alert alert-${type}`;
        alertIcon.className = type === 'success' ? 'fas fa-check-circle me-2' : 'fas fa-exclamation-circle me-2';
        alertMessage.textContent = message;
        formMessages.style.display = 'block';
        
        // Auto-hide success message after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                formMessages.style.display = 'none';
            }, 5000);
        }
    }
    
    function showFieldErrors(errors) {
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[field][0];
                }
            }
        });
    }
    
    function clearContactErrors() {
        // Hide message div
        formMessages.style.display = 'none';
        
        // Clear field errors
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        
        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.textContent = '';
        });
    }
    
    // Clear errors when user starts typing
    form.querySelectorAll('input, textarea, select').forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = '';
                }
            }
        });
    });
    
    // Optional: Add success animation
    function playSuccessAnimation() {
        // Add a subtle pulse to the form
        form.style.animation = 'pulse 0.5s ease-in-out';
        setTimeout(() => {
            form.style.animation = '';
        }, 500);
    }
}