<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $user = \App\Models\User::factory()->create([
             'name' => 'Azat Akmyradov',
             'email' => 'azat@akmyradov.me',
             'password' => bcrypt('password')
         ]);

        \App\Models\Post::factory(10)->create(['user_id' => $user->id]);
        \App\Models\Post::factory()->create([
            'user_id' => $user->id,
            'published_at' => null
        ]);
    }
}
