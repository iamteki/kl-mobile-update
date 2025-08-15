<!-- Blog Section -->
<section id="blog" class="blog-section section-padding light-bg">
    <div class="container">
        <div class="section-area text-center">
            <span data-animscroll="fade-up">- LATEST INSIGHTS -</span>
            <h2 data-animscroll="fade-up" class="fs-two text-white">FROM OUR <span>BLOG</span></h2>
            <p data-animscroll="fade-up" class="lead mt-3">Stay updated with the latest trends, tips, and insights in event management</p>
        </div>
        
        <div class="row g-4 mt-5">
                 @foreach ($latestBlogs as $key => $blog)
                <!-- Blog Post -->
                <div class="col-lg-4 col-md-6" data-animscroll="fade-up" data-animscroll-delay="{{ $key * 100 }}">
                    <article class="blog-card">
                        <div class="blog-image-wrapper">
                            <img src="{{ $blog->featured_image ?  asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&h=400&fit=crop' }}"
                                alt="{{ $blog->title }}" class="blog-image">
                            @if($blog->category)
                                <div class="blog-category">{{ $blog->category->name }}</div>
                            @endif
                            <div class="blog-date">
                                <span class="day">{{ $blog->published_at ? $blog->published_at->format('d') : $blog->created_at->format('d') }}</span>
                                <span class="month">{{ strtoupper($blog->published_at ? $blog->published_at->format('M') : $blog->created_at->format('M')) }}</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->content), 150) }}</p>
                            <div class="blog-meta">
                                <span class="author">
                                    <i class="fas fa-user"></i> {{ $blog->user->name }}
                                </span>
                                <span class="read-time">
                                    <i class="fas fa-clock"></i> {{ $blog->reading_time }} min read
                                </span>
                            </div>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="blog-read-more">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        
        <!-- View All Posts Button -->
        <div class="text-center mt-5">
            <a href="{{ route('blog.index') }}" class="box-style box-second" data-animscroll="fade-up">
                View All Posts <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="blog-decoration">
        <div class="decoration-circle decoration-1"></div>
        <div class="decoration-circle decoration-2"></div>
    </div>
</section>