@extends('layouts.frontend')

@section('title', isset($category) ? $category->meta_title ?: $category->name . ' Blog - KL Mobile Events' : 'Blog - Event Management Insights | KL Mobile Events')
@section('meta_description', isset($category) ? $category->meta_description : 'Discover event planning tips, industry insights, and success stories from KL Mobile Events. Your guide to creating memorable events in Kuala Lumpur.')
@section('meta_keywords', isset($category) ? $category->meta_keywords : 'event planning blog, event management tips, kuala lumpur events, corporate event ideas, wedding planning guide')

@section('og_title', isset($category) ? $category->name . ' Articles' : 'KL Mobile Events Blog')
@section('og_description', isset($category) ? $category->meta_description : 'Expert insights and tips on event management')
@section('og_type', 'website')
@section('og_url', isset($category) ? route('blog.category', $category->slug) : route('blog.index'))

@section('canonical_url', isset($category) ? route('blog.category', $category->slug) : route('blog.index'))

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">
@endpush

@section('content')
    <!-- Blog Header -->
    <header class="blog-header">
        <!-- Background Image -->
        <div class="blog-hero-bg"></div>
        
        <!-- Overlay -->
        <div class="blog-hero-overlay"></div>
        
        <!-- Decorative Elements -->
        {{-- <div class="blog-decorative-elements">
            <div class="decorative-line line-1"></div>
            <div class="decorative-line line-2"></div>
            <div class="decorative-circle circle-1"></div>
            <div class="decorative-circle circle-2"></div>
        </div> --}}
        
        <div class="container text-center position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                    @if(isset($category))
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    @endif
                </ol>
            </nav>
            <h1 class="blog-header-title">
                @if(isset($category))
                    {{ $category->name }}
                @else
                    Our Blog
                @endif
            </h1>
            <p class="blog-header-subtitle">
                @if(isset($category))
                    {{ $category->description ?: 'Explore articles in ' . $category->name }}
                @else
                    Insights, Tips & Trends in Event Management
                @endif
            </p>
        </div>
    </header>
    
    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="blog-search-wrapper">
                <form action="{{ route('blog.index') }}" method="GET" class="blog-search">
                    <input type="text" name="search" class="blog-search-input" 
                           placeholder="Search articles..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="blog-search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Blog Categories Filter -->
    <section class="blog-filter-section">
        <div class="container">
            <div class="blog-filter-wrapper">
                <a href="{{ route('blog.index') }}" 
                   class="filter-btn {{ !request('category') && !isset($category) ? 'active' : '' }}">
                    All Posts
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}" 
                       class="filter-btn {{ (request('category') == $cat->slug || (isset($category) && $category->id == $cat->id)) ? 'active' : '' }}">
                        {{ $cat->name }}
                        @if($cat->blogs_count > 0)
                            ({{ $cat->blogs_count }})
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="blog-posts-section">
        <div class="container">
            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <article class="blog-post-card {{ $post->is_featured ? 'featured' : '' }}" data-category="{{ $post->category->slug ?? '' }}">
                            <div class="post-image-wrapper">
                                <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&h=400&fit=crop' }}" 
                                     alt="{{ $post->title }}" 
                                     class="post-image">
                                @if($post->is_featured)
                                    <div class="featured-label">
                                        <i class="fas fa-star"></i> Featured
                                    </div>
                                @endif
                                <div class="post-overlay">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="overlay-link">Read More</a>
                                </div>
                            </div>
                            <div class="post-content">
                                @if($post->category)
                                    <div class="post-category">{{ $post->category->name }}</div>
                                @endif
                                <h3 class="post-title">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="post-excerpt">{{ Str::limit($post->excerpt, 150) }}</p>
                                <div class="post-footer">
                                    <span class="post-date">{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
                                    <span class="post-read-time">{{ $post->reading_time }} min read</span>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-white-50 fs-5">No blog posts found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <nav aria-label="Blog pagination" class="blog-pagination mt-5">
                    {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            @endif
        </div>
    </section>


@endsection

@push('scripts')
<script src="{{ asset('frontend/assets/js/blog.js') }}"></script>
<script>
    // Share functions
    function shareOnFacebook(url) {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
    }
    
    function shareOnTwitter(url, title) {
        window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
    }
    
    function shareOnLinkedIn(url) {
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
    }
</script>
@endpush