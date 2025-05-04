<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\District;
use App\Models\Language;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistrictFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = District::class;

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
            'province_id' => Province::factory()->create()->id,
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
