<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProvinceFactory extends Factory
{
    protected $model = Province::class;

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
