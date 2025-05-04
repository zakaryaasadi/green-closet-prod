<?php

namespace Database\Factories;

use App\Models\Container;
use App\Models\ContainerDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerDetailsFactory extends Factory
{
    protected $model = ContainerDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'agent_id' => User::factory()->create()->id,
            'container_id' => Container::factory()->create()->id,
            'weight' => $this->faker->numerify,
            'date' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
        ];
    }
}
