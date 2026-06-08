<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraphs(2, true),
            'image' => null,
            'prep_time' => fake()->numberBetween(5, 60),
            'cook_time' => fake()->numberBetween(10, 120),
            'servings' => fake()->numberBetween(1, 8),
        ];
    }
}
