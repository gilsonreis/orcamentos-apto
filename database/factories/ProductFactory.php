<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(5, true), // Gera um nome aleatório
            'description' => $this->faker->sentence(40), // Gera uma descrição aleatória
            'ideal_price' => $this->faker->randomFloat(2, 2000, 10000), // Gera um valor entre 50 e 1000
        ];
    }
}
