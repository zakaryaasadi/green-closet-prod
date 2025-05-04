<?php

namespace Database\Factories;

use App\Enums\MonthsEnum;
use App\Models\Country;
use App\Models\Target;
use Illuminate\Database\Eloquent\Factories\Factory;

class TargetFactory extends Factory
{
    protected $model = Target::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        return [
            'orders_count' => $this->faker->numberBetween(1, 10000),
            'country_id' => Country::factory()->create()->id,
            'weight_target' => $this->faker->numberBetween(1, 1000),
            'month' => MonthsEnum::getRandomValue(),
        ];
    }
}
