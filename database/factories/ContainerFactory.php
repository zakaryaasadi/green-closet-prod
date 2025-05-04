<?php

namespace Database\Factories;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\DischargeShift;
use App\Models\Association;
use App\Models\Container;
use App\Models\Country;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerFactory extends Factory
{
    protected $model = Container::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->text(10),
            'association_id' => Association::factory()->create()->id,
            'team_id' => Team::factory()->create()->id,
            'country_id' => Country::factory()->create()->id,
            'province_id' => Province::factory()->create()->id,
            'district_id' => District::factory()->create()->id,
            'neighborhood_id' => Neighborhood::factory()->create()->id,
            'street_id' => Street::factory()->create()->id,
            'discharge_shift' => DischargeShift::getRandomValue(),
            'type' => ContainerType::getRandomValue(),
            'status' => ContainerStatus::getRandomValue(),
            'location' => new Point($this->faker->latitude, $this->faker->longitude),
            'location_description' => $this->faker->text(255),
        ];
    }
}
