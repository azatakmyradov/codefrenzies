<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Cache::rememberForever('posts.published', function () {
            return Post::whereNot('published_at', null)->latest('published_at')->get();
        });

        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function show($slug)
    {
        $post = Cache::rememberForever("posts.{$slug}", function () use ($slug) {
           return Post::where('slug', $slug)->with('category')->first();
        });

        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    }
}
