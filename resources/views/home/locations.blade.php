<!-- Updated Office & Warehouse Section -->
@if ($officeLocations->count() > 0)
    <section class="locations-section" id="locations">
        <div class="container">
            <div class="section-area text-center">
                <span data-animscroll="fade-up">- LOCATIONS -</span>
                <h2 data-animscroll="fade-up" class="fs-two text-white">FIND <span>US</span> HERE</h2>
            </div>
            <div class="row g-4 mt-5">
                @foreach ($officeLocations as $location)
                    <div class="col-md-6" data-animscroll="fade-right">
                        <a href="{{ route('location.show', $location->slug) }}" class="location-card-link">
                            <div class="location-card">
                                <h4>
                                    @if ($location->icon)
                                        <img src="{{ asset('storage/' . $location->icon) }}"
                                            alt="{{ $location->name }} Icon" class="me-2 location-icon-purple">
                                    @else
                                        <i class="fas fa-building me-2" style="color: var(--primary-purple);"></i>
                                    @endif
                                    {{ $location->name }}
                                </h4>
                                <div class="location-info">
                                    <div class="info-row">
                                        <span class="info-label">Address</span>
                                        <span class="info-content">
                                            {{ $location->address }}
                                        </span>
                                    </div>
                                    @if ($location->phone)
                                        <div class="info-row">
                                            <span class="info-label">Phone</span>
                                            <span class="info-content">{{ $location->phone }}</span>
                                        </div>
                                    @endif
                                    @if ($location->email)
                                        <div class="info-row">
                                            <span class="info-label">Email</span>
                                            <span class="info-content">{{ $location->email }}</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="operating-hours">
                                  View More
                                </p>
                                <span class="see-location"><i class="fas fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{-- <div class="col-md-6" data-animscroll="fade-left">
                <a href="" class="location-card-link">
                    <div class="location-card">
                        <h4><i class="fas fa-warehouse me-2" style="color: var(--primary-purple);"></i>Our Warehouse</h4>
                        <div class="location-info">
                            <div class="info-row">
                                <span class="info-label">Address</span>
                                <span class="info-content">
                                    Lot 123, Kawasan Perindustrian Sungai Buloh<br>
                                    47000 Sungai Buloh, Selangor
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone</span>
                                <span class="info-content">+60 3-9876 5432</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-content">warehouse@klmobiledjs.com</span>
                            </div>
                        </div>
                        <p class="operating-hours"><strong>24/7 Equipment Storage & Logistics</strong></p>
                        <span class="see-location"><i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div> --}}
            </div>
        </div>
    </section>
@endif
