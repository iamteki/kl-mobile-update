@extends('layouts.frontend')

@section('title', $post->meta_title ?: $post->title . ' - KL Mobile Events Blog')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?: $post->content), 160))
@section('meta_keywords', $post->meta_keywords ?: implode(', ', $post->tags ?? []) . ', event management, kuala lumpur')

@section('og_title', $post->meta_title ?: $post->title)
@section('og_description', $post->meta_description ?: $post->excerpt)
@section('og_image', $post->featured_image ? asset('storage/' . $post->featured_image) : asset('frontend/assets/images/kl_mobile_final_logo.jpg'))
@section('og_type', 'article')
@section('og_url', route('blog.show', $post->slug))

@section('twitter_card', 'summary_large_image')
@section('twitter_title', $post->title)
@section('twitter_description', Str::limit(strip_tags($post->excerpt ?: $post->content), 200))
@section('twitter_image', $post->featured_image ? asset('storage/' . $post->featured_image) : asset('frontend/assets/images/kl_mobile_final_logo.jpg'))

@section('canonical_url', route('blog.show', $post->slug))

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blog-single.css') }}">
@endpush

@section('content')
    <!-- Progress Bar -->
    <div class="reading-progress-bar"></div>

    <!-- Blog Header -->
    <header class="blog-single-header">
        <!-- Background Image -->
        <div class="blog-header-bg">
            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1920&h=800&fit=crop' }}" 
                 alt="{{ $post->title }}" 
                 class="header-bg-image">
            <div class="header-overlay"></div>
        </div>
        
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Article</li>
                </ol>
            </nav>
            
            <!-- Category and Tags -->
            <div class="post-tags-header">
                @if($post->category)
                    <span class="category-tag">{{ $post->category->name }}</span>
                @endif
                @if($post->views > 1000)
                    <span class="trending-tag"><i class="fas fa-fire"></i> Trending</span>
                @endif
            </div>
            
            <h1 class="blog-main-title">{{ $post->title }}</h1>
            
            <!-- Meta Info -->
            <div class="blog-meta-header">
                <div class="author-info">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=9333EA&color=fff&size=50" 
                         alt="{{ $post->user->name }}" 
                         class="author-avatar">
                    <div class="author-details">
                        <span class="author-name">{{ $post->user->name }}</span>
                        <span class="author-title">Senior Event Strategist</span>
                    </div>
                </div>
                <div class="post-info">
                    <span class="post-date">
                        <i class="fas fa-calendar"></i> {{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}
                    </span>
                    <span class="read-time">
                        <i class="fas fa-clock"></i> {{ $post->reading_time }} min read
                    </span>
                    <span class="views-count">
                        <i class="fas fa-eye"></i> {{ number_format($post->views) }} views
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Blog Content -->
    <article class="blog-content-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="blog-content">
                        <!-- Lead Paragraph -->
                        @if($post->excerpt)
                            <p class="lead-paragraph">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        <!-- Article Content -->
                        {!! $post->content !!}

                        <!-- Tags -->
                        @if($post->tags && count($post->tags) > 0)
                            <div class="blog-tags">
                                <span class="tag-label">Tags:</span>
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('blog.index', ['search' => $tag]) }}" class="tag-item">{{ $tag }}</a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Share Section -->
                        <div class="blog-share">
                            <h4>Share this article</h4>
                            <div class="share-buttons">
                                <a href="#" class="share-btn facebook" onclick="shareOnFacebook(); return false;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="share-btn twitter" onclick="shareOnTwitter(); return false;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-btn linkedin" onclick="shareOnLinkedIn(); return false;">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="share-btn whatsapp" onclick="shareOnWhatsApp(); return false;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="share-btn email" onclick="shareByEmail(); return false;">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Author Bio -->
                        <div class="author-bio">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=9333EA&color=fff&size=100" 
                                 alt="{{ $post->user->name }}" 
                                 class="bio-avatar">
                            <div class="bio-content">
                                <h4>About {{ $post->user->name }}</h4>
                                <p class="bio-title">Senior Event Strategist at KL Mobile Events</p>
                                <p>{{ $post->user->name }} brings over 15 years of experience in corporate event management and has been instrumental in pioneering innovative event solutions. Their expertise spans traditional event planning and cutting-edge digital experiences.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <!-- Search Widget -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title">Search Articles</h3>
                            <form action="{{ route('blog.index') }}" method="GET" class="sidebar-search">
                                <input type="text" name="search" placeholder="Search..." class="search-input">
                                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="category-list">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('blog.category', $cat->slug) }}">
                                            {{ $cat->name }} 
                                            <span>({{ $cat->blogs_count }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Recent Posts Widget -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title">Recent Posts</h3>
                            <div class="recent-posts">
                                @foreach($recentPosts as $recentPost)
                                    <article class="recent-post">
                                        <img src="{{ $recentPost->featured_image ? asset('storage/' . $recentPost->featured_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=100&h=80&fit=crop' }}" 
                                             alt="{{ $recentPost->title }}">
                                        <div class="recent-post-content">
                                            <h4><a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a></h4>
                                            <span class="post-date">{{ $recentPost->published_at ? $recentPost->published_at->format('F d, Y') : $recentPost->created_at->format('F d, Y') }}</span>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <!-- Newsletter Widget -->
                        {{-- <div class="sidebar-widget newsletter-widget">
                            <h3 class="widget-title">Newsletter</h3>
                            <p>Get the latest event insights delivered to your inbox</p>
                            <form class="newsletter-form" id="sidebar-newsletter">
                                @csrf
                                <input type="email" placeholder="Your email" class="newsletter-input" required>
                                <button type="submit" class="newsletter-submit">Subscribe</button>
                            </form>
                        </div> --}}

                        <!-- Social Widget -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title">Follow Us</h3>
                            <div class="social-widget">
                                <a href="#" class="social-icon-widget facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-widget twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon-widget instagram"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-widget linkedin"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="related-posts-section">
            <div class="container">
                <h2 class="section-title">Related Articles</h2>
                <div class="row g-4">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="col-md-4">
                            <article class="related-post-card">
                                <div class="related-post-image">
                                    <img src="{{ $relatedPost->featured_image ? asset('storage/' . $relatedPost->featured_image) : 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=400&h=250&fit=crop' }}" 
                                         alt="{{ $relatedPost->title }}">
                                    @if($relatedPost->category)
                                        <div class="post-category">{{ $relatedPost->category->name }}</div>
                                    @endif
                                </div>
                                <div class="related-post-content">
                                    <h3><a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a></h3>
                                    <p>{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                                    <span class="post-date">{{ $relatedPost->published_at ? $relatedPost->published_at->format('F d, Y') : $relatedPost->created_at->format('F d, Y') }}</span>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
<script src="{{ asset('frontend/assets/js/blog-single.js') }}"></script>
<script>
    // Share functions with actual URLs
    const pageUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent('{{ $post->title }}');
    
    function shareOnFacebook() {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`, '_blank', 'width=600,height=400');
    }
    
    function shareOnTwitter() {
        window.open(`https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`, '_blank', 'width=600,height=400');
    }
    
    function shareOnLinkedIn() {
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`, '_blank', 'width=600,height=400');
    }
    
    function shareOnWhatsApp() {
        window.open(`https://wa.me/?text=${pageTitle}%20${pageUrl}`, '_blank', 'width=600,height=400');
    }
    
    function shareByEmail() {
        window.location.href = `mailto:?subject=${pageTitle}&body=Check out this article: ${pageUrl}`;
    }
</script>
@endpush