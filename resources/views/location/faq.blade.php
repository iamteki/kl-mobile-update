@if ($faqs && $faqs->count() > 0)
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-area text-center">
                <span>- FREQUENTLY ASKED QUESTIONS -</span>
                <h2 class="fs-two text-white">EVERYTHING <span>YOU NEED TO</span> KNOW</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="faq-accordion" id="faqAccordion">
                        @foreach ($faqs as $index => $faq)
                            <!-- FAQ {{ $index + 1 }} -->
                            <div class="faq-item">
                                <h3 class="faq-header" id="faq{{ $index + 1 }}">
                                    <button class="faq-button {{ $index === 0 ? '' : 'collapsed' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $index + 1 }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $index + 1 }}">
                                        <span class="faq-title">{{ $faq->question }}</span>
                                        <span class="faq-icon"><i class="fas fa-plus"></i></span>
                                    </button>
                                </h3>
                                <div id="collapse{{ $index + 1 }}" 
                                     class="collapse {{ $index === 0 ? 'show' : '' }}" 
                                     aria-labelledby="faq{{ $index + 1 }}"
                                     data-bs-parent="#faqAccordion">
                                    <div class="faq-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif