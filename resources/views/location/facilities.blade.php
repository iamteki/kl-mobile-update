<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        <img src="" alt="" class="lightbox-image" id="lightboxImage">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

<!-- Office Facilities Section -->
<section class="facilities-section">
    <div class="container">
        <div class="section-area text-center">
            <span>- OFFICE FACILITIES -</span>
            <h2 class="fs-two text-white">EXPLORE OUR <span>WORKSPACE</span></h2>
        </div>

            <div class="gallery-grid">
            <!-- Reception Area -->
            {{-- Display office location image gallery --}}
            @if ($location->image_gallery && is_array($location->image_gallery))
                @foreach ($location->image_gallery as $index => $image)
                    <div class="gallery-item" data-index="{{ $index }}">
                        <img src="{{ Storage::url($image) }}" alt="Gallery Image {{ $index + 1 }}" class="gallery-image"
                            onerror="this.src='https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&h=600&fit=crop'">
                        <div class="gallery-overlay">
                            <span class="gallery-caption"></span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Office Features -->
        <div class="office-features-row">
            <div class="feature-box">
                <i class="fas fa-wifi"></i>
                <h5>High-Speed WiFi</h5>
                <p>Gigabit internet connectivity</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-parking"></i>
                <h5>Valet Parking</h5>
                <p>Complimentary valet service</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-shield-alt"></i>
                <h5>24/7 Security</h5>
                <p>Round-the-clock security</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-wheelchair"></i>
                <h5>Accessible</h5>
                <p>Fully wheelchair accessible</p>
            </div>
        </div>
    </div>
</section>
