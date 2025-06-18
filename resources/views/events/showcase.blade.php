    <!-- Event Types Section with Simplified Cards -->
    <section class="section-padding event-types-section">
        <!-- Animated particles only in this section -->
        <div class="particle" style="top: 10%; left: 5%; animation-delay: 0s;"></div>
        <div class="particle" style="top: 20%; left: 85%; animation-delay: 1s;"></div>
        <div class="particle" style="top: 40%; left: 15%; animation-delay: 2s;"></div>
        <div class="particle" style="top: 60%; left: 75%; animation-delay: 3s;"></div>
        <div class="particle" style="top: 80%; left: 25%; animation-delay: 4s;"></div>

        <div class="container position-relative">
            <div class="section-area text-center">
                <span>- Showcase -</span>
                <h2 class="fs-two text-white upper">A{{ $eventType->name }} - Portfolio</h2>
            </div>

            <div class="row g-4 mt-5">


             @foreach ($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('event.show', $event->slug) }}" class="subcategory-card">
                            <img src="{{ $event->featured_image ? Storage::url($event->featured_image) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=600&h=400&fit=crop' }}"
                                alt="{{ $event->title }}" class="subcategory-image">
                            <div class="subcategory-content">
                                <h3>{{ $event->title }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach



            </div>
        </div>
    </section>
