<?php

namespace Database\Factories;

use App\Enums\ActiveStatus;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'ar']);

        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->unique()->name,
            'status' => ActiveStatus::ACTIVE,
            'meta' => [
                'translate' => [
                    'name_ar' => 'name_ar',
                    'name_en' => 'name_en',
                ],
            ],
        ];
    }
}
