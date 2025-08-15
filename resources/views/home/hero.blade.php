<!-- Enhanced Hero Section with Video Background -->
<section id="home" class="hero-section">
    <!-- Video Background -->
    <div class="hero-video-bg">
        <video autoplay muted loop playsinline>
            <source src="https://klmobile.sgp1.digitaloceanspaces.com/klmobileintro" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Video Overlay -->
    <div class="hero-video-overlay"></div>

    <!-- Additional Gradient Overlay -->
    <div class="hero-gradient-overlay"></div>

    <!-- Particle Effects -->
    <div class="hero-particles"></div>

    <!-- Floating Elements -->
    {{-- <div class="floating-elements">
        <div class="float-element element-1">
            <i class="fas fa-music"></i>
        </div>
        <div class="float-element element-2">
            <i class="fas fa-headphones"></i>
        </div>
        <div class="float-element element-3">
            <i class="fas fa-microphone"></i>
        </div>
    </div> --}}

    <div class="container text-center">
        <div class="hero-content">
            <!-- Animated Badge -->
            <div class="hero-badge">
                <span class="badge-text">20+ Years of Excellence</span>
            </div>

            <!-- Main Title with Better Typography -->
            <h1 class="hero-title">
                <span class="title-line-1">Kuala Lumpur's</span>
                <span class="title-line-2">CORPORATE <span class="text-gradient"> EVENT
                       <span id="typing-text">MANAGEMENT</span> </span></span>
                <span class="title-line-3">& PRODUCTION</span>
            </h1>

            <!-- Animated Subtitle -->
            {{-- <p class="hero-description" style="max-width: 100%">
               <b> Creating unforgettable experiences through professional</b> <br> SOUND - LIGHTING - TRUSS - LED SCREENS - STAGE - FABRICATION - TALENTS
            </p> --}}

            <!-- CTA Button with Animation -->
            <div class="hero-buttons mt-5">
                <a href="#contact" class="box-style box-second anim fadeInUp" data-animscroll="fade-up"
                    data-animscroll-delay="200">
                    <i class="fa-regular fa-calendar-days"></i> Book Your Event
                </a>

                <a href="mailto:sean@klmobileevents.com" target="_blank" class="box-style box-second anim fadeInUp"
                    data-animscroll="fade-up" data-animscroll-delay="200">
                    <i class="fas fa-envelope"></i> Email Us
                </a>

                <a href="#contact" class="box-style box-second anim fadeInUp" data-animscroll="fade-up"
                    data-animscroll-delay="200">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const words = ["MANAGEMENT", "PRODUCTION", "ORGANIZING"];
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            const typingElement = document.getElementById("typing-text");
            const typingSpeed = 100;
            const erasingSpeed = 50;
            const delayBetweenWords = 1500;

            function typeEffect() {
                const currentWord = words[wordIndex];

                if (!isDeleting) {
                    typingElement.textContent = currentWord.substring(0, charIndex + 1);
                    charIndex++;
                    if (charIndex === currentWord.length) {
                        isDeleting = true;
                        setTimeout(typeEffect, delayBetweenWords);
                        return;
                    }
                } else {
                    typingElement.textContent = currentWord.substring(0, charIndex - 1);
                    charIndex--;
                    if (charIndex === 0) {
                        isDeleting = false;
                        wordIndex = (wordIndex + 1) % words.length;
                    }
                }

                setTimeout(typeEffect, isDeleting ? erasingSpeed : typingSpeed);
            }

            typeEffect();
        });
    </script>
@endpush
