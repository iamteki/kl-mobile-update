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



<!-- Gallery Section - Enhanced with particles -->
<section class="gallery-section">
    <!-- Background Particles Container -->
    <div class="gallery-particles" id="particlesContainer"></div>

    <div class="container">
        <div class="section-area">
            <span data-animscroll="fade-up">- GALLERY -</span>
            <h2 data-animscroll="fade-up" class="fs-two">MEMORABLE MOMENTS</h2>
        </div>
        <div class="gallery-grid">

            @if ($event->image_gallery && is_array($event->image_gallery))
                @foreach ($event->image_gallery as $index => $image)
                    <div class="gallery-item" data-index="{{ $index }}" data-animscroll="fade-up" data-animscroll-delay="{{ $index * 100 }}"
                         onclick="openLightbox('{{ Storage::url($image) }}', '{{ $event->title }}')">
                        <img src="{{ Storage::url($image) }}" alt="Gallery Image {{ $index + 1 }}"
                            class="gallery-image"
                            onerror="this.src='https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&h=600&fit=crop'">
                        <div class="gallery-overlay">
                            <span class="gallery-caption">{{$event->title}}</span>
                        </div>
                    </div>
                @endforeach
            @endif



        </div>
    </div>
</section>
