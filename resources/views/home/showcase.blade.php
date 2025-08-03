@if ($settings && ($settings->hero_video || $settings->showcase_video || $settings->company_profile_pdf))
    @push('styles')
    <style>
    .video-controls-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }
    .fullscreen-btn {
        background: rgba(0, 0, 0, 0.7);
        border: none;
        color: white;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s ease;
    }
    .fullscreen-btn:hover {
        background: rgba(0, 0, 0, 0.9);
    }
    .fullscreen-btn i {
        pointer-events: none;
    }
    </style>
    @endpush

    <!-- Showcase Section -->
    <section id="showcase" class="media-section">
        <div class="container">
            <div class="section-area text-center mb-5">
                <span data-animscroll="fade-up">- SHOWCASE -</span>
                <h2 data-animscroll="fade-up" class="fs-two text-white">EXPERIENCE <span>OUR</span> WORK</h2>
            </div>
            <div class="row g-4 align-items-stretch">
                @if ($settings->showcase_video)
                    <div class="col-lg-8" data-animscroll="fade-right">
                        <div class="video-wrapper position-relative">
                            <div class="video-placeholder" id="videoPlaceholder"
                                 style="background-image: url('{{ $settings->showcase_video_thumbnail_url ?: ($settings->hero_featured_image ? Storage::url($settings->hero_featured_image) : 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1200&h=600&fit=crop') }}');">
                                <div class="video-overlay" id="videoOverlay" onclick="playShowcaseVideo()">
                                    <div class="position-relative">
                                        <div class="play-pulse"></div>
                                        <button class="play-button" aria-label="Play showcase video">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Video element -->
                                <video id="showcaseVideo" controls
                                       style="display: none; width: 100%; height: 100%; object-fit: cover;"
                                       poster="{{ $settings->showcase_video_thumbnail_url ?: ($settings->hero_featured_image ? Storage::url($settings->hero_featured_image) : '') }}">
                                    <source src="{{ Storage::url($settings->showcase_video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="dj-element vinyl"></div>
                        </div>
                    </div>
                @elseif ($settings->hero_video)
                    <div class="col-lg-8" data-animscroll="fade-right">
                        <div class="video-wrapper position-relative">
                            <div class="video-placeholder" id="videoPlaceholder"
                                 style="background-image: url('{{ $settings->hero_featured_image ? Storage::url($settings->hero_featured_image) : 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1200&h=600&fit=crop' }}');">
                                <div class="video-overlay" id="videoOverlay" onclick="playHeroVideo()">
                                    <div class="position-relative">
                                        <div class="play-pulse"></div>
                                        <button class="play-button" aria-label="Play hero video">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Video element -->
                                <video id="showcaseVideo" controls
                                       style="display: none; width: 100%; height: 100%; object-fit: cover;"
                                       poster="{{ $settings->hero_featured_image ? Storage::url($settings->hero_featured_image) : '' }}">
                                    <source src="{{ Storage::url($settings->hero_video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="dj-element vinyl"></div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-8" data-animscroll="fade-right">
                        <div class="video-wrapper position-relative">
                            <img src="{{ $settings->hero_featured_image ? Storage::url($settings->hero_featured_image) : 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1200&h=600&fit=crop' }}"
                                 alt="Featured showcase image" class="w-100 h-100" style="object-fit: cover;">
                            <div class="dj-element vinyl"></div>
                        </div>
                    </div>
                @endif

                @if ($settings->company_profile_pdf)
                    <div class="col-lg-4" data-animscroll="fade-left">
                        <div class="media-card">
                            <i class="fas fa-file-pdf"></i>
                            <h5 class="text-white">Company Profile</h5>
                            <p class="text-white-50">Download our comprehensive company profile and services catalog</p>
                            <a href="{{ Storage::url($settings->company_profile_pdf) }}" class="btn btn-primary"
                               download target="_blank">Download PDF</a>
                        </div>
                    </div>
                @else
                    <div class="col-lg-4" data-animscroll="fade-left">
                        <div class="media-card">
                            <i class="fas fa-info-circle"></i>
                            <h5 class="text-white">Coming Soon</h5>
                            <p class="text-white-50">Company profile will be available for download soon</p>
                            <button class="btn btn-secondary" disabled>Not Available</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
    function playShowcaseVideo() {
        const videoOverlay = document.getElementById('videoOverlay');
        const video = document.getElementById('showcaseVideo');
        
        // Hide overlay and show video
        videoOverlay.style.display = 'none';
        video.style.display = 'block';
        
        // Play the video
        video.play();
        
        // Show overlay again when video ends
        video.addEventListener('ended', function() {
            videoOverlay.style.display = 'block';
            video.style.display = 'none';
        });
        
        // Show overlay when video is paused and at beginning
        video.addEventListener('pause', function() {
            if (video.currentTime === 0 || video.ended) {
                videoOverlay.style.display = 'block';
                video.style.display = 'none';
            }
        });
    }

    function playHeroVideo() {
        const videoOverlay = document.getElementById('videoOverlay');
        const video = document.getElementById('showcaseVideo');
        
        // Hide overlay and show video
        videoOverlay.style.display = 'none';
        video.style.display = 'block';
        
        // Play the video
        video.play();
        
        // Show overlay again when video ends
        video.addEventListener('ended', function() {
            videoOverlay.style.display = 'block';
            video.style.display = 'none';
        });
        
        // Show overlay when video is paused and at beginning
        video.addEventListener('pause', function() {
            if (video.currentTime === 0 || video.ended) {
                videoOverlay.style.display = 'block';
                video.style.display = 'none';
            }
        });
    }
    </script>
    @endpush
@else
    <!-- Fallback content when no settings are available -->
    <section id="showcase" class="media-section">
        <div class="container">
            <div class="section-area text-center mb-5">
                <span data-animscroll="fade-up">- SHOWCASE -</span>
                <h2 data-animscroll="fade-up" class="fs-two text-white">EXPERIENCE <span>OUR</span> WORK</h2>
            </div>
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8" data-animscroll="fade-right">
                    <div class="video-wrapper position-relative">
                        <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1200&h=600&fit=crop"
                             alt="Default showcase image" class="w-100 h-100" style="object-fit: cover;">
                        <div class="dj-element vinyl"></div>
                    </div>
                </div>
                <div class="col-lg-4" data-animscroll="fade-left">
                    <div class="media-card">
                        <i class="fas fa-cog"></i>
                        <h5 class="text-white">Setup Required</h5>
                        <p class="text-white-50">Please configure your showcase content in the admin panel</p>
                        <button class="btn btn-secondary" disabled>Configure Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif