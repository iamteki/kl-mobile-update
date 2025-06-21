<!-- Location Header -->
<section class="location-page-header">
    <!-- Background Image with Overlay -->
    <div class="location-hero-bg">
        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&h=600&fit=crop" 
             alt="KL Mobile Events Corporate Office" class="header-bg-img">
    </div>
    
    <!-- Overlay -->
    <div class="location-hero-overlay"></div>
    
    <!-- Floating Elements -->
    <div class="location-floating-elements">
        <div class="float-shape shape-1"></div>
        <div class="float-shape shape-2"></div>
        <div class="float-shape shape-3"></div>
    </div>
    
    <div class="container text-center">
        <div class="location-header-content">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('/') }}#locations">Locations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$location->name}}</li>
                </ol>
            </nav>
            
            <!-- Location Badge -->
            <div class="location-badge">
                <span class="badge-text"><i class="fas fa-map-marker-alt"></i>{{$location->address}}</span>
            </div>
            
            <!-- Title -->
            <h1 class="location-main-title">
                <span class="title-small">Welcome to Our</span>
                <span class="title-large"><span class="text-gradient">{{$location->name}}</span></span>
            </h1>
            
            <!-- Subtitle -->
            <p class="location-subtitle">
                {{$location->small_description}}
            </p>
            
            <!-- Quick Info -->
            <div class="quick-info-row">
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span>{{$location->open_time}}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <span>{{$location->phone}}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{$location->email}}</span>
                </div>
            </div>
        </div>
    </div>
</section>