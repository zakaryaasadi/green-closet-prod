<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

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
            'country_id' => Country::factory()->create()->id,
            'meta' => [
                'translate' => [
                    'name_ar' => $this->faker->title() . '_ar',
                    'name_en' => $this->faker->title() . '_ar',
                ],
            ],
        ];
    }
}
