<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Neighborhood;
use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    protected $model = Street::class;

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
            'neighborhood_id' => Neighborhood::factory()->create()->id,
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
