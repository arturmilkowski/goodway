<?php

namespace Database\Factories\Blog\Post;

use App\Models\Blog\Post\PostTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostTranslation>
 */
class PostTranslationFactory extends Factory
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
            'locale' => fake()->randomElement(['pl', 'en', 'de', 'fr', 'es']),
            'slug' => $slug,
            'title' => $title,
            'intro' => fake()->word(3, true),
            'content' => fake()->word(3, true),
            'site_description' => fake()->words(3, true),
            'site_keyword' => fake()->words(3, true),
        ];
    }
}
