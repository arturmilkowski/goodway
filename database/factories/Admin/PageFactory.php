<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $slug = str()->slug($name, '-');

        return [
            'slug' => $slug,
            'name' => $name,
            'intro' => fake()->word(3, true),
            'content' => fake()->word(3, true),
            'site_description' => fake()->words(3, true),
            'site_keyword' => fake()->words(3, true),
            'navbar' => fake()->boolean(),
            'hide' => fake()->boolean(),
            'ordinal' => fake()->numberBetween($min = 1, $max = 10),
        ];
    }
}
