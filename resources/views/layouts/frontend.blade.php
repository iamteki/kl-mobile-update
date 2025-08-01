<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Title -->
    <!-- Dynamic Title -->
    <title>@yield('title', 'KL Mobile Events - Kuala Lumpur\'s Premier Event Management')</title>

    <!-- Dynamic Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'KL Mobile Events is Kuala Lumpur\'s premier event management company, specializing in corporate events, weddings, concerts, and exhibitions.')">
    <meta name="keywords" content="@yield('meta_keywords', 'event management, kuala lumpur events, corporate events, wedding planning, concert management, exhibition services')">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="@yield('og_title', 'KL Mobile Events - Premier Event Management')">
    <meta property="og:description" content="@yield('og_description', 'Transform your vision into unforgettable experiences with KL Mobile Events.')">
    <meta property="og:image" content="@yield('og_image', asset('frontend/assets/images/kl_logo_final_original.jpg'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="KL Mobile Events">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', 'KL Mobile Events - Premier Event Management')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Transform your vision into unforgettable experiences with KL Mobile Events.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/assets/images/kl_logo_final_original.jpg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Robots -->
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAA7AAAAOwBeShxvQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAMKSURBVFiFtZfPbxRVGMc/783M7uy2u223pS1QKBQolB8CUaOJxIMnTXrwYKIHL3rwH/DgxYMXLx68ePDgxYsXE0+ePJh4MEQTTUQjEn5JQaEUWn7Zlm133Z2dnd15HnZmd3a7s7tA+CZvMvPe+77f7/u+733vzAghWE9T13kFXAbGgREg2cQlBxSAaeAacE0IMd9MWG0hcAE4DyQAlFJIKZFSopSq+7hfCEEQBPi+TxAEAAvAWeC8EOJJSwJKqQvAaQCtXq6u60ilUmiahpQSpRRSSqRSSClbEgnDECEEQgh838f3fYQQAD7wLnBBCOHXBK5qmnYOqEvZEQE3m8X3farVKr7vd7T8dmmapsVisUg8HickdNE07e2agLMASqmOCQRBQKlUIp/P02w3mqEeglarxcrKCsvLy5RKJcIwBDillDqrlBJnon2ulKqT6CQCQgiCIKBcLrO4uIjruvzGH4TAZeBdXgJGgRNRASllWwKu6/Lw4UOePn0KgOM4eJ5HEASr5JqRiJKLklDXdbLZLHv27MHzPHdqauo4cEQCJ4CRekJgdHSU9fX1Nd13XZdKpUIQBC/cAqvItEimh4eHSSQSJBKJE8Am2QnLXhiGhGG46kkY/heM9TLX87yGczTuCqQAV7VC4CWRcBzH1VotNq0IKKVYWFjAdV0GBgYQQrQV397ezsjICGmarppSDNKCQBAETZfX8zzm5+e5d+8eN2/epFgsks/nG8qZpkk2m0UpRaVS4fbt28zOztpJGJ4YBLqxeDgNgOu61Go1SqUSv/CDO3fuND1uYcYHBwfp6emJlnSdFJDo0tgmJibWdFitVpmdne3VNG1SAsOdTm3G9vHx8TWvG4bB2NjYcAwwOp3aipnf379mtmk2m83atl2VAOVyuVeLsD8W4+mPP1LxfQ4dP87w9u0vJFouFnlw8yaPfvuN/kwGXdcZGRnRYrGYi6ivdUcH3i0UePDzz8zNzREKgaFpHDhyhMNvvsm2sbGmJBbm5pi9fp07165R9n3STz5h2vdJJpNmEAQeLzPy/wf8CzD9YSDobtjnAAAAAElFTkSuQmCC">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;600;700;800;900&family=Space+Grotesk:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css') }}?v=2">
    {{-- Anim Trap  --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/animtrap/css/animtrap.min.css') }}"> --}}
    {{-- @vite(['', 'resources/js/app.js']) --}}
    @stack('styles')

</head>

<body>
    <!-- Loading Screen -->
    {{-- <div id="loading-screen" class="loading-screen">
        <div class="loading-content">
            <div class="loading-logo">
                <img src="{{ asset('frontend/assets/images/kl_mobile_final_logo.svg') }}" alt="KL Mobile Events" class="loading-logo-img">
            </div>
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="loading-text">Loading Experience...</div>
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>
        </div>
    </div> --}}

    <!-- Custom Cursor -->
    <div class="mouse-follower">
        <span class="cursor-outline"></span>
        <span class="cursor-dot"></span>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    @include('components.header')

    @yield('content')

    @include('components.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('frontend/animtrap/js/anim-effect.js') }}"></script>
    <script src="{{ asset('frontend/animtrap/js/anim-scroll.js') }}"></script> --}}
    @stack('scripts')

    {{-- <script>
        ANIMSCROLL.init({
            easing: 'ease-in-out-sine'
        });
    </script> --}}

</body>

</html>
