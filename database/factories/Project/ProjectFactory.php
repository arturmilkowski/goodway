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
        return [
            'approved' => fake()->boolean(),
            'hide' => fake()->boolean(),
        ];
    }
}
