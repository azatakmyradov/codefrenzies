<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if user can access dashboard
     * @test
     */
    public function test_user_can_access_dashboard_categories() {
        $user = User::factory()->create();

        // guests cannot access dashboard
        $this->get('/dashboard/categories')
            ->assertRedirect('/login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->get('/dashboard/categories')
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Categories/Index')
                ->has('categories'));
    }

    /**
     * Test if users can add a category
     * @test
     */
    public function test_user_can_add_category() {
        // guests cannot add a category
        $this->post('/dashboard/categories', [
            'name' => fake()->word
        ])
            ->assertRedirect('/login');

        $user = User::factory()->create();
        Auth::login($user);
        $this->assertAuthenticated();

        $this->post('/dashboard/categories', [
            'name' => fake()->word
        ])
            ->assertSessionHas('message', 'Category was created!');
    }

    /**
     * Tests if user can delete category
     * @test
     */
    public function test_user_can_delete_category() {
        $post = Post::factory()->create();

        // guests cannot delete category
        $this->delete("/dashboard/categories/{$post->category->id}")
            ->assertRedirect('/login');

        Auth::login($post->author);

        // category cannot be deleted if it has posts
        $this->delete("/dashboard/categories/{$post->category->id}")
            ->assertSessionHas('error', 'This category cannot be deleted');

        // delete the post associated with category
        $category = $post->category;
        $post->delete();

        // user should be able to delete category that is not associated with posts
        $this->delete("/dashboard/categories/{$category->id}")
            ->assertSessionHas('message', 'Category was deleted!');
    }
}
