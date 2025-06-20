// ========================================
// BLOG PAGE SPECIFIC SCRIPTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize blog page components
    initBlogFilters();
    initBlogSearch();
    initLoadMore();
    initBlogAnimations();
    initNewsletterForm();
});

// ========================================
// BLOG FILTERS
// ========================================

function initBlogFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const blogPosts = document.querySelectorAll('.blog-post-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Filter posts with animation
            blogPosts.forEach((post, index) => {
                const postCategory = post.getAttribute('data-category');
                
                if (filterValue === 'all' || postCategory === filterValue) {
                    // Show post with staggered animation
                    setTimeout(() => {
                        post.style.display = 'block';
                        post.style.opacity = '0';
                        post.style.transform = 'translateY(30px)';
                        
                        setTimeout(() => {
                            post.style.transition = 'all 0.5s ease';
                            post.style.opacity = '1';
                            post.style.transform = 'translateY(0)';
                        }, 50);
                    }, index * 100);
                } else {
                    // Hide post
                    post.style.opacity = '0';
                    post.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        post.style.display = 'none';
                    }, 300);
                }
            });
            
            // Add ripple effect to button
            createRipple(this, event);
        });
    });
}

// ========================================
// BLOG SEARCH
// ========================================

function initBlogSearch() {
    const searchInput = document.querySelector('.blog-search-input');
    const searchBtn = document.querySelector('.blog-search-btn');
    const blogPosts = document.querySelectorAll('.blog-post-card');
    
    if (!searchInput) return;
    
    // Search functionality
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;
        
        blogPosts.forEach((post, index) => {
            const title = post.querySelector('.post-title, .featured-title')?.textContent.toLowerCase() || '';
            const excerpt = post.querySelector('.post-excerpt, .featured-excerpt')?.textContent.toLowerCase() || '';
            const category = post.querySelector('.post-category')?.textContent.toLowerCase() || '';
            
            if (title.includes(searchTerm) || excerpt.includes(searchTerm) || category.includes(searchTerm)) {
                // Show matching posts
                setTimeout(() => {
                    post.style.display = 'block';
                    post.style.opacity = '0';
                    post.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        post.style.transition = 'all 0.5s ease';
                        post.style.opacity = '1';
                        post.style.transform = 'translateY(0)';
                    }, 50);
                }, visibleCount * 100);
                visibleCount++;
            } else {
                // Hide non-matching posts
                post.style.opacity = '0';
                post.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    post.style.display = 'none';
                }, 300);
            }
        });
        
        // Reset filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');
    }
    
    // Event listeners
    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        performSearch();
    });
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });
    
    // Live search with debounce
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500);
    });
}

// ========================================
// LOAD MORE FUNCTIONALITY
// ========================================

function initLoadMore() {
    const loadMoreBtn = document.querySelector('.load-more-btn');
    const pagination = document.querySelector('.blog-pagination');
    
    if (!loadMoreBtn) return;
    
    let isLoading = false;
    
    loadMoreBtn.addEventListener('click', function() {
        if (isLoading) return;
        
        isLoading = true;
        this.classList.add('loading');
        
        // Simulate loading new posts
        setTimeout(() => {
            // In a real application, you would fetch new posts here
            const postsContainer = document.querySelector('.blog-posts-section .row');
            const newPostsHTML = generateDummyPosts(3);
            
            // Add new posts to the DOM
            postsContainer.insertAdjacentHTML('beforeend', newPostsHTML);
            
            // Animate new posts
            const newPosts = postsContainer.querySelectorAll('.blog-post-card:not(.animated)');
            newPosts.forEach((post, index) => {
                post.classList.add('animated');
                post.style.opacity = '0';
                post.style.transform = 'translateY(50px)';
                
                setTimeout(() => {
                    post.style.transition = 'all 0.8s ease';
                    post.style.opacity = '1';
                    post.style.transform = 'translateY(0)';
                }, index * 150);
            });
            
            // Update button state
            this.classList.remove('loading');
            isLoading = false;
            
            // Show pagination after loading enough posts
            const totalPosts = document.querySelectorAll('.blog-post-card').length;
            if (totalPosts > 12) {
                this.style.display = 'none';
                pagination.style.display = 'block';
            }
        }, 1500);
    });
}

// Generate dummy posts for demo
function generateDummyPosts(count) {
    const categories = ['trends', 'technology', 'planning', 'tips'];
    const images = [
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=600&h=400&fit=crop',
        'https://images.unsplash.com/photo-1560439514-4e9645039924?w=600&h=400&fit=crop',
        'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&h=400&fit=crop'
    ];
    
    let html = '';
    
    for (let i = 0; i < count; i++) {
        const category = categories[Math.floor(Math.random() * categories.length)];
        const image = images[i % images.length];
        
        html += `
            <div class="col-lg-4 col-md-6">
                <article class="blog-post-card" data-category="${category}">
                    <div class="post-image-wrapper">
                        <img src="${image}" alt="New Post ${i + 1}" class="post-image">
                        <div class="post-overlay">
                            <a href="#" class="overlay-link">Read More</a>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-category">${category.charAt(0).toUpperCase() + category.slice(1)}</div>
                        <h3 class="post-title">
                            <a href="#">New Blog Post Title ${i + 1}</a>
                        </h3>
                        <p class="post-excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore...</p>
                        <div class="post-footer">
                            <span class="post-date">January ${20 + i}, 2025</span>
                            <span class="post-read-time">${5 + i} min read</span>
                        </div>
                    </div>
                </article>
            </div>
        `;
    }
    
    return html;
}

// ========================================
// BLOG ANIMATIONS
// ========================================

function initBlogAnimations() {
    // Animate posts on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                setTimeout(() => {
                    entry.target.classList.add('animated');
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(50px)';
                    
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });
    
    // Observe all blog posts
    document.querySelectorAll('.blog-post-card').forEach(post => {
        observer.observe(post);
    });
    
    // Parallax effect for header elements
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroBg = document.querySelector('.blog-hero-bg');
        const decorativeLines = document.querySelectorAll('.decorative-line');
        
        if (heroBg && scrolled < window.innerHeight) {
            heroBg.style.transform = `scale(1.1) translateY(${scrolled * 0.3}px)`;
        }
        
        decorativeLines.forEach((line, index) => {
            const speed = 0.2 * (index + 1);
            line.style.transform = `translateX(${scrolled * speed}px)`;
        });
    });
    
    // Add hover effect to post images
    document.querySelectorAll('.blog-post-card').forEach(card => {
        const image = card.querySelector('.post-image');
        
        card.addEventListener('mouseenter', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            if (image) {
                image.style.transformOrigin = `${x}px ${y}px`;
            }
        });
        
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            if (image) {
                image.style.transformOrigin = `${x}px ${y}px`;
            }
        });
    });
}



// ========================================
// UTILITY FUNCTIONS
// ========================================

// Create ripple effect
function createRipple(element, event) {
    const rect = element.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
    
    const ripple = document.createElement('div');
    ripple.style.cssText = `
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        width: 0;
        height: 0;
        left: ${x}px;
        top: ${y}px;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        pointer-events: none;
        transition: all 0.6s ease-out;
    `;
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    // Trigger animation
    setTimeout(() => {
        ripple.style.width = '300px';
        ripple.style.height = '300px';
        ripple.style.opacity = '0';
    }, 10);
    
    // Remove ripple
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Create success particles
function createSuccessParticles(element) {
    const rect = element.getBoundingClientRect();
    const particles = 20;
    
    for (let i = 0; i < particles; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: fixed;
            width: 8px;
            height: 8px;
            background: ${Math.random() > 0.5 ? 'var(--primary-purple)' : 'var(--secondary-purple)'};
            border-radius: 50%;
            left: ${rect.left + rect.width / 2}px;
            top: ${rect.top + rect.height / 2}px;
            pointer-events: none;
            z-index: 1000;
        `;
        
        document.body.appendChild(particle);
        
        // Animate particle
        const angle = (Math.PI * 2 * i) / particles;
        const velocity = 100 + Math.random() * 100;
        const duration = 1000 + Math.random() * 1000;
        
        particle.animate([
            {
                transform: 'translate(-50%, -50%) scale(1)',
                opacity: 1
            },
            {
                transform: `translate(calc(-50% + ${Math.cos(angle) * velocity}px), calc(-50% + ${Math.sin(angle) * velocity}px)) scale(0)`,
                opacity: 0
            }
        ], {
            duration: duration,
            easing: 'ease-out'
        });
        
        // Remove particle
        setTimeout(() => {
            particle.remove();
        }, duration);
    }
}

// Add page transition effect
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
    
    // Animate header elements
    const headerElements = document.querySelectorAll('.blog-header-title, .blog-header-subtitle, .blog-search-wrapper');
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