<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\District;
use App\Models\Language;
use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class NeighborhoodFactory extends Factory
{
    protected $model = Neighborhood::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'ar']);

        return [
            'country_id' => Country::factory()->create()->id,
            'district_id' => District::factory()->create()->id,
            'name' => $this->faker->unique()->name,
            'meta' => [
                'translate' => [
                    'name_ar' => 'name_ar',
                    'name_en' => 'name_en',
                ],
            ],
        ];
    }
}
