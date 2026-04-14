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
        return [
            'navbar' => fake()->boolean(),
            'hide' => fake()->boolean(),
            'ordinal' => fake()->numberBetween($min = 1, $max = 10),
        ];
    }
}
