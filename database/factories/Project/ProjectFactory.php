<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
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
            'result' => fake()->word(3, true),
            'site_description' => fake()->words(3, true),
            'site_keyword' => fake()->words(3, true),
            'approved' => fake()->boolean(),
            'hide' => fake()->boolean(),
        ];
    }
}
