<!-- About Section - Single Column Layout -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content-single">
                <!-- Content Section -->
                <div class="about-text-center">
                    <div class="section-area">
                        <span data-animscroll="fade-up">- ABOUT US -</span>
                        <h2 data-animscroll="fade-up" class="fs-two text-white">WHY <span>PROFESSIONAL</span> EVENT SUPPORT</h2>
                    </div>
                    
                    <p data-animscroll="fade-up" class="lead mb-4">With over 20 years of experience, we understand that successful events require
                        meticulous planning, professional execution, and seamless coordination.</p>
                </div>

                <!-- Video Section -->
                @if($settings && $settings->about_video)
                <div class="about-video-section" data-animscroll="fade-up">
                    <div class="video-wrapper-centered">
                        <!-- Video Element with controls (initially hidden) -->
                        <video id="aboutVideo" class="about-video" controls muted playsinline preload="metadata">
                            <source src="{{ $settings->about_video_url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        
                        <!-- Thumbnail Image (with custom thumbnail or fallback) -->
                        <img src="{{ $settings->about_video_thumbnail_url ?: 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=1200&h=675&fit=crop' }}"
                            alt="About Video Thumbnail" class="video-thumbnail" id="aboutVideoThumbnail">
                        
                        <!-- Play Button Overlay -->
                        <div class="play-button-overlay" id="aboutPlayButton">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    @if($settings && $settings->about_video)
    <!-- About Video JavaScript with Controls -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('aboutVideo');
        const thumbnail = document.getElementById('aboutVideoThumbnail');
        const playButton = document.getElementById('aboutPlayButton');
        
        if (video && thumbnail && playButton) {
            // Play button click handler
            playButton.addEventListener('click', function() {
                // Hide thumbnail and play button
                thumbnail.style.display = 'none';
                playButton.style.display = 'none';
                
                // Show video with controls and play
                video.style.display = 'block';
                video.controls = true; // Ensure controls are visible
                video.play().catch(function(error) {
                    console.log('Video play failed:', error);
                    // Show thumbnail and play button again if video fails
                    thumbnail.style.display = 'block';
                    playButton.style.display = 'flex';
                    video.style.display = 'none';
                });
            });
            
            // Video ended handler - show thumbnail again
            video.addEventListener('ended', function() {
                video.style.display = 'none';
                video.controls = false; // Hide controls when not playing
                thumbnail.style.display = 'block';
                playButton.style.display = 'flex';
                video.currentTime = 0; // Reset video to beginning
            });
            
            // Video error handler
            video.addEventListener('error', function() {
                console.log('Video loading error');
                // Keep showing the thumbnail if video fails to load
                thumbnail.style.display = 'block';
                playButton.style.display = 'flex';
                video.style.display = 'none';
            });

            // Video pause handler - show custom overlay when paused
            video.addEventListener('pause', function() {
                if (video.currentTime < video.duration) {
                    // Video was paused before ending
                    console.log('Video paused at:', video.currentTime);
                }
            });

            // Video play handler - ensure controls are visible
            video.addEventListener('play', function() {
                video.controls = true;
            });

            // Click on video area when thumbnail is showing
            thumbnail.addEventListener('click', function() {
                playButton.click(); // Trigger the same play functionality
            });
        }
    });
    </script>
    @endif