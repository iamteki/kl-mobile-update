// ========================================
// SINGLE BLOG PAGE SCRIPTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initReadingProgress();
    initShareButtons();
    initCommentForm();
    initSmoothScroll();
    initImageLightbox();
    initSidebarSticky();
});

// ========================================
// READING PROGRESS BAR
// ========================================

function initReadingProgress() {
    const progressBar = document.querySelector('.reading-progress-bar');
    const blogContent = document.querySelector('.blog-content');
    
    if (!progressBar || !blogContent) return;
    
    window.addEventListener('scroll', () => {
        const contentTop = blogContent.offsetTop;
        const contentHeight = blogContent.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrolled = window.scrollY;
        
        // Calculate progress
        const scrollableHeight = contentHeight - windowHeight + contentTop;
        let progress = ((scrolled - contentTop) / scrollableHeight) * 100;
        
        // Limit progress between 0 and 100
        progress = Math.max(0, Math.min(100, progress));
        
        // Update progress bar
        progressBar.style.width = progress + '%';
    });
}

// ========================================
// SHARE BUTTONS
// ========================================

function initShareButtons() {
    const shareButtons = document.querySelectorAll('.share-btn');
    const pageUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(document.querySelector('.blog-main-title').textContent);
    
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            let shareUrl = '';
            const platform = this.className.split(' ')[1];
            
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${pageTitle}%20${pageUrl}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${pageTitle}&body=Check out this article: ${pageUrl}`;
                    break;
            }
            
            if (shareUrl) {
                if (platform === 'email') {
                    window.location.href = shareUrl;
                } else {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            }
            
            // Add animation
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });
}

// ========================================
// COMMENT FORM
// ========================================

function initCommentForm() {
    const commentForm = document.querySelector('.comment-form');
    const replyButtons = document.querySelectorAll('.reply-btn');
    
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = this.querySelector('input[type="text"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const comment = this.querySelector('textarea').value;
            
            // Create new comment element
            const newComment = createCommentElement(name, comment);
            
            // Add to comments list
            const commentsList = document.querySelector('.comments-list');
            commentsList.insertBefore(newComment, commentsList.firstChild);
            
            // Reset form
            this.reset();
            
            // Show success message
            showNotification('Comment posted successfully!');
        });
    }
    
    // Reply functionality
    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentItem = this.closest('.comment-item');
            
            // Create reply form if not exists
            if (!commentItem.querySelector('.reply-form')) {
                const replyForm = createReplyForm();
                commentItem.appendChild(replyForm);
            } else {
                // Toggle reply form
                const replyForm = commentItem.querySelector('.reply-form');
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            }
        });
    });
}

// Create comment element
function createCommentElement(name, text) {
    const comment = document.createElement('div');
    comment.className = 'comment-item';
    comment.style.opacity = '0';
    
    comment.innerHTML = `
        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=6366F1&color=fff" alt="${name}" class="comment-avatar">
        <div class="comment-content">
            <div class="comment-header">
                <h5>${name}</h5>
                <span class="comment-date">Just now</span>
            </div>
            <p>${text}</p>
            <button class="reply-btn">Reply</button>
        </div>
    `;
    
    // Animate in
    setTimeout(() => {
        comment.style.transition = 'all 0.5s ease';
        comment.style.opacity = '1';
    }, 100);
    
    return comment;
}

// Create reply form
function createReplyForm() {
    const form = document.createElement('div');
    form.className = 'reply-form';
    
    form.innerHTML = `
        <form class="comment-form">
            <textarea class="form-control" rows="3" placeholder="Write your reply..." required></textarea>
            <div class="reply-form-buttons">
                <button type="submit" class="submit-comment">Post Reply</button>
                <button type="button" class="cancel-reply">Cancel</button>
            </div>
        </form>
    `;
    
    // Cancel button
    form.querySelector('.cancel-reply').addEventListener('click', function() {
        form.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => form.remove(), 300);
    });
    
    // Handle reply form submission
    form.querySelector('.comment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const replyText = this.querySelector('textarea').value;
        const name = 'Guest User'; // In a real app, you'd get this from logged-in user
        
        // Create reply comment
        const replyComment = createCommentElement(name, replyText);
        replyComment.classList.add('reply');
        
        // Insert after the parent comment
        const parentComment = form.closest('.comment-item');
        parentComment.parentNode.insertBefore(replyComment, parentComment.nextSibling);
        
        // Remove form
        form.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => form.remove(), 300);
        
        // Show success
        showNotification('Reply posted successfully!');
    });
    
    return form;
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--gradient-purple);
        color: white;
        padding: 15px 30px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(147, 51, 234, 0.4);
        z-index: 1000;
        animation: slideInRight 0.5s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.5s ease';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// ========================================
// SMOOTH SCROLL
// ========================================

function initSmoothScroll() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ========================================
// IMAGE LIGHTBOX
// ========================================

function initImageLightbox() {
    const blogImages = document.querySelectorAll('.blog-img');
    
    blogImages.forEach(img => {
        img.style.cursor = 'zoom-in';
        
        img.addEventListener('click', function() {
            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'image-lightbox';
            lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.95);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                cursor: zoom-out;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            const imgClone = this.cloneNode();
            imgClone.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                border-radius: 8px;
                transform: scale(0.8);
                transition: transform 0.3s ease;
            `;
            
            lightbox.appendChild(imgClone);
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            // Animate in
            setTimeout(() => {
                lightbox.style.opacity = '1';
                imgClone.style.transform = 'scale(1)';
            }, 10);
            
            // Close on click
            lightbox.addEventListener('click', function() {
                lightbox.style.opacity = '0';
                imgClone.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    lightbox.remove();
                    document.body.style.overflow = '';
                }, 300);
            });
        });
    });
}

// ========================================
// SIDEBAR STICKY
// ========================================

function initSidebarSticky() {
    const sidebar = document.querySelector('.blog-sidebar');
    if (!sidebar) return;
    
    // Check if screen is desktop
    if (window.innerWidth <= 992) return;
    
    const sidebarTop = sidebar.offsetTop;
    const sidebarHeight = sidebar.offsetHeight;
    
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const navbarHeight = 100; // Adjust based on your navbar height
        
        if (scrolled > sidebarTop - navbarHeight) {
            sidebar.style.position = 'sticky';
            sidebar.style.top = navbarHeight + 'px';
        }
    });
}

// ========================================
// ANIMATIONS
// ========================================

// Animate elements on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '0';
            entry.target.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                entry.target.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, 100);
            
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe elements
document.querySelectorAll('.feature-item, .stat-card, .related-post-card').forEach(el => {
    observer.observe(el);
});

// Add animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);