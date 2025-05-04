<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\LocationSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class LocationSettingsFactory extends Factory
{
    protected $model = LocationSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
            'structure' => [
                'header' => [],
                'footer' => [],
            ],
            'scripts' => [
                'header' => [],
                'footer' => [],
            ],
            'slug' => 'ae-en',
        ];
    }
}
