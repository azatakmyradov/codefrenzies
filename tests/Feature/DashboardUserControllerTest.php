<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_access_dashboard_users(): void
    {
        $this->get('/dashboard/users')
            ->assertRedirect('/login');

        Auth::login(
            User::factory()->create()
        );
        $this->isAuthenticated();

        $this->get('/dashboard/users')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Users/Index')
                ->has('users'));
    }


    /**
     * Only other users can create users
     * @test
     */
    public function test_user_can_create_user() {
        $user = User::factory()->create();

        $this->post('/dashboard/users')
            ->assertRedirect('login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->post('/dashboard/users', [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => fake()->password
        ])
            ->assertRedirect('/dashboard/users')
            ->assertSessionHas('message', 'User created!');
    }

    /**
     * Only other users can edit users
     * @test
     */
    public function test_user_can_edit_user() {
        $user = User::factory()->create();
        $user_second = User::factory()->create();

        $this->get("/dashboard/users/{$user_second->id}/edit")
            ->assertRedirect('/login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->get("/dashboard/users/{$user_second->id}/edit")
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Users/Edit'));
    }

    /**
     * Only other users can edit users
     * @test
     */
    public function test_user_can_update_user() {
        $user = User::factory()->create();
        $user_second = User::factory()->create();

        $this->put("/dashboard/users/{$user_second->id}")
            ->assertRedirect('/login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->put("/dashboard/users/{$user_second->id}", [
            'name' => fake()->name,
            'email' => fake()->email,
        ])
            ->assertSessionHas('message', 'User updated!');
    }

    /**
     * Only other users can delete users
     * @test
     */
    public function test_user_can_delete_user() {
        $user = User::factory()->create();
        $user_second = User::factory()->create();

        $this->delete("/dashboard/users/{$user_second->id}")
            ->assertRedirect('/login');

        Auth::login($user);
        $this->assertAuthenticated();

        $this->delete("/dashboard/users/{$user_second->id}")
            ->assertSessionHas('message', 'User was deleted!');
    }
}
