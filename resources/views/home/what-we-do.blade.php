    <!-- Enhanced Services Section with Clickable Cards -->
    <section id="services" class="section-padding light-bg">
        {{-- <div class="what-we-do-overlay">
            
        </div> --}}
        <div class="container position-relative">
            <div class="section-area text-center">
                {{-- <span data-animscroll="fade-up">- LET US KNOW WHAT YOU ARE LOOKING FOR -</span> --}}
                {{-- <h2 data-animscroll="fade-up" class="fs-two text-white">CORPORATE <span>EVENT
                        MANAGEMENT</span> & PRODUCTION</h2> --}}
            </div>
            <div class="row g-4 mt-5">
                @foreach ($eventTypes as $key => $event)
                    <div class="col-6 col-md-4" data-animscroll="fade-up" data-animscroll-delay="{{ $key * 100 }}">
                        <a href="{{ route('events.byType', $event->slug) }}" class="category-card">
                            <h5>{{ $event->name }}</h5>
                            <span class="see-more">See More <i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
