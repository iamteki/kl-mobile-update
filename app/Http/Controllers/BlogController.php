<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog listing page
     */
    public function index(Request $request)
    {
        $query = Blog::with(['user', 'category'])
            ->published()
            ->ordered();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $category = $request->get('category');
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Get featured post
        $featuredPost = Blog::with(['user', 'category'])
            ->published()
            ->featured()
            ->latest('created_at')
            ->first();

        // Get regular posts (exclude featured if exists)
        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        $posts = $query->paginate(6);

        // Get categories for filter
        $categories = Category::active()
            ->ordered()
            ->withCount(['blogs' => function ($q) {
                $q->published();
            }])
            ->get();

        return view('blog.index', compact('posts', 'featuredPost', 'categories'));
    }

    /**
     * Display single blog post
     */
    public function show($slug)
    {
        $post = Blog::with(['user', 'category'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        // Get related posts
        $relatedPosts = Blog::with(['user', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereJsonContains('tags', $post->tags);
            })
            ->limit(3)
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Blog::published()
            ->where('id', '!=', $post->id)
            ->latest('created_at')
            ->limit(3)
            ->get();

        // Get categories for sidebar
        $categories = Category::active()
            ->ordered()
            ->withCount(['blogs' => function ($q) {
                $q->published();
            }])
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'recentPosts', 'categories'));
    }

    /**
     * Filter posts by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Blog::with(['user', 'category'])
            ->published()
            ->where('category_id', $category->id)
            ->ordered()
            ->paginate(6);

        $categories = Category::active()
            ->ordered()
            ->withCount(['blogs' => function ($q) {
                $q->published();
            }])
            ->get();

        return view('blog.index', compact('posts', 'category', 'categories'));
    }
}