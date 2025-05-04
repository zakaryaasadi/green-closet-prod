<?php

namespace Database\Factories;

use App\Enums\ExpenseStatus;
use App\Models\Association;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'containers_count' => $this->faker->numerify,
            'orders_count' => $this->faker->numerify,
            'orders_weight' => $this->faker->numerify,
            'containers_weight' => $this->faker->numerify,
            'weight' => $this->faker->numerify,
            'value' => $this->faker->numerify,
            'date' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
            'status' => ExpenseStatus::getRandomValue(),
            'association_id' => Association::factory()->create()->id,
        ];

    }
}
