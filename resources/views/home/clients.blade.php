<section class="section-padding clients-section">
    <div class="container">
        <div class="section-area text-center">
            <span data-animscroll="fade-up">- TRUSTED BY -</span>
            <h2 data-animscroll="fade-up" class="fs-two text-white">OUR <span>PRESTIGIOUS</span> CLIENTS</h2>
            <p data-animscroll="fade-up" class="lead mt-3">Proudly serving Malaysia's leading corporations and
                international brands</p>
        </div>

        <!-- Client Logos Swiper Animation -->
        <div class="clients-swiper-wrapper mt-5" data-animscroll="fade-up">
            @if ($oddClients->count() > 0 || $evenClients->count() > 0)
                <!-- First Row - All Clients -->
                <div class="clients-swiper-container">
                    <div class="swiper clients-swiper-main">
                        <div class="swiper-wrapper">
                            @foreach ($oddClients as $client)
                                <div class="swiper-slide">
                                    <div class="client-logo-swiper-wrapper">
                                        <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                            class="client-logo-swiper">
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($evenClients as $client)
                                <div class="swiper-slide">
                                    <div class="client-logo-swiper-wrapper">
                                        <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                            class="client-logo-swiper">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Second Row - All Clients Reversed -->
                <div class="clients-swiper-container">
                    <div class="swiper clients-swiper-reverse">
                        <div class="swiper-wrapper">
                            @foreach ($evenClients->reverse() as $client)
                                <div class="swiper-slide">
                                    <div class="client-logo-swiper-wrapper">
                                        <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                            class="client-logo-swiper">
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($oddClients->reverse() as $client)
                                <div class="swiper-slide">
                                    <div class="client-logo-swiper-wrapper">
                                        <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                            class="client-logo-swiper">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Fallback if no clients -->
                <div class="text-center mt-5">
                    <p class="text-white-50">Client logos will appear here once added.</p>
                </div>
            @endif
        </div>

        <!-- Client Statistics -->
        {{-- <div class="client-stats mt-5" data-animscroll="fade-up">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <div>
                            <h3 class="stat-number">500</h3>
                            <span>+</span>
                        </div>
                        <p>Corporate Clients</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <div>
                            <h3 class="stat-number" data-target="20">20</h3>
                            <span>+</span>
                        </div>
                        <p>Years of Trust</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <div>
                            <h3 class="stat-number">1000</h3>
                        </div>
                        <p>Events Delivered</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <div>
                            <h3 class="stat-number" data-target="98">98</h3>
                            <span>%</span>
                        </div>
                        <p>Client Satisfaction</p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</section>