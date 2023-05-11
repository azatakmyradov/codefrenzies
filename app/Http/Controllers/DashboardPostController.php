<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DashboardPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $posts = auth()->user()->posts()->with(['author:id,name', 'category:id,name'])->latest()->get();

        return Inertia::render('Dashboard/Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Posts/Create', [
            'categories' => Category::select(['id', 'name'])->get()
        ]);
    }

    public function store(PostRequest $request)
    {
        $attributes = $request->validated();

        $attributes['published_at'] = request()->get('publishNow')
            ? now()
            : request()->get('published_at');

        if (! request()->get('published_at') && ! request()->get('publishNow')) $attributes['published_at'] = null;

        auth()->user()->posts()->create($attributes);

        Cache::forget('posts.published');

        return redirect('/dashboard/posts')->with('message', 'Post was created!');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Dashboard/Posts/Edit', [
            'post' => $post,
            'categories' => Category::select(['id', 'name'])->get()
        ]);
    }

    public function update(Post $post, PostRequest $request)
    {
        $attributes = $request->validated();

        if ($post->published_at === null) {
            $attributes['published_at'] = request()->get('publishNow')
                ? now()
                : request()->get('published_at');

            if (! request()->get('published_at') && ! request()->get('publishNow')) $attributes['published_at'] = null;
        }

        $post->update($attributes);

        Cache::forget('posts.published');
        Cache::forget('posts.' . $post->slug);

        return back()->with('message', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        if (! $post->author()->is(auth()->user())) {
            return back()->with('message', "This post doesn't belong to you");
        }

        try {
            $post->deleteOrFail();
        } catch (\Throwable $e) {
            return back()->with('message', 'Something went wrong!');
        }

        return back()->with('message', 'Post was deleted!');
    }
}
