   <!-- Category Header - Simplified -->
<section class="category-header">
    <!-- Background Image -->
    <div class="category-bg-image"></div>
    
    <!-- Animated Music Notes -->
    <div class="music-notes">
        <i class="fas fa-music music-note"></i>
        <i class="fas fa-music music-note"></i>
        <i class="fas fa-music music-note"></i>
        <i class="fas fa-music music-note"></i>
    </div>
    
    <div class="container text-center">
        <div class="position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$event->name}}</li>
                </ol>
            </nav>
            <h1 class="category-title mb-3">{{$event->name}}</h1>
            <p class="category-subtitle">{{$event->description}}</p>
        </div>
    </div>
</section>
