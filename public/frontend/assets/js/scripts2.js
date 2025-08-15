// ========================================
// SHARED SCRIPTS FOR KL MOBILE EVENTS
// ========================================

// Global Variables
let mouseFollower, cursorOutline, cursorDot;
let mouseX = 0, mouseY = 0;
let outlineX = 0, outlineY = 0;
let dotX = 0, dotY = 0;
let klTestimonialSwiper; // New testimonial swiper instance

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
    
    if (document.querySelector('.clients-swiper-main') || document.querySelector('.clients-swiper-reverse')) {
        initClientsSwiper();
    } else if (document.querySelector('.clients-section')) {
        initClientsSection();
    }
    
    // NEW CLEAN TESTIMONIAL INITIALIZATION
    if (document.querySelector('.kl-testimonial-swiper')) {
        initKLTestimonials();
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
// NEW CLEAN TESTIMONIAL CAROUSEL
// ========================================

function initKLTestimonials() {
    const testimonialElement = document.querySelector('.kl-testimonial-swiper');
    if (!testimonialElement) return;

    // Initialize the new testimonial swiper
    klTestimonialSwiper = new Swiper('.kl-testimonial-swiper', {
        // Base configuration
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        centeredSlides: false,
        autoHeight: false, // Disable auto height to maintain uniform heights
        
        // Auto-play configuration
        autoplay: {
            delay: 4000,
            disableOnInteraction: false, // Don't permanently disable on interaction
            pauseOnMouseEnter: true,
            stopOnLastSlide: false,
            waitForTransition: true // Wait for transition to complete before continuing
        },
        
        // Navigation arrows configuration
        navigation: {
            nextEl: '.kl-nav-next',
            prevEl: '.kl-nav-prev',
        },
        
        // No pagination - we're using arrows instead
        pagination: false,
        
        // Responsive breakpoints for 3-column layout
        breakpoints: {
            // Mobile: 1 card
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // Tablet: 2 cards
            768: {
                slidesPerView: 2,
                spaceBetween: 25
            },
            // Desktop: 3 cards
            1200: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        
        // Smooth transitions
        speed: 800,
        
        // Effects
        effect: 'slide',
        
        // Grab cursor
        grabCursor: true,
        
        // Keyboard navigation
        keyboard: {
            enabled: true,
            onlyInViewport: true
        },
        
        // Observer for dynamic content
        observer: true,
        observeParents: true,
        
        // Ensure equal heights
        watchSlidesProgress: true,
        watchSlidesVisibility: true,
        
        // Events
        on: {
            init: function() {
                console.log('KL Testimonial carousel initialized with arrow navigation');
                // Ensure proper height calculation
                this.update();
                
                // Equal heights for all cards
                equalizeCardHeights();
                
                // Add accessibility attributes
                const prevBtn = document.querySelector('.kl-nav-prev');
                const nextBtn = document.querySelector('.kl-nav-next');
                
                if (prevBtn && nextBtn) {
                    prevBtn.setAttribute('tabindex', '0');
                    nextBtn.setAttribute('tabindex', '0');
                }
            },
            
            slideChange: function() {
                // Animate quote icon on slide change
                const activeSlides = this.slides.filter((slide, index) => {
                    return index >= this.activeIndex && index < this.activeIndex + this.params.slidesPerView;
                });
                
                activeSlides.forEach(slide => {
                    const quoteIcon = slide.querySelector('.kl-quote-icon');
                    if (quoteIcon) {
                        quoteIcon.style.transform = 'scale(0.8) rotate(0deg)';
                        setTimeout(() => {
                            quoteIcon.style.transform = 'scale(1) rotate(-5deg)';
                        }, 200);
                    }
                });
                
                // Animate stars on slide change
                activeSlides.forEach(slide => {
                    const stars = slide.querySelectorAll('.kl-rating-stars i.active');
                    stars.forEach((star, index) => {
                        star.style.animation = 'none';
                        setTimeout(() => {
                            star.style.animation = 'klStarPulse 0.5s ease-in-out';
                        }, index * 50);
                    });
                });
            },
            
            navigationPrev: function() {
                // Reset autoplay timer when manually navigating
                this.autoplay.stop();
                this.autoplay.start();
                
                // Add click feedback to prev button
                const prevBtn = document.querySelector('.kl-nav-prev');
                if (prevBtn) {
                    prevBtn.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        prevBtn.style.transform = '';
                    }, 200);
                }
            },
            
            navigationNext: function() {
                // Reset autoplay timer when manually navigating
                this.autoplay.stop();
                this.autoplay.start();
                
                // Add click feedback to next button
                const nextBtn = document.querySelector('.kl-nav-next');
                if (nextBtn) {
                    nextBtn.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        nextBtn.style.transform = '';
                    }, 200);
                }
            },
            
            touchStart: function() {
                // Pause autoplay on touch
                this.autoplay.stop();
            },
            
            touchEnd: function() {
                // Resume autoplay after touch with delay
                setTimeout(() => {
                    this.autoplay.start();
                }, 2000);
            },
            
            resize: function() {
                // Recalculate equal heights on resize
                equalizeCardHeights();
            }
        }
    });

    // Function to equalize card heights
    function equalizeCardHeights() {
        const cards = document.querySelectorAll('.kl-testimonial-card');
        let maxHeight = 0;
        
        // Reset heights first
        cards.forEach(card => {
            card.style.minHeight = '';
        });
        
        // Find max height
        cards.forEach(card => {
            const height = card.offsetHeight;
            if (height > maxHeight) {
                maxHeight = height;
            }
        });
        
        // Apply max height to all cards
        if (maxHeight > 0) {
            cards.forEach(card => {
                card.style.minHeight = maxHeight + 'px';
            });
        }
    }
    
    // Manual arrow click handlers with proper timer reset
    const prevBtn = document.querySelector('.kl-nav-prev');
    const nextBtn = document.querySelector('.kl-nav-next');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            // Stop and restart autoplay to reset timer
            if (klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                klTestimonialSwiper.autoplay.stop();
                // Small delay before restarting to ensure smooth transition
                setTimeout(() => {
                    klTestimonialSwiper.autoplay.start();
                }, 100);
            }
        });
        
        // Keyboard support
        prevBtn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                klTestimonialSwiper.slidePrev();
                // Reset autoplay timer
                if (klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                    klTestimonialSwiper.autoplay.stop();
                    setTimeout(() => {
                        klTestimonialSwiper.autoplay.start();
                    }, 100);
                }
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            // Stop and restart autoplay to reset timer
            if (klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                klTestimonialSwiper.autoplay.stop();
                // Small delay before restarting to ensure smooth transition
                setTimeout(() => {
                    klTestimonialSwiper.autoplay.start();
                }, 100);
            }
        });
        
        // Keyboard support
        nextBtn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                klTestimonialSwiper.slideNext();
                // Reset autoplay timer
                if (klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                    klTestimonialSwiper.autoplay.stop();
                    setTimeout(() => {
                        klTestimonialSwiper.autoplay.start();
                    }, 100);
                }
            }
        });
    }

    // Additional hover pause functionality
    const testimonialContainer = document.querySelector('.kl-testimonial-container');
    if (testimonialContainer && klTestimonialSwiper) {
        let isHovering = false;
        let autoplayTimeout = null;
        
        testimonialContainer.addEventListener('mouseenter', () => {
            isHovering = true;
            if (klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                klTestimonialSwiper.autoplay.stop();
            }
            // Clear any pending timeout
            if (autoplayTimeout) {
                clearTimeout(autoplayTimeout);
                autoplayTimeout = null;
            }
        });
        
        testimonialContainer.addEventListener('mouseleave', () => {
            isHovering = false;
            // Add small delay before resuming autoplay
            if (autoplayTimeout) {
                clearTimeout(autoplayTimeout);
            }
            autoplayTimeout = setTimeout(() => {
                if (!isHovering && klTestimonialSwiper && klTestimonialSwiper.autoplay) {
                    klTestimonialSwiper.autoplay.start();
                }
            }, 500);
        });
    }

    // Ensure swiper updates on window resize
    window.addEventListener('resize', () => {
        if (klTestimonialSwiper) {
            klTestimonialSwiper.update();
            equalizeCardHeights();
        }
    });
    
    // Initial height equalization after a short delay
    setTimeout(() => {
        equalizeCardHeights();
    }, 100);
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

function initCounterAnimation() {
    const animateCounters = () => {
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

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
    const particlesContainer = document.getElementById('particlesContainer');
    if (!particlesContainer) return;
    
    const particleCount = 50;
    const sizes = ['small', 'medium', 'large'];
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = `particle ${sizes[Math.floor(Math.random() * sizes.length)]}`;
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 25 + 's';
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

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    });
}

function initSparkles() {
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

    setInterval(generateSparkle, 500);
}

// ========================================
// BLOG SECTION SCRIPTS
// ======================================== 

function initBlogSection() {
    const blogCards = document.querySelectorAll('.blog-card');
    
    blogCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') return;
            
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
    
    const featuredPost = document.querySelector('.featured-post');
    if (featuredPost) {
        featuredPost.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });
        
        featuredPost.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
    
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
// CONTACT FORM AJAX
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
        
        clearContactErrors();
        
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').textContent = 'Sending...';
        submitBtn.querySelector('i').className = 'fas fa-spinner fa-spin me-2';
        
        const formData = new FormData(form);
        
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
                showContactMessage('success', data.message);
                form.reset();
                formMessages.scrollIntoView({ behavior: 'smooth', block: 'center' });
                playSuccessAnimation();
            } else {
                showContactMessage('danger', data.message || 'An error occurred. Please try again.');
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
        formMessages.style.display = 'none';
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.textContent = '';
        });
    }
    
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
    
    function playSuccessAnimation() {
        form.style.animation = 'pulse 0.5s ease-in-out';
        setTimeout(() => {
            form.style.animation = '';
        }, 500);
    }
}

// ========================================
// CLIENT LOGOS SWIPER IMPLEMENTATION
// ========================================

let clientsMainSwiper, clientsReverseSwiper;

function initClientsSwiper() {
    const mainSwiperEl = document.querySelector('.clients-swiper-main');
    const reverseSwiperEl = document.querySelector('.clients-swiper-reverse');
    
    if (!mainSwiperEl && !reverseSwiperEl) return;

    if (mainSwiperEl) {
        clientsMainSwiper = new Swiper('.clients-swiper-main', {
            slidesPerView: 'auto',
            spaceBetween: 0,
            speed: 3000,
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
            },
            freeMode: {
                enabled: true,
                momentum: false,
            },
            grabCursor: false,
            allowTouchMove: false,
            simulateTouch: false,
            centeredSlides: false,
            watchSlidesProgress: true,
            preventInteractionOnTransition: true,
            breakpoints: {
                320: {
                    speed: 2000,
                },
                768: {
                    speed: 2500,
                },
                1024: {
                    speed: 3000,
                },
            },
            on: {
                init: function() {
                    console.log('Main clients swiper initialized');
                },
                progress: function() {
                    this.wrapperEl.style.transitionTimingFunction = 'linear';
                }
            }
        });
    }

    if (reverseSwiperEl) {
        clientsReverseSwiper = new Swiper('.clients-swiper-reverse', {
            slidesPerView: 'auto',
            spaceBetween: 0,
            speed: 3000,
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
                reverseDirection: true,
            },
            freeMode: {
                enabled: true,
                momentum: false,
            },
            grabCursor: false,
            allowTouchMove: false,
            simulateTouch: false,
            centeredSlides: false,
            watchSlidesProgress: true,
            preventInteractionOnTransition: true,
            breakpoints: {
                320: {
                    speed: 2000,
                },
                768: {
                    speed: 2500,
                },
                1024: {
                    speed: 3000,
                },
            },
            on: {
                init: function() {
                    console.log('Reverse clients swiper initialized');
                },
                progress: function() {
                    this.wrapperEl.style.transitionTimingFunction = 'linear';
                }
            }
        });
    }

    initClientsSwiperHoverEffects();
}

function initClientsSwiperHoverEffects() {
    document.querySelectorAll('.client-logo-swiper-wrapper').forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            if (clientsMainSwiper) {
                clientsMainSwiper.autoplay.pause();
            }
            if (clientsReverseSwiper) {
                clientsReverseSwiper.autoplay.pause();
            }

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
                z-index: 10;
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

        card.addEventListener('mouseleave', function() {
            if (clientsMainSwiper) {
                clientsMainSwiper.autoplay.resume();
            }
            if (clientsReverseSwiper) {
                clientsReverseSwiper.autoplay.resume();
            }
        });
    });

    const mainContainer = document.querySelector('.clients-swiper-main');
    const reverseContainer = document.querySelector('.clients-swiper-reverse');

    [mainContainer, reverseContainer].forEach(container => {
        if (!container) return;

        container.addEventListener('mouseenter', () => {
            if (clientsMainSwiper) clientsMainSwiper.autoplay.pause();
            if (clientsReverseSwiper) clientsReverseSwiper.autoplay.pause();
        });

        container.addEventListener('mouseleave', () => {
            if (clientsMainSwiper) clientsMainSwiper.autoplay.resume();
            if (clientsReverseSwiper) clientsReverseSwiper.autoplay.resume();
        });
    });
}

function reinitializeClientsSwipers() {
    if (clientsMainSwiper) {
        clientsMainSwiper.destroy(true, true);
    }
    if (clientsReverseSwiper) {
        clientsReverseSwiper.destroy(true, true);
    }
    
    setTimeout(() => {
        initClientsSwiper();
    }, 100);
}

let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        reinitializeClientsSwipers();
    }, 250);
});

// ========================================
// UTILITY FUNCTIONS
// ========================================

window.playVideo = function() {
    alert('Video player would open here');
}

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

// Export functions
window.initClientsSwiper = initClientsSwiper;
window.initKLTestimonials = initKLTestimonials;

// Auto-initialize if DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initClientsSwiper();
        initKLTestimonials();
    });
} else {
    initClientsSwiper();
    initKLTestimonials();
}