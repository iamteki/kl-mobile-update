<!-- Enhanced Services Section with Image Cards and Hover Effects -->
<section id="services" class="section-padding light-bg">
    <div class="container position-relative">
        <div class="section-area text-center">
            <!-- Add your section title here if needed -->
        </div>
        <div class="row g-4 mt-5">
            @foreach ($eventTypes as $key => $event)
                <div class="col-12 col-md-6 col-lg-4" data-animscroll="fade-up" data-animscroll-delay="{{ $key * 100 }}">
                    <a href="{{ route('events.byType', $event->slug) }}" class="event-category-card-link">
                        <div class="event-category-card">
                            <!-- Image Container -->
                            <div class="event-category-image-wrapper">
                                <img src="{{ $event->display_image }}" 
                                     alt="{{ $event->image_alt_text }}" 
                                     class="event-category-image"
                                     loading="lazy">
                                
                                <!-- Dark Overlay -->
                                <div class="event-category-overlay"></div>
                            </div>
                            
                            <!-- Content Container -->
                            <div class="event-category-content">
                                <h5 class="event-category-title">{{ $event->name }}</h5>
                                <button class="event-category-btn" type="button">
                                    View More <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>