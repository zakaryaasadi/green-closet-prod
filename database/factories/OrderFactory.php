<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Address;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $customer = User::factory()->create();

        return [
            'country_id' => Country::factory()->create()->id,
            'address_id' => Address::factory()->create()->id,
            'customer_id' => $customer->id,
            'agent_id' => User::factory()->create()->id,
            'status' => OrderStatus::getRandomValue(),
            'type' => OrderType::getRandomValue(),
            'start_at' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
            'ends_at' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
            'start_task' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d'),
            'location' => new Point($this->faker->latitude, $this->faker->longitude),
            'weight' => $this->faker->numerify(),
        ];
    }
}
