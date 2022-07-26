<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->randomElement(['Dog','Cat','Snake']);
        $slug = Str::slug($title);

        return [
            //
            'uuid' => fake()->uuid(),
            'title' => $title,
            'slug' => $slug
        ];
    }
}
