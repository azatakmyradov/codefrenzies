<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new FakerProvider($faker));

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'body' => $faker->markdown(),
            'seo_description' => fake()->sentence,
            'thumbnail' => fake()->imageUrl,
            'published_at' => now()
        ];
    }
}
