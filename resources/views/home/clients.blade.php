<section class="section-padding clients-section">
    <div class="container">
        <div class="section-area text-center">
            <span data-animscroll="fade-up">- TRUSTED BY -</span>
            <h2 data-animscroll="fade-up" class="fs-two text-white">OUR <span>PRESTIGIOUS</span> CLIENTS</h2>
            <p data-animscroll="fade-up" class="lead mt-3">Proudly serving Malaysia's leading corporations and
                international brands</p>
        </div>

        <!-- Client Logos Marquee Animation -->
        <div class="clients-wrapper mt-5" data-animscroll="fade-up">
            <!-- First Row - Odd Order Numbers -->
            @if ($oddClients->count() > 0)
                <div class="clients-marquee">
                    <div class="clients-track">
                        @foreach ($oddClients as $client)
                            <div class="client-logo-wrapper">
                                <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                    class="client-logo">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Second Row - Even Order Numbers - Reverse Direction -->
            @if ($evenClients->count() > 0)
                <div class="clients-marquee clients-marquee-reverse mt-5">
                    <div class="clients-track">
                        @foreach ($evenClients as $client)
                            <div class="client-logo-wrapper">
                                <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                    class="client-logo">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Fallback if no clients -->
            @if ($oddClients->count() == 0 && $evenClients->count() == 0)
                <div class="text-center mt-5">
                    <p class="text-white-50">Client logos will appear here once added.</p>
                </div>
            @endif
        </div>

        <!-- Client Statistics -->
        <div class="client-stats mt-5" data-animscroll="fade-up">
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
        </div>
    </div>
</section>