// ========================================
// LOCATION PAGE SCRIPTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all location page components
    initLocationAnimations();
    initEquipmentGallery();
    initTeamInteractions();
    initFaqAccordion();
    initMapInteractions();
    initTransportTabs();
});

// ========================================
// LOCATION PAGE ANIMATIONS
// ========================================

function initLocationAnimations() {
    // Parallax effect for header
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const headerBg = document.querySelector('.header-bg-img');
        const floatShapes = document.querySelectorAll('.float-shape');
        
        if (headerBg && scrolled < window.innerHeight) {
            headerBg.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
        
        floatShapes.forEach((shape, index) => {
            if (scrolled < window.innerHeight) {
                const speed = 0.2 * (index + 1);
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            }
        });
    });
    
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                setTimeout(() => {
                    entry.target.classList.add('animated');
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            }
        });
    }, observerOptions);
    
    // Observe elements
    const elementsToAnimate = document.querySelectorAll(
        '.feature-item, .stat-item, .equipment-item, .team-member, ' +
        '.facility-card, .value-card, .faq-item, .transport-item, .info-card'
    );
    
    elementsToAnimate.forEach(el => {
        observer.observe(el);
    });
}

// ========================================
// EQUIPMENT GALLERY
// ========================================

function initEquipmentGallery() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const equipmentItems = document.querySelectorAll('.equipment-item');
    
    // Filter functionality
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active state
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Filter items with animation
            equipmentItems.forEach((item, index) => {
                const category = item.getAttribute('data-category');
                
                if (filterValue === 'all' || category === filterValue) {
                    // Show item
                    item.style.display = 'block';
                    item.classList.add('show');
                    
                    // Staggered animation
                    setTimeout(() => {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        
                        setTimeout(() => {
                            item.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 50);
                    }, index * 50);
                } else {
                    // Hide item
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                        item.classList.remove('show');
                    }, 300);
                }
            });
        });
    });
    
    // Equipment item hover effects
    equipmentItems.forEach(item => {
        const overlay = item.querySelector('.equipment-overlay');
        
        item.addEventListener('mouseenter', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            overlay.style.background = `
                radial-gradient(
                    circle at ${x}px ${y}px, 
                    rgba(147, 51, 234, 0.3) 0%, 
                    rgba(0, 0, 0, 0.8) 50%
                )
            `;
        });
        
        item.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            overlay.style.background = `
                radial-gradient(
                    circle at ${x}px ${y}px, 
                    rgba(147, 51, 234, 0.3) 0%, 
                    rgba(0, 0, 0, 0.8) 50%
                )
            `;
        });
    });
}

// ========================================
// TEAM INTERACTIONS
// ========================================

function initTeamInteractions() {
    const teamMembers = document.querySelectorAll('.team-member');
    
    teamMembers.forEach(member => {
        const image = member.querySelector('.member-image img');
        const overlay = member.querySelector('.member-overlay');
        
        // 3D tilt effect on hover
        member.addEventListener('mouseenter', function(e) {
            this.style.transform = 'perspective(1000px) rotateY(5deg)';
        });
        
        member.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateY(0deg)';
        });
        
        // Social links animation
        const socialLinks = member.querySelectorAll('.social-link');
        socialLinks.forEach((link, index) => {
            link.style.transitionDelay = `${index * 0.1}s`;
        });
    });
}

// ========================================
// FAQ ACCORDION
// ========================================

function initFaqAccordion() {
    const faqButtons = document.querySelectorAll('.faq-button');
    
    faqButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const icon = this.querySelector('.faq-icon i');
            
            // Smooth icon rotation
            if (!isExpanded) {
                icon.style.transform = 'rotate(45deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
            
            // Add ripple effect
            createRippleEffect(this, event);
        });
    });
}

// ========================================
// MAP INTERACTIONS
// ========================================

function initMapInteractions() {
    const mapWrapper = document.querySelector('.map-wrapper');
    
    if (mapWrapper) {
        // Add interactive overlay info on map hover
        mapWrapper.addEventListener('mouseenter', function() {
            const overlayInfo = this.querySelector('.map-overlay-info');
            overlayInfo.style.transform = 'scale(1.05)';
            overlayInfo.style.boxShadow = '0 10px 30px rgba(147, 51, 234, 0.4)';
        });
        
        mapWrapper.addEventListener('mouseleave', function() {
            const overlayInfo = this.querySelector('.map-overlay-info');
            overlayInfo.style.transform = 'scale(1)';
            overlayInfo.style.boxShadow = 'none';
        });
    }
}

// ========================================
// TRANSPORT TABS
// ========================================

function initTransportTabs() {
    const transportItems = document.querySelectorAll('.transport-item');
    
    transportItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active from all
            transportItems.forEach(t => {
                t.style.background = 'rgba(147, 51, 234, 0.05)';
                t.style.borderLeft = 'none';
            });
            
            // Add active state
            this.style.background = 'rgba(147, 51, 234, 0.1)';
            this.style.borderLeft = '4px solid var(--primary-purple)';
            
            // Animate icon
            const icon = this.querySelector('.transport-icon');
            icon.style.transform = 'scale(1.1) rotate(360deg)';
            setTimeout(() => {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }, 500);
        });
    });
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Create ripple effect
function createRippleEffect(element, event) {
    const ripple = document.createElement('div');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: radial-gradient(circle, rgba(147, 51, 234, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        transform: scale(0);
        opacity: 1;
        pointer-events: none;
        transition: transform 0.6s ease, opacity 0.6s ease;
    `;
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    // Trigger animation
    setTimeout(() => {
        ripple.style.transform = 'scale(2)';
        ripple.style.opacity = '0';
    }, 10);
    
    // Remove ripple
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Stats counter animation
function animateStats() {
    const stats = document.querySelectorAll('.stat-value');
    
    stats.forEach(stat => {
        const target = parseInt(stat.textContent);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            stat.textContent = Math.floor(current) + (stat.textContent.includes('+') ? '+' : '');
        }, 30);
    });
}

// Initialize stats animation when visible
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            animateStats();
        }
    });
}, { threshold: 0.5 });

const statsSection = document.querySelector('.office-stats');
if (statsSection) {
    statsObserver.observe(statsSection);
}

// Equipment specs modal (placeholder)
document.querySelectorAll('.view-specs').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        // In a real implementation, this would open a modal with equipment specifications
        alert('Equipment specifications modal would open here');
    });
});

// Add smooth reveal animation on page load
window.addEventListener('load', function() {
    // Animate header content
    const headerElements = document.querySelectorAll(
        '.location-badge, .location-main-title, .location-subtitle, .quick-info-row'
    );
    
    headerElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });
});