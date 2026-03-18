<?php

namespace Database\Factories\Page;

use App\Models\Page\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
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
        $title = fake()->words(3, true);
        $slug = str()->slug($title, '-');

        return [
            'slug' => $slug,
            'title' => $title,
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
