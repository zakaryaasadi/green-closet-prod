<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemOrders;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemOrdersFactory extends Factory
{
    protected $model = ItemOrders::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory()->create()->id,
            'order_id' => Order::factory()->create()->id,
            'weight' => $this->faker->numerify,
        ];
    }
}
