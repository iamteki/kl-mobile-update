<!-- resources/views/home/testimonial.blade.php -->
<!-- Clean Testimonial Section with 3-Column Carousel (No Arrows) -->
<section id="testimonials" class="review-section section-padding">
    <div class="container">
        <div class="section-area text-center mb-5">
            <span data-animscroll="fade-up">- TESTIMONIAL -</span>
            <h2 data-animscroll="fade-up" class="fs-two text-white">CLIENT <span>REVIEWS</span></h2>
        </div>
        
        <!-- Testimonial Carousel Container -->
        <div class="kl-testimonial-container" data-animscroll="fade-up">
            <div class="swiper kl-testimonial-swiper">
                <div class="swiper-wrapper">
                    @foreach ($testimonials as $review)
                        <div class="swiper-slide">
                            <div class="kl-testimonial-card">
                                <!-- Quote Icon -->
                                <div class="kl-quote-icon">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                
                                <!-- Star Rating -->
                                <div class="kl-rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                                
                                <!-- Testimonial Content -->
                                <div class="kl-testimonial-content">
                                    <p>"{{ $review->testimonial }}"</p>
                                </div>
                                
                                <!-- Client Details -->
                                <div class="kl-client-details">
                                    <h5 class="kl-client-name">{{ $review->name }}</h5>
                                    <span class="kl-client-role">
                                        @if ($review->position && $review->company)
                                            {{ $review->position }}, {{ $review->company }}
                                        @elseif($review->position)
                                            {{ $review->position }}
                                        @elseif($review->company)
                                            {{ $review->company }}
                                        @else
                                            Valued Client
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows in the Middle -->
                <div class="kl-testimonial-nav">
                    <button class="kl-nav-prev" aria-label="Previous testimonial">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="kl-nav-next" aria-label="Next testimonial">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>