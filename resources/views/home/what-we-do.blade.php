    <!-- Enhanced Services Section with Clickable Cards -->
    <section id="services" class="section-padding dark-bg"
        style="background-image: url({{ asset('frontend/assets/images/360_F_336009887_yI4fLOqWbm8rNLCCIgmCuR3XY1caADIy.jpg') }}); background-size: cover; background-position: center;">
        <div class="what-we-do-overlay">
            
        </div>
        <div class="container position-relative">
            <div class="section-area text-center">
                <span>- WHAT WE DO -</span>
                <h2 class="fs-two text-white">CORPORATE <span>EVENT
                        MANAGEMENT</span> & PRODUCTION</h2>
            </div>
            <div class="row g-4 mt-5">
                @foreach ($eventTypes as $event)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('events.byType', $event->slug) }}" class="category-card">
                            <h5>{{ $event->name }}</h5>
                            <span class="see-more">See More <i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
