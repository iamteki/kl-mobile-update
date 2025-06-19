<!-- Clients Section -->
<section class="section-padding clients-section">
    <div class="container">
        <div class="section-area text-center">
            <span>- TRUSTED BY -</span>
            <h2 class="fs-two text-white">OUR <span>PRESTIGIOUS</span> CLIENTS</h2>
            <p class="lead mt-3">Proudly serving Malaysia's leading corporations and international brands</p>
        </div>

        <!-- Client Logos Marquee Animation -->
        <div class="clients-wrapper mt-5">
            <!-- First Row - Odd Order Numbers -->
            @if($oddClients->count() > 0)
            <div class="clients-marquee">
                <div class="clients-track">
                    @foreach($oddClients as $client)
                    <div class="client-logo-wrapper">
                        <img src="{{ $client->image_url }}" alt="{{ $client->name }}" class="client-logo">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Second Row - Even Order Numbers - Reverse Direction -->
            @if($evenClients->count() > 0)
            <div class="clients-marquee clients-marquee-reverse mt-5">
                <div class="clients-track">
                    @foreach($evenClients as $client)
                    <div class="client-logo-wrapper">
                        <img src="{{ $client->image_url }}" alt="{{ $client->name }}" class="client-logo">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Fallback if no clients -->
            @if($oddClients->count() == 0 && $evenClients->count() == 0)
            <div class="text-center mt-5">
                <p class="text-white-50">Client logos will appear here once added.</p>
            </div>
            @endif
        </div>

        <!-- Client Statistics -->
        <div class="client-stats mt-5">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <h3 class="stat-number" data-target="500">0</h3><span><h3 class="stat-number">+</h3></span>
                        <p class="text-white-50">Corporate Clients</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <h3 class="stat-number" data-target="20">0</h3><span><h3 class="stat-number">+</h3></span>
                        <p class="text-white-50">Years of Trust</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <h3 class="stat-number" data-target="1000">0</h3>
                        <p class="text-white-50">Events Delivered</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card">
                        <h3 class="stat-number" data-target="98">0</h3>
                        <span>%</span>
                        <p class="text-white-50">Client Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>