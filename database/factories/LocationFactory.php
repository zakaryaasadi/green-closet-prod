<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Location;
use App\Models\Province;
use App\Models\Team;
use GeoJson\GeoJson;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $first = [$this->faker->longitude, $this->faker->latitude];
        $second = [$this->faker->longitude, $this->faker->latitude];
        $third = [$this->faker->longitude, $this->faker->latitude];
        $fourth = [$this->faker->longitude, $this->faker->latitude];
        $gardens = GeoJson::jsonUnserialize([
                'type' => 'Polygon',
                'coordinates' => [[
                    $first,
                    $second,
                    $third,
                    $fourth,
                    $first,
                ],
                ],]
        );
        $polygon = Polygon::fromJson($gardens);

        return [
            'name' => $this->faker->name(),
            'color' => substr($this->faker->hexColor, 1),
            'area' => $polygon,
            'country_id' => Country::factory()->create()->id,
            'province_id' => Province::factory()->create()->id,
            'team_id' => Team::factory()->create()->id,
        ];
    }
}
