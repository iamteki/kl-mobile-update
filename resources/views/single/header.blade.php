<!-- Page Header - Dynamic Height for Long Content -->
<section class="page-header">
    <!-- Background Image -->
    <div class="hero-bg-image" style="background-image: url('{{ $event->featured_image ? Storage::url($event->featured_image) : '' }}');"></div>
    
    <!-- Sparkles Animation -->
    <div class="sparkles">
        <div class="sparkle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="sparkle" style="left: 20%; animation-delay: 0.5s;"></div>
        <div class="sparkle" style="left: 30%; animation-delay: 1s;"></div>
        <div class="sparkle" style="left: 40%; animation-delay: 1.5s;"></div>
        <div class="sparkle" style="left: 50%; animation-delay: 2s;"></div>
        <div class="sparkle" style="left: 60%; animation-delay: 2.5s;"></div>
        <div class="sparkle" style="left: 70%; animation-delay: 3s;"></div>
        <div class="sparkle" style="left: 80%; animation-delay: 3.5s;"></div>
        <div class="sparkle" style="left: 90%; animation-delay: 4s;"></div>
    </div>
    
    <div class="container text-center position-relative">
        <!-- Breadcrumb with proper spacing -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.byType', $event->eventType->slug) }}">{{ $event->eventType->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
            </ol>
        </nav>
        
        <!-- Title with proper spacing -->
        <h1 class="page-title">{{ $event->title }}</h1>
        
        <!-- Excerpt/Subtitle with dynamic height -->
        @if($event->excerpt)
            <div class="page-subtitle">
                {!! $event->excerpt !!}
            </div>
        @endif
    </div>
</section>