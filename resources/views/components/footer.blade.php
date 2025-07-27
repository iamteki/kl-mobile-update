<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('frontend/assets/images/kl_logo_final_original.svg')}}" alt="KL Mobile Events" class="footer-logo">
                <p class="text-white-50">Your trusted partner for corporate events and DJ services in Kuala Lumpur</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5 class="mb-3 text-uppercase" style="color: var(--primary-purple);">Follow Us</h5>
                <div class="social-links d-flex flex-wrap justify-content-md-end justify-content-center gap-2">
                    @if(isset($settings) && $settings->hasSocialMediaLinks())
                        {{-- Display social media links from admin settings --}}
                        @foreach($settings->formattedSocialLinks as $platform => $social)
                            <a href="{{ $social['url'] }}" 
                               class="social-icon-small" 
                               aria-label="{{ $social['label'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               title="{{ $social['label'] }}">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                        @endforeach
                    @else
                        {{-- Fallback to hardcoded links if no settings are available --}}
                        <a href="https://www.facebook.com/share/1GFC7f5z4s/?mibextid=wwXIfr" 
                           class="social-icon-small" 
                           aria-label="Facebook"
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/" 
                           class="social-icon-small" 
                           aria-label="Instagram"
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="http://tiktok.com" 
                           class="social-icon-small" 
                           aria-label="TikTok"
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="http://linkedin.com" 
                           class="social-icon-small" 
                           aria-label="LinkedIn"
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <hr class="my-4" style="border-color: var(--border-color);">
        <div class="text-center">
            <p class="mb-0 text-white-50">&copy; {{ date('Y') }} KL Mobile Events. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<style>
/* Enhanced social media icons - Square design for all screen sizes */
.social-icon-small {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 6px; /* Square with slightly rounded corners */
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-icon-small:hover {
    background: var(--primary-purple, #8B5CF6);
    border-color: var(--primary-purple, #8B5CF6);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

/* Responsive adjustments - maintaining square shape */
@media (max-width: 768px) {
    .social-icon-small {
        width: 32px;
        height: 32px;
        font-size: 13px;
        border-radius: 5px; /* Slightly smaller radius for smaller icons */
    }
    
    .social-links {
        margin-top: 15px;
    }
}

@media (max-width: 480px) {
    .social-icon-small {
        width: 30px;
        height: 30px;
        font-size: 12px;
        border-radius: 4px; /* Even smaller radius for mobile */
    }
    
    .social-links {
        gap: 8px !important;
    }
}

@media (max-width: 360px) {
    .social-icon-small {
        width: 28px;
        height: 28px;
        font-size: 11px;
        border-radius: 4px;
    }
    
    .social-links {
        gap: 6px !important;
    }
}

/* Ensure icons stay in one line with proper spacing */
.social-links {
    min-height: 35px;
    align-items: center;
}

/* Override any existing social-icon styles that might conflict */
.social-links .social-icon-small {
    margin: 0;
    flex-shrink: 0;
}
</style>