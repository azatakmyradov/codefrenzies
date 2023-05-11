<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DashboardCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_if_user_can_access_categories() {
        $response = $this->get('/dashboard/categories');
        $response->assertRedirect('/login');

        $user = User::factory()->create();
        Auth::login($user);

        $this->assertAuthenticated();

        $response = $this->get('/dashboard/categories');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_if_user_can_add_category() {
        $attributes = [
            'name' => fake()->word
        ];

        $response = $this->post('/dashboard/categories', $attributes);
        $response->assertRedirect('/login');

        $user = User::factory()->create();
        Auth::login($user);

        $this->assertAuthenticated();

        $response = $this->post('/dashboard/categories', $attributes);
        $response->assertSessionHas('message', 'Category was created!');
    }

    /** @test */
    public function test_if_user_can_delete_category() {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);

        $response = $this->delete("/dashboard/categories/{$category->id}");
        $response->assertRedirect('/login');

        Auth::login($user);

        $response = $this->delete("/dashboard/categories/{$category->id}");
        $response->assertSessionHas('error', 'This category cannot be deleted');

        $post->delete();

        $response = $this->delete("/dashboard/categories/{$category->id}");
        $response->assertSessionHas('message', 'Category was deleted!');
    }
}
