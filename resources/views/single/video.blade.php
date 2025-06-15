@if ($event->video)
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
    <!-- Video Section - Enhanced -->
    <section class="video-section">
        <div class="container position-relative">
            <div class="section-area text-center mb-5">
                <span>- SHOWCASE VIDEO -</span>
                <h2 class="fs-two">{{ $event->video_title ?? 'EXPERIENCE THE MAGIC' }}</h2>
            </div>
            <div class="video-container">
                <div class="video-wrapper">
                    <div class="video-placeholder" id="videoPlaceholder" style="background-image: url('{{ $event->featured_image ? Storage::url($event->featured_image) : '' }}');">
                        <div class="video-overlay" id="videoOverlay">
                            <div class="position-relative">
                                <div class="play-pulse"></div>
                                <button class="play-button" onclick="playVideo()">
                                    <i class="fas fa-play"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Video element with object-fit cover -->
                        <video id="eventVideo" controls
                            style="display: none; width: 100%; height: 100%; object-fit: cover;"
                            poster="{{ $event->featured_image ? Storage::url($event->featured_image) : '' }}">
                            <source src="{{ Storage::url($event->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <!-- Video Controls Overlay -->
                        <div class="video-controls-overlay" id="videoControls" style="display: none;">
                            <button class="fullscreen-btn" onclick="toggleFullscreen()">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


@push('scripts')
    <script>
        function playVideo() {
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            const videoOverlay = document.getElementById('videoOverlay');
            const video = document.getElementById('eventVideo');

            // Hide overlay and show video
            videoOverlay.style.display = 'none';
            video.style.display = 'block';

            // Play the video
            video.play();

            // Optional: Add event listener to show overlay again when video ends
            video.addEventListener('ended', function() {
                videoOverlay.style.display = 'block';
                video.style.display = 'none';
            });
        }
    </script>
@endpush
