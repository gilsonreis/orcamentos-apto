<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Priority>
 */
class PriorityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Baixa', 'Média', 'Alta']),
            'description' => $this->faker->sentence,
            'level' => $this->faker->numberBetween(1, 3),
        ];
    }
}
