<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 50, 10000);
        $stalement = $this->faker->numberBetween(1, 12);
        $stalement_value = round($price / $stalement, 2);

        return [
            'name' => $this->faker->word,
            'supplier_id' => Supplier::query()->inRandomOrder()->first()?->id,
            'category_id' => Category::query()->inRandomOrder()->first()?->id,
            'priority_id' => Priority::query()->inRandomOrder()->first()?->id,
            'price' => $price,
            'description' => $this->faker->sentence,
            'due_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(array_keys(Budget::STATUS_OPTIONS)),
            'stalement' => $stalement,
            'stalement_value' => $stalement_value,
            'stalement_start' => $this->faker->date(),
        ];
    }
}
