<!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-image" data-animscroll="fade-right">
                    @if($settings && $settings->about_video)
                        <!-- Video Container with Thumbnail -->
                        <div class="video-wrapper">
                            <!-- Video Element with controls (initially hidden) -->
                            <video id="aboutVideo" class="about-video" controls muted playsinline preload="metadata">
                                <source src="{{ $settings->about_video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            
                            <!-- Thumbnail Image (fallback) -->
                            <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop"
                                alt="Professional DJ Equipment" class="video-thumbnail" id="aboutVideoThumbnail">
                            
                            <!-- Play Button Overlay -->
                            <div class="play-button-overlay" id="aboutPlayButton">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    @else
                        <!-- Fallback Static Image -->
                        <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop"
                            alt="Professional DJ Equipment">
                    @endif
                </div>
                
                <div class="about-text">
                    <div class="section-area">
                        <span data-animscroll="fade-up">- ABOUT US -</span>
                        <h2 data-animscroll="fade-up" class="fs-two text-white">WHY <span>PROFESSIONAL</span> EVENT SUPPORT</h2>
                    </div>
                    
                    <p data-animscroll="fade-up" class="lead mb-4">With over 20 years of experience, we understand that successful events require
                        meticulous planning, professional execution, and seamless coordination.</p>
                    <ul class="list-unstyled" data-animscroll="fade-up">
                        <li class="mb-3"><i class="fas fa-check-circle me-3"
                                style="color: var(--primary-purple);"></i>Expert planning and coordination</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-3"
                                style="color: var(--primary-purple);"></i>State-of-the-art equipment</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-3"
                                style="color: var(--primary-purple);"></i>Professional team of specialists</li>

                    </ul>
                    {{-- <a href="aboutus.html" class="btn btn-sm mt-4" style="background: var(--gradient-purple); color: var(--pure-white); padding: 10px 28px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border: none; border-radius: 50px; transition: all 0.3s; display: inline-block; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);">
                        Learn More About Us <i class="fas fa-arrow-right ms-2" style="font-size: 0.875rem;"></i>
                    </a> --}}
                </div>
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
                    // Keep video visible but you could add a custom pause overlay here
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