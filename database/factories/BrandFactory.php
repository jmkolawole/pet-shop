<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->unique()->randomElement(['Blue Bufallo','Ainsworth','Freshpet']);
        $slug = Str::slug($title);

        return [
            //
            'uuid' => fake()->uuid(),
            'title' => $title,
            'slug' => $slug
        ];
    }
}
