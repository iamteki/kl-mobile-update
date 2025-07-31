<!-- Enhanced Testimonials Section with Single Image -->
<section id="testimonials" class="review-section section-padding">
    <div class="container">
        <div class="section-area text-center mb-5">
            <span data-animscroll="fade-up">- TESTIMONIAL -</span>
            <h2 data-animscroll="fade-up" class="fs-two text-white">CLIENT <span>REVIEWS</span></h2>
        </div>
        <div class="testimonial-wrapper">
            <div class="row align-items-stretch g-4">
                <!-- Reviews Column with Arrow Navigation -->
                <div class="col-lg-6">
                    <div class="testimonial-content-wrapper">
                        <div class="swiper testimonial-carousel">
                            <!-- Navigation Arrows - Positioned at Card Corners (Desktop & Mobile) -->
                            <div class="testimonial-navigation testimonial-prev">
                                <i class="fas fa-chevron-left"></i>
                            </div>
                            <div class="testimonial-navigation testimonial-next">
                                <i class="fas fa-chevron-right"></i>
                            </div>

                            <div class="swiper-wrapper">
                                {{-- Review Loop --}}
                                @foreach ($testimonials as $review)
                                    <div class="swiper-slide">
                                        <div class="single-area">
                                            <div class="box-area mb-4">
                                                <i class="fas fa-quote-left"
                                                    style="font-size: 3rem; color: var(--primary-purple);"></i>
                                            </div>
                                            <div
                                                class="d-flex flex-wrap gap-4 justify-content-between align-items-center mb-4">
                                                <div class="text-area">
                                                    <h5 class="mb-1 text-white">{{ $review->name }}</h5>
                                                    <span class="text-white-50">
                                                        @if ($review->position && $review->company)
                                                            {{ $review->position }}, {{ $review->company }}
                                                        @elseif($review->position)
                                                            {{ $review->position }}
                                                        @elseif($review->company)
                                                            {{ $review->company }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star"
                                                            style="color: {{ $i <= $review->rating ? 'var(--primary-purple)' : '#ccc' }}; margin: 0 2px;"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-white-50 fs-5">"{{ $review->testimonial }}"</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Static Image Column -->
                <div class="col-lg-6">
                    <div class="testimonial-static-image-wrapper">
                        <div class="testimonial-image-container">
                            <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop"
                                alt="Live band performance at event" class="testimonial-static-image">
                            <div class="testimonial-image-overlay"></div>
                            <div class="testimonial-image-content">
                                <h3 class="text-white mb-2">20+ Years of Excellence</h3>
                                <p class="text-white-50 mb-0">Trusted by Malaysia's leading corporations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination dots container -->
            <div class="testimonial-dots-container">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>