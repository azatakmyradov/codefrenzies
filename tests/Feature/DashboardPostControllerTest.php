<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DashboardPostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if guests can access the dashboard for posts
     */
    public function it_shouldnt_allow_guest_visit(): void
    {
        $response = $this->get('/dashboard/posts');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    /**
     * Tests if authenticated users can access the dashboard
     * @test
     */
    public function it_tests_if_authenticated_users_can_access() {
        $user = User::factory()->create();
        Auth::login($user);
        $this->assertAuthenticated();

        $this->get('/dashboard/posts')
            ->assertStatus(200);
    }

    /**
     * Tests if user can create a post
     * @test
     */
    public function it_tests_if_user_can_create_a_post() {
        $user = User::factory()->create();
        Auth::login($user);
        $this->assertAuthenticated();

        $this->get('/dashboard/posts')
            ->assertStatus(200);

        $category = Category::factory()->create();

        $attributes = $this->getFakeAttributes($category);

        $response = $this->post('/dashboard/posts', $attributes);
        $response->assertSessionHas('message', 'Post was created!');

        $response->assertStatus(302);

        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function test_if_user_can_edit_post() {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        Auth::login($user);

        $this->assertAuthenticated();

        $response = $this->get("/dashboard/posts/{$post->id}/edit");
        $response->assertStatus(200);
    }

    /** @test */
    public function test_if_users_can_update_the_post() {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        Auth::login($user);

        $this->assertAuthenticated();

        $attributes = $this->getFakeAttributes($category);

        $response = $this->put("/dashboard/posts/{$post->id}", $attributes);
        $response->assertSessionHas('message', 'Post updated!');
    }

    /**
     * Checks if user can delete a post
     * @test
     */
    public function it_tests_if_user_can_delete_post() {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        Auth::login($user);

        $this->assertAuthenticated();

        $response = $this->delete("/dashboard/posts/{$post->id}");

        $response->assertStatus(302);
    }

    /**
     * @param mixed $category
     * @return array
     */
    public function getFakeAttributes(mixed $category): array
    {
        return [
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'body' => fake()->paragraph,
            'category_id' => $category->id,
            'seo_description' => fake()->sentence,
            'thumbnail' => fake()->imageUrl,
        ];
    }
}
