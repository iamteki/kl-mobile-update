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
            ->where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

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

        // Get all posts (including featured ones)
        $posts = $query->paginate(9);

        // Get categories for filter
        $categories = Category::where('status', 1)
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    /**
     * Display single blog post
     */
    public function show($slug)
    {
        $post = Blog::with(['user', 'category'])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        // Get related posts
        $relatedPosts = Blog::with(['user', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                if ($post->category_id) {
                    $query->where('category_id', $post->category_id);
                }
                if ($post->tags && is_array($post->tags)) {
                    foreach ($post->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Blog::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('created_at')
            ->limit(3)
            ->get();

        // Get categories for sidebar
        $categories = Category::where('status', 1)
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'recentPosts', 'categories'));
    }

    /**
     * Filter posts by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $posts = Blog::with(['user', 'category'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->orderBy('is_featured', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = Category::where('status', 1)
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();

        return view('blog.index', compact('posts', 'category', 'categories'));
    }
}