<?php

namespace Database\Factories;

use App\Enums\PointStatus;
use App\Models\Country;
use App\Models\Order;
use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PointFactory extends Factory
{
    protected $model = Point::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'country_id' => Country::factory()->create()->id,
            'order_id' => Order::factory()->create()->id,
            'used' => $this->faker->boolean,
            'status' => PointStatus::getRandomValue(),
            'ends_at' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s'),
            'count' => $this->faker->numerify(),
        ];
    }
}
