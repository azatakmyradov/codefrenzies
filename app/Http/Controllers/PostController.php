<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $page = request()->has('page') ? request('page') : 1;

        $posts = Cache::rememberForever("posts.published.{$page}", function () {
            return Post::whereNot('published_at', null)->latest('published_at')->paginate(8);
        });

        // dd($posts);

        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function show($slug): Response
    {
        $post = Cache::rememberForever("posts.{$slug}", function () use ($slug) {
           return Post::where('slug', $slug)->with('category')->first();
        });

        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    }
}
