<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * Tests if homepage is rendered for everyone
     * @test
     */
    public function test_homepage_is_rendered() {
        $this->get('/')
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Posts/Index')
                ->has('posts'));
    }

    /**
     * Tests if post page is rendered for everyone
     * @test
     */
    public function test_post_page_is_rendered() {
        $post = Post::factory()->create();

        $this->get("/posts/{$post->slug}")
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Posts/Show')
                ->has('post')
                ->where('post.id', $post->id)
                ->where('post.title', $post->title));
    }
}
