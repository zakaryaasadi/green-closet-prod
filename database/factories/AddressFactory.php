<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use App\Models\Province;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'province_id' => Province::factory()->create()->id,
            'location' => new Point($this->faker->latitude, $this->faker->longitude),
            'location_title' => $this->faker->title,
            'location_province' => $this->faker->title,
            'apartment_number' => $this->faker->title,
            'floor_number' => $this->faker->title,
            'building' => $this->faker->title,
        ];
    }
}
