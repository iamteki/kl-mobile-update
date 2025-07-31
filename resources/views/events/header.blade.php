<!-- Category Header - Dynamic Height for Long Descriptions -->
<section class="category-header">
    <!-- Background Image -->
    <div class="category-bg-image"></div>
    
    <div class="container text-center">
        <div class="position-relative">
            <!-- Breadcrumb with proper spacing -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$eventType->name}}</li>
                </ol>
            </nav>
            
            <!-- Title with proper spacing -->
            <h1 class="category-title">{{$eventType->name}}</h1>
            
            <!-- Description with dynamic height -->
            @if($eventType->description)
                <div class="category-subtitle">
                    {!! $eventType->description !!}
                </div>
            @endif
        </div>
    </div>
</section>