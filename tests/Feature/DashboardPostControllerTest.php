<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardPostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if guests can access the dashboard for posts
     */
    public function test_guests_cannot_visit_dashboard_posts(): void
    {
        $this->get('/dashboard/posts')
            ->assertRedirect('/login')
            ->assertStatus(302);
    }

    /**
     * Tests if authenticated users can access the dashboard
     * @test
     */
    public function test_authenticated_user_can_access_dashboard_posts() {
        $user = User::factory()->create();

        Auth::login($user);
        $this->assertAuthenticated();

        $this->get('/dashboard/posts')
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Posts/Index')
                ->has('posts'));
    }

    /** @test */
    public function test_user_can_access_create_post_page() {
        $this->get('/dashboard/posts/create')
            ->assertRedirect('/login');

        Auth::login(
            User::factory()->create()
        );

        $this->get('/dashboard/posts/create')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Posts/Create'));
    }

    /**
     * Tests if user can create a post
     * @test
     */
    public function test_user_can_create_a_post() {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // guests cannot create posts
        $this->post('/dashboard/posts')
            ->assertRedirect('/login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->post('/dashboard/posts', [
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'body' => fake()->paragraph,
            'category_id' => $category->id,
            'seo_description' => fake()->sentence,
            'thumbnail' => fake()->imageUrl,
        ])
            ->assertSessionHas('message', 'Post was created!')
            ->assertStatus(302);
    }

    /**
     * Tests if user can access post edit page
     * @test
     */
    public function test_user_can_access_post_edit_page() {
        $post = Post::factory()->create();

        // guests cannot edit posts
        $this->get("/dashboard/posts/{$post->id}/edit")
            ->assertRedirect('/login');

        Auth::login($post->author);
        $this->assertAuthenticated();

        $this->get("/dashboard/posts/{$post->id}/edit")
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Posts/Edit')
                ->has('post'));
    }

    /**
     * Test if user can update the post
     * @test
     */
    public function test_user_can_update_the_post() {
        $post = Post::factory()->create();

        // guests should not be able to update post
        $this->put("/dashboard/posts/{$post->id}", [
            ...$post->toArray(),
            'title' => fake()->sentence,
        ])
            ->assertRedirect('/login');

        // Authenticate user
        Auth::login($post->author);
        $this->assertAuthenticated();

        // check if user can create a post
        $this->put("/dashboard/posts/{$post->id}", [
            ...$post->toArray(),
            'title' => fake()->sentence,
        ])
            ->assertSessionHas('message', 'Post updated!');
    }

    /**
     * Tests if users can delete a post
     * @test
     */
    public function test_user_can_delete_post() {
        $post = Post::factory()->create();

        $this->delete("/dashboard/posts/{$post->id}")
            ->assertRedirect('/login');

        Auth::login($post->author);
        $this->assertAuthenticated();

        $this->delete("/dashboard/posts/{$post->id}")
            ->assertStatus(302);
    }
}
